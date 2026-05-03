<?php

namespace App\Http\Controllers\Fundraiser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function index()
    {
        // Mengambil user beserta data citizen-nya
        $user = Auth::user()->load('citizen'); 
        return view('fundraiser.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $citizen = $user->citizen;

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
            'profile_picture' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:1024'], // Validasi foto
        ]);

        // Update data User
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        // Update Profile Picture di tabel Citizens
        if ($request->hasFile('profile_picture') && $citizen) {
            // Hapus foto lama jika ada
            if ($citizen->profile_picture) {
                Storage::disk('public')->delete($citizen->profile_picture);
            }

            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $citizen->update(['profile_picture' => $path]);
        }

        return back()->with('success', 'Profil dan foto berhasil diperbarui!');
    }

    public function destroy(Request $request)
    {
        $user = Auth::user();

        $request->validate(['password_confirmation' => 'required']);

        if (!Hash::check($request->password_confirmation, $user->password)) {
            return back()->with('error', 'Konfirmasi password salah.');
        }

        $entities = $user->entities()->with('campaigns.donations', 'campaigns.withdraws')->get();

        foreach ($entities as $entity) {
            foreach ($entity->campaigns as $campaign) {
                $totalDonations = $campaign->donations->where('status', 'approved')->sum('amount');
                $totalWithdrawals = $campaign->withdraws->where('status', 'approved')->sum('amount');
                $balance = $totalDonations - $totalWithdrawals;

                if ($balance > 0) {
                    return back()->with('error', "Gagal! Lembaga '{$entity->name}' memiliki campaign '{$campaign->title}' dengan saldo aktif.");
                }
            }
        }

        foreach ($entities as $entity) {
            if ($entity->logo_path) Storage::disk('public')->delete($entity->logo_path);
            if ($entity->legal_document_path) Storage::disk('public')->delete($entity->legal_document_path);
            
            $entity->delete();
        }

        if ($user->citizen) {
            $citizen = $user->citizen;
            if ($citizen->profile_picture) Storage::disk('public')->delete($citizen->profile_picture);
            if ($citizen->id_card_path) Storage::disk('public')->delete($citizen->id_card_path);
            if ($citizen->selfie_path) Storage::disk('public')->delete($citizen->selfie_path);
            
            $citizen->delete();
        }

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Akun dan seluruh data lembaga Anda telah dihapus.');
    }
}
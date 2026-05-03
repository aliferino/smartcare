<?php

namespace App\Http\Controllers\Fundraiser;

use App\Http\Controllers\Controller;
use App\Models\Citizen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KycController extends Controller
{
    public function showKycForm()
    {
        return view('fundraiser.kyc-form');
    }

    public function submitKyc(Request $request)
    {
        $request->validate([
            'full_name'    => 'required|string|max:255',
            'id_number'    => 'required|string|unique:citizens,id_number',
            'birth_date'   => 'required|date',
            'gender'       => 'required|in:male,female',
            'phone_number' => 'required|string',
            'address'      => 'required|string',
            'id_card_path' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'selfie_path'  => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Simpan file dengan path yang rapi
        $idCardPath = $request->file('id_card_path')->store('kyc/id_cards', 'public');
        $selfiePath = $request->file('selfie_path')->store('kyc/selfies', 'public');

        $citizen = Citizen::create([
            'full_name'    => $request->full_name,
            'id_number'    => $request->id_number,
            'birth_date'   => $request->birth_date,
            'gender'       => $request->gender,
            'phone_number' => $request->phone_number,
            'address'      => $request->address,
            'id_card_path' => $idCardPath,
            'selfie_path'  => $selfiePath,
            'status'       => 'pending', // Pakai 'status' sesuai database kamu!
        ]);

        // Update user: pastikan kolom citizen_id ada di tabel users
        Auth::user()->update(['citizen_id' => $citizen->id]);

        return redirect()->route('fundraiser.index')->with('success', 'Verification submitted!');
    }
}
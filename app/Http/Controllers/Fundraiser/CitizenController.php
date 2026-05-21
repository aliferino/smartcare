<?php

namespace App\Http\Controllers\Fundraiser;

use App\Http\Controllers\Controller;
use App\Models\Citizen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CitizenController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $citizen = $user->citizen;

        // If citizen data exists and status is pending, show pending page
        if ($citizen && $citizen->status === 'pending') {
            return view('fundraiser.citizen.pending', compact('citizen'));
        }

        // If citizen data exists and status is approved, redirect to dashboard
        if ($citizen && $citizen->status === 'approved') {
            return redirect()->route('fundraiser.index')
                ->with('success', 'Your account is already verified!');
        }

        // Otherwise show the form (no citizen data or status is rejected)
        return view('fundraiser.citizen.index', compact('citizen'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'id_number' => 'required|numeric|digits_between:1,20|unique:citizens,id_number',
            'birth_date' => 'required|date',
            'gender' => 'required|in:male,female',
            'phone_number' => 'required|numeric|digits_between:1,15',
            'address' => 'required|string',
            'id_card_path' => 'required|image|mimes:jpeg,png,jpg|max:5120',
            'selfie_path' => 'required|image|mimes:jpeg,png,jpg|max:5120',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        // Upload files
        $idCardPath = $request->file('id_card_path')->store('kyc/id_cards', 'public');
        $selfiePath = $request->file('selfie_path')->store('kyc/selfies', 'public');
        $profilePicture = $request->hasFile('profile_picture')
            ? $request->file('profile_picture')->store('profiles', 'public')
            : null;

        // Create citizen record
        $citizen = Citizen::create([
            'user_id' => Auth::id(),
            'full_name' => $validated['full_name'],
            'id_number' => $validated['id_number'],
            'birth_date' => $validated['birth_date'],
            'gender' => $validated['gender'],
            'phone_number' => $validated['phone_number'],
            'address' => $validated['address'],
            'id_card_path' => $idCardPath,
            'selfie_path' => $selfiePath,
            'profile_picture' => $profilePicture,
            'status' => 'pending',
        ]);

        return redirect()->route('fundraiser.citizen.index')
            ->with('success', 'KYC data submitted successfully. Waiting for admin verification.');
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $citizen = $user->citizen;

        if (!$citizen) {
            return redirect()->back()->with('error', 'Citizen data not found.');
        }

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'id_number' => 'required|numeric|digits_between:1,20|unique:citizens,id_number,' . $citizen->id,
            'birth_date' => 'required|date',
            'gender' => 'required|in:male,female',
            'phone_number' => 'required|numeric|digits_between:1,15',
            'address' => 'required|string',
            'id_card_path' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'selfie_path' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        // Update files if uploaded
        if ($request->hasFile('id_card_path')) {
            if ($citizen->id_card_path) {
                Storage::disk('public')->delete($citizen->id_card_path);
            }
            $validated['id_card_path'] = $request->file('id_card_path')->store('kyc/id_cards', 'public');
        }

        if ($request->hasFile('selfie_path')) {
            if ($citizen->selfie_path) {
                Storage::disk('public')->delete($citizen->selfie_path);
            }
            $validated['selfie_path'] = $request->file('selfie_path')->store('kyc/selfies', 'public');
        }

        if ($request->hasFile('profile_picture')) {
            if ($citizen->profile_picture) {
                Storage::disk('public')->delete($citizen->profile_picture);
            }
            $validated['profile_picture'] = $request->file('profile_picture')->store('profiles', 'public');
        }

        // Reset status to pending when updating
        $validated['status'] = 'pending';
        $validated['verified_at'] = null;
        $validated['verified_by'] = null;
        $validated['reject_reason'] = null;

        $citizen->update($validated);

        return redirect()->route('fundraiser.citizen.index')
            ->with('success', 'KYC data updated successfully. Waiting for admin verification.');
    }
}

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
        $user = Auth::user();
        $citizen = $user->citizen;

        return view('fundraiser.profile.index', compact('user', 'citizen'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'password' => ['nullable', 'confirmed', Password::min(8)],
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Update name
        $user->name = $validated['name'];

        // Update password if provided
        if ($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
        }

        // Update profile picture if provided
        if ($request->hasFile('profile_picture')) {
            $citizen = $user->citizen;

            if ($citizen) {
                // Delete old profile picture if exists
                if ($citizen->profile_picture) {
                    Storage::disk('public')->delete($citizen->profile_picture);
                }

                // Upload new profile picture
                $path = $request->file('profile_picture')->store('profiles', 'public');
                $citizen->update(['profile_picture' => $path]);
            }
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully!');
    }
}

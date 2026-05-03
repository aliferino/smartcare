<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // Tambahkan kondisi is_active => true agar akun yang dibanned tidak bisa login
        if (Auth::attempt(array_merge($credentials, ['is_active' => true]))) {
            $request->session()->regenerate();
            
            // Redirect berdasarkan role
            return Auth::user()->role === 'admin' 
                ? redirect()->route('admin.index') 
                : redirect()->route('fundraiser.index');
        }

        // Jika login gagal karena password salah ATAU akun tidak aktif
        return back()->withErrors([
            'email' => 'Email/Password salah atau akun Anda sedang dinonaktifkan.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
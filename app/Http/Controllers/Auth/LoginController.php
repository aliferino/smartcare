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

        // Cari user berdasarkan email dulu untuk cek statusnya
        $user = \App\Models\User::where('email', $request->email)->first();

        // Jika user ditemukan dan statusnya 'banned', langsung tolak login
        if ($user && $user->status === 'banned') {
            return back()->withErrors([
                'email' => 'Akun Anda telah diblokir secara permanen.',
            ]);
        }

        // Jika bukan banned, coba login secara normal
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            return Auth::user()->role === 'admin' 
                ? redirect()->route('admin.index') 
                : redirect()->route('fundraiser.index');
        }

        return back()->withErrors([
            'email' => 'Email atau Password yang Anda masukkan salah.',
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
@extends('layouts.layout', ['title' => 'Register - SmartCare'])

@section('body')
<div class="relative flex items-center justify-center min-h-screen p-4 bg-gradient-to-br from-blue-50 via-white to-slate-50 overflow-hidden">
    <div class="absolute top-0 left-0 w-96 h-96 bg-blue-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
    <div class="absolute top-0 right-0 w-96 h-96 bg-purple-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
    <div class="absolute bottom-0 left-1/2 w-96 h-96 bg-pink-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-4000"></div>

    <div class="relative w-full max-w-[480px] bg-white/80 backdrop-blur-sm rounded-3xl shadow-[0_20px_60px_rgba(0,0,0,0.08)] border border-white/50 p-10">

        <div class="text-center mb-8">
            <h2 class="text-3xl font-black text-blue-600 tracking-tight mb-2">Create Account</h2>
            <p class="text-slate-500 text-sm">Join our fundraiser community today</p>
        </div>

        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="mb-5">
                <label class="block text-xs font-bold text-slate-700 mb-2 ml-1 uppercase tracking-wider">Full Name</label>
                <input type="text" name="name" value="{{ old('name') }}"
                    class="w-full bg-slate-50 px-4 py-3.5 text-sm rounded-xl border-2 border-slate-200 focus:border-blue-600 focus:bg-white outline-none transition-all placeholder:text-slate-400"
                    placeholder="Enter your full name">
                @error('name') <p class="text-xs text-red-500 mt-2 ml-1 font-medium">{{ $message }}</p> @enderror
            </div>

            <div class="mb-5">
                <label class="block text-xs font-bold text-slate-700 mb-2 ml-1 uppercase tracking-wider">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}"
                    class="w-full bg-slate-50 px-4 py-3.5 text-sm rounded-xl border-2 border-slate-200 focus:border-blue-600 focus:bg-white outline-none transition-all placeholder:text-slate-400"
                    placeholder="Enter your email">
                @error('email') <p class="text-xs text-red-500 mt-2 ml-1 font-medium">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4 mb-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-2 ml-1 uppercase tracking-wider">Password</label>
                    <input type="password" name="password" id="password-register"
                        class="w-full bg-slate-50 px-4 py-3.5 text-sm rounded-xl border-2 border-slate-200 focus:border-blue-600 focus:bg-white outline-none transition-all placeholder:text-slate-400"
                        placeholder="••••••••">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-2 ml-1 uppercase tracking-wider">Confirm</label>
                    <input type="password" name="password_confirmation" id="password-confirm"
                        class="w-full bg-slate-50 px-4 py-3.5 text-sm rounded-xl border-2 border-slate-200 focus:border-blue-600 focus:bg-white outline-none transition-all placeholder:text-slate-400"
                        placeholder="••••••••">
                </div>
            </div>
            @error('password') <p class="text-xs text-red-500 mb-4 ml-1 font-medium">{{ $message }}</p> @enderror

            <div class="flex items-center mb-6 ml-1">
                <input type="checkbox" id="show-password-register" onchange="togglePasswords(this)"
                    class="w-4 h-4 rounded border-slate-300 text-blue-600 cursor-pointer accent-blue-600">
                <label for="show-password-register" class="ml-2 text-xs text-slate-500 cursor-pointer select-none">Show password</label>
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold py-4 rounded-xl transition-all active:scale-[0.98] mb-6 tracking-wide shadow-lg shadow-blue-600/30 hover:shadow-xl hover:shadow-blue-600/40">
                REGISTER NOW
            </button>

            <div class="text-center">
                <p class="text-sm text-slate-500 font-medium">
                    Already have an account? <a href="{{ route('login') }}" class="text-blue-600 font-bold hover:text-blue-700 transition-colors">Sign In</a>
                </p>
            </div>
        </form>
    </div>
</div>

<style>
@keyframes blob {
    0%, 100% { transform: translate(0, 0) scale(1); }
    33% { transform: translate(30px, -50px) scale(1.1); }
    66% { transform: translate(-20px, 20px) scale(0.9); }
}
.animate-blob { animation: blob 7s infinite; }
.animation-delay-2000 { animation-delay: 2s; }
.animation-delay-4000 { animation-delay: 4s; }
</style>

<script>
function togglePasswords(checkbox) {
    const type = checkbox.checked ? 'text' : 'password';
    document.getElementById('password-register').type = type;
    document.getElementById('password-confirm').type = type;
}
</script>
@endsection
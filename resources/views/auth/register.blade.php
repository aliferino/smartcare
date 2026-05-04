@extends('layouts.layout', ['title' => 'Register - SmartCare'])

@section('body')
<div class="flex items-center justify-center min-h-screen p-4">
    <div class="w-full max-w-[380px] bg-white rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 p-8">
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-slate-900 tracking-tight">SmartCare Register</h2>
            <p class="text-slate-400 text-[13px] mt-1">Join our fundraiser community</p>
        </div>

        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-[12px] font-medium text-slate-500 mb-1.5 ml-1">Full Name</label>
                <input type="text" name="name" value="{{ old('name') }}"
                    class="w-full bg-white px-4 py-2 text-sm rounded-lg border border-slate-200 focus:border-slate-900 outline-none transition-all placeholder:text-slate-300" 
                    placeholder="Nama sesuai identitas">
                @error('name') <p class="text-[10px] text-red-500 mt-1 ml-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-[12px] font-medium text-slate-500 mb-1.5 ml-1">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}"
                    class="w-full bg-white px-4 py-2 text-sm rounded-lg border border-slate-200 focus:border-slate-900 outline-none transition-all placeholder:text-slate-300" 
                    placeholder="name@example.com">
                @error('email') <p class="text-[10px] text-red-500 mt-1 ml-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-3 mb-6">
                <div>
                    <label class="block text-[12px] font-medium text-slate-500 mb-1.5 ml-1">Password</label>
                    <input type="password" name="password" 
                        class="w-full bg-white px-4 py-2 text-sm rounded-lg border border-slate-200 focus:border-slate-900 outline-none transition-all placeholder:text-slate-300" 
                        placeholder="••••••••">
                </div>
                <div>
                    <label class="block text-[12px] font-medium text-slate-500 mb-1.5 ml-1">Confirm</label>
                    <input type="password" name="password_confirmation" 
                        class="w-full bg-white px-4 py-2 text-sm rounded-lg border border-slate-200 focus:border-slate-900 outline-none transition-all placeholder:text-slate-300" 
                        placeholder="••••••••">
                </div>
            </div>
            @error('password') <p class="text-[10px] text-red-500 mt-[-18px] mb-4 ml-1">{{ $message }}</p> @enderror

            <button type="submit" class="w-full bg-[#333841] hover:bg-black text-white text-sm font-bold py-3 rounded-lg transition-all active:scale-[0.98] mb-6 tracking-wide">
                REGISTER NOW
            </button>

            <div class="text-center">
                <p class="text-[12px] text-slate-400 font-medium">
                    Already registered? <a href="{{ route('login') }}" class="text-slate-900 font-bold ml-1">Sign In</a>
                </p>
            </div>
        </form>
    </div>
</div>
@endsection
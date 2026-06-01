@extends('layouts.panel', ['title' => 'My Profile'])

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-black text-slate-900 uppercase">My Profile</h1>
    <p class="text-slate-500 text-xs font-medium uppercase tracking-widest opacity-70">Update your profile information</p>
</div>

@if(session('success'))
<div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl">
    <p class="text-sm font-bold text-emerald-700">{{ session('success') }}</p>
</div>
@endif

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <form method="POST" action="{{ route('fundraiser.profile.update') }}" enctype="multipart/form-data" class="p-6">
        @csrf
        @method('PUT')

        <!-- Profile Picture -->
        <div class="mb-6">
            <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Profile Picture</label>
            <div class="flex items-center gap-6">
                <div class="w-24 h-24 rounded-full overflow-hidden bg-slate-100 flex items-center justify-center">
                    @if($citizen && $citizen->profile_picture)
                        <img id="profilePreview" src="{{ asset('storage/' . $citizen->profile_picture) }}" class="w-full h-full object-cover" alt="Profile">
                    @else
                        <span id="profileInitial" class="text-3xl font-black text-slate-400">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                        <img id="profilePreview" src="" class="w-full h-full object-cover hidden" alt="Profile">
                    @endif
                </div>
                <div class="flex-1">
                    <input type="file" id="profile_picture" name="profile_picture" accept="image/*" class="hidden">
                    <button type="button" onclick="document.getElementById('profile_picture').click()" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-xl font-bold transition-colors">
                        Choose Photo
                    </button>
                    <p class="text-xs text-slate-500 mt-2">JPG, PNG or JPEG. Max 2MB.</p>
                    @error('profile_picture')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Email (Readonly) -->
        <div class="mb-6">
            <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Email Address</label>
            <input type="email" value="{{ $user->email }}" readonly
                class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 bg-slate-50 text-slate-500 outline-none cursor-not-allowed text-sm">
            <p class="text-xs text-slate-500 mt-1">Email cannot be changed</p>
        </div>

        <!-- Name -->
        <div class="mb-6">
            <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Full Name</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 focus:border-blue-600 outline-none transition-all text-sm">
            @error('name')
                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-6">
            <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">New Password</label>
            <input type="password" name="password" placeholder="Leave blank to keep current password"
                class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 focus:border-blue-600 outline-none transition-all text-sm">
            @error('password')
                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mb-6">
            <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Confirm New Password</label>
            <input type="password" name="password_confirmation" placeholder="Confirm your new password"
                class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 focus:border-blue-600 outline-none transition-all text-sm">
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
            <a href="{{ route('fundraiser.index') }}" class="px-6 py-3 border-2 border-slate-200 text-slate-600 rounded-xl text-sm font-bold hover:bg-slate-50 transition-colors">
                Cancel
            </a>
            <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-bold transition-colors">
                Save Changes
            </button>
        </div>
    </form>
</div>

<script>
// Preview profile picture before upload
document.getElementById('profile_picture').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('profilePreview');
            const initial = document.getElementById('profileInitial');
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            if (initial) initial.classList.add('hidden');
        }
        reader.readAsDataURL(file);
    }
});
</script>
@endsection

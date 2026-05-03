<x-layout-fundraiser>
    <x-slot:title>Pengaturan Profil</x-slot:title>

    {{-- Notification Overlay --}}
    @if(session('success'))
    <div id="flash-notification" class="fixed top-6 right-6 z-[100] max-w-sm w-full animate-in fade-in slide-in-from-right duration-300">
        <div class="bg-white border-l-4 border-emerald-500 shadow-2xl rounded-2xl p-4 flex items-center gap-4">
            <div class="flex-shrink-0 w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center text-emerald-600">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            </div>
            <div class="flex-1">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Sistem</p>
                <p class="text-sm font-bold text-slate-700">{{ session('success') }}</p>
            </div>
        </div>
    </div>
    <script>
        setTimeout(() => {
            const notif = document.getElementById('flash-notification');
            if(notif) {
                notif.classList.add('opacity-0', 'transition-opacity', 'duration-500');
                setTimeout(() => notif.remove(), 500);
            }
        }, 3000);
    </script>
    @endif

    <div class="max-w-5xl mx-auto">
        {{-- Top Header --}}
        <div class="mb-10 flex justify-between items-end">
            <div>
                <h1 class="text-3xl font-extrabold text-[#0c4a6e] tracking-tight">Pengaturan Profil</h1>
                <p class="text-sky-600/70 font-medium mt-1">Kelola eksistensi digital dan keamanan akun Anda.</p>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center gap-2 px-5 py-2.5 text-red-500 bg-red-50 hover:bg-red-100 rounded-xl transition-all font-bold text-xs uppercase tracking-widest border border-red-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Keluar Sesi
                </button>
            </form>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            {{-- Kolom Kiri: Avatar & KYC --}}
            <div class="lg:col-span-4 space-y-6">
                <div class="bg-white p-8 rounded-[2.5rem] border border-sky-100 shadow-xl shadow-sky-900/5 text-center relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-24 bg-gradient-to-b from-sky-50 to-white"></div>
                    
                    <div class="relative z-10">
                        {{-- Form Khusus Upload Foto --}}
                        <form action="{{ route('fundraiser.profile.update') }}" method="POST" enctype="multipart/form-data" id="avatarForm">
                            @csrf
                            @method('PUT')
                            <div class="relative inline-block group">
                                <img id="display-avatar" class="w-32 h-32 mx-auto rounded-[2.5rem] ring-4 ring-white shadow-xl object-cover transition-transform group-hover:scale-105" 
                                     src="{{ $user->citizen?->profile_picture ? asset('storage/' . $user->citizen->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=0ea5e9&color=fff&size=128' }}">
                                
                                <label for="profile_picture" class="absolute inset-0 flex items-center justify-center bg-black/40 rounded-[2.5rem] opacity-0 group-hover:opacity-100 transition-all cursor-pointer">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </label>
                                <input type="file" name="profile_picture" id="profile_picture" class="hidden" accept="image/*" onchange="document.getElementById('avatarForm').submit();">
                            </div>
                        </form>

                        <h2 class="mt-6 font-extrabold text-xl text-[#0c4a6e]">{{ $user->name }}</h2>
                        <p class="text-sm text-sky-600/60 mb-6 font-semibold">{{ $user->email }}</p>

                        <div class="inline-flex items-center gap-2 px-4 py-1.5 {{ $user->citizen?->status == 'approved' ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600' }} rounded-full border border-current/10">
                            <span class="w-2 h-2 rounded-full bg-current animate-pulse"></span>
                            <span class="text-[11px] font-extrabold uppercase tracking-widest">{{ $user->citizen?->status ?? 'Unverified' }}</span>
                        </div>
                    </div>
                </div>

                @if($user->citizen)
                <div class="bg-white p-8 rounded-[2.5rem] border border-sky-100 shadow-sm">
                    <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4">Informasi Identitas</h4>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-[10px] text-sky-600/50 font-bold uppercase">NIK Terdaftar</label>
                            <p class="font-bold text-[#0c4a6e]">{{ $user->citizen->id_number }}</p>
                        </div>
                        <div>
                            <label class="block text-[10px] text-sky-600/50 font-bold uppercase">Nomor WhatsApp</label>
                            <p class="font-bold text-[#0c4a6e]">{{ $user->citizen->phone_number }}</p>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            {{-- Kolom Kanan: Detail Form --}}
            <div class="lg:col-span-8">
                <form action="{{ route('fundraiser.profile.update') }}" method="POST" class="bg-white p-10 rounded-[2.5rem] border border-sky-100 shadow-xl shadow-sky-900/5 space-y-8">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="text-[11px] font-extrabold text-[#0c4a6e]/50 uppercase tracking-[0.2em] ml-2">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required 
                                   class="w-full mt-2 px-6 py-4 rounded-2xl bg-slate-50 border border-transparent focus:bg-white focus:border-sky-300 focus:ring-4 focus:ring-sky-100 outline-none transition-all font-bold text-[#0c4a6e]">
                        </div>

                        <div class="md:col-span-2">
                            <label class="text-[11px] font-extrabold text-[#0c4a6e]/50 uppercase tracking-[0.2em] ml-2">Email Address</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required 
                                   class="w-full mt-2 px-6 py-4 rounded-2xl bg-slate-50 border border-transparent focus:bg-white focus:border-sky-300 focus:ring-4 focus:ring-sky-100 outline-none transition-all font-bold text-[#0c4a6e]">
                        </div>

                        <div class="pt-4 md:col-span-2">
                            <div class="flex items-center gap-4">
                                <div class="h-px bg-sky-100 flex-1"></div>
                                <span class="text-[10px] font-black text-sky-300 uppercase tracking-widest">Update Keamanan</span>
                                <div class="h-px bg-sky-100 flex-1"></div>
                            </div>
                        </div>

                        <div>
                            <label class="text-[11px] font-extrabold text-[#0c4a6e]/50 uppercase tracking-[0.2em] ml-2">Password Baru</label>
                            <input type="password" name="password" placeholder="Kosongkan jika tidak diubah"
                                   class="w-full mt-2 px-6 py-4 rounded-2xl bg-slate-50 border border-transparent focus:bg-white focus:border-sky-300 focus:ring-4 focus:ring-sky-100 outline-none transition-all font-bold text-[#0c4a6e]">
                        </div>

                        <div>
                            <label class="text-[11px] font-extrabold text-[#0c4a6e]/50 uppercase tracking-[0.2em] ml-2">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" placeholder="Ulangi password"
                                   class="w-full mt-2 px-6 py-4 rounded-2xl bg-slate-50 border border-transparent focus:bg-white focus:border-sky-300 focus:ring-4 focus:ring-sky-100 outline-none transition-all font-bold text-[#0c4a6e]">
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-gradient-to-r from-[#075985] to-[#0ea5e9] text-white py-5 rounded-[2rem] font-extrabold text-sm uppercase tracking-[0.3em] shadow-xl shadow-sky-500/20 hover:shadow-sky-500/40 hover:-translate-y-1 transition-all duration-300">
                        Simpan Perubahan
                    </button>
                </form>

                {{-- Danger Zone --}}
                <div class="mt-8 bg-white rounded-[2.5rem] border border-red-100 overflow-hidden shadow-sm">
                    <div class="p-8 flex flex-col md:flex-row md:items-center justify-between gap-6">
                        <div>
                            <h4 class="text-[#0c4a6e] font-extrabold text-lg mb-1">Hapus Akun</h4>
                            <p class="text-xs text-slate-400 font-medium">Data kampanye dan riwayat Anda akan dihapus permanen.</p>
                        </div>
                        
                        <form action="#" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun secara permanen?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-6 py-3 bg-red-50 text-red-500 hover:bg-red-500 hover:text-white rounded-xl font-bold text-[10px] uppercase tracking-widest transition-all">
                                Hapus Akun Sekarang
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout-fundraiser>
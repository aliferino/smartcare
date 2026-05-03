<x-layout-fundraiser>
    <x-slot:title>Entities</x-slot:title>

    {{-- Header Section --}}
    <div class="flex items-center justify-between mb-10">
        <div>
            <h1 class="text-2xl font-black text-sky-950">Lembaga Anda</h1>
            <p class="text-sm text-slate-400 font-bold tracking-tight">Kelola profil lembaga/yayasan penyalur donasi</p>
        </div>

        {{-- Tombol Tambah di Pojok Kanan Atas --}}
        <a href="{{ route('fundraiser.entities.create') }}" 
           class="flex items-center gap-2 px-6 py-4 bg-sky-500 text-white font-black rounded-2xl shadow-lg shadow-sky-200 hover:bg-sky-600 transition-all active:scale-95">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/>
            </svg>
            <span class="text-sm">Daftarkan Lembaga</span>
        </a>
    </div>

    {{-- Stats Ringkas --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="bg-white p-6 rounded-[2rem] border border-sky-50 shadow-sm">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Lembaga</p>
            <p class="text-2xl font-black text-sky-950">{{ $entities->count() }}</p>
        </div>
        <div class="bg-white p-6 rounded-[2rem] border border-sky-50 shadow-sm">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Status Terverifikasi</p>
            <p class="text-2xl font-black text-emerald-500">{{ $entities->where('status', 'approved')->count() }}</p>
        </div>
        <div class="bg-white p-6 rounded-[2rem] border border-sky-50 shadow-sm">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Menunggu Review</p>
            <p class="text-2xl font-black text-amber-500">{{ $entities->where('status', 'pending')->count() }}</p>
        </div>
    </div>

    {{-- Table / Grid Section --}}
    <div class="bg-white rounded-[2.5rem] border border-sky-50 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-sky-50/50">
                        <th class="px-8 py-5 text-[10px] font-black text-sky-900/40 uppercase tracking-widest">Lembaga</th>
                        <th class="px-8 py-5 text-[10px] font-black text-sky-900/40 uppercase tracking-widest">Tipe</th>
                        <th class="px-8 py-5 text-[10px] font-black text-sky-900/40 uppercase tracking-widest">Kontak</th>
                        <th class="px-8 py-5 text-[10px] font-black text-sky-900/40 uppercase tracking-widest">Status</th>
                        <th class="px-8 py-5 text-[10px] font-black text-sky-900/40 uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-sky-50">
                    @forelse($entities as $entity)
                    <tr class="group hover:bg-sky-50/30 transition-colors">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <img src="{{ asset('storage/' . $entity->logo_path) }}" class="w-12 h-12 rounded-2xl object-cover shadow-sm">
                                <div>
                                    <p class="text-sm font-black text-sky-950">{{ $entity->name }}</p>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase">{{ $entity->registration_number }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="text-xs font-bold text-slate-600 bg-slate-100 px-3 py-1 rounded-lg">
                                {{ $entity->category->name ?? 'Tanpa Kategori' }}
                            </span>
                        </td>
                        <td class="px-8 py-6 text-sm font-medium text-slate-500">
                            {{ $entity->email }}
                        </td>
                        <td class="px-8 py-6">
                            @if($entity->status == 'approved')
                                <span class="flex items-center gap-1.5 text-[10px] font-black text-emerald-500 uppercase">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Terverifikasi
                                </span>
                            @elseif($entity->status == 'pending')
                                <span class="flex items-center gap-1.5 text-[10px] font-black text-amber-500 uppercase">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span> Pending
                                </span>
                            @else
                                <span class="flex items-center gap-1.5 text-[10px] font-black text-rose-500 uppercase">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Ditolak
                                </span>
                            @endif
                        </td>
                        <td class="px-8 py-6 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('fundraiser.entities.edit', $entity->id) }}" class="p-2 text-slate-400 hover:text-sky-500 hover:bg-sky-50 rounded-xl transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <button class="p-2 text-slate-400 hover:text-rose-500 hover:bg-rose-50 rounded-xl transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-20 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-20 h-20 bg-sky-50 rounded-[2rem] flex items-center justify-center mb-4">
                                    <svg class="w-10 h-10 text-sky-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                </div>
                                <p class="text-sm font-black text-sky-950">Belum Ada Lembaga</p>
                                <p class="text-xs text-slate-400 font-bold mb-6">Daftarkan lembaga Anda untuk mulai membuat kampanye.</p>
                                <a href="{{ route('fundraiser.entities.create') }}" class="text-xs font-black text-sky-500 uppercase tracking-widest hover:text-sky-600 underline decoration-2 underline-offset-4">Daftar Sekarang</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layout-fundraiser>
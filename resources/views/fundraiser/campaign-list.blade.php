<x-layout-fundraiser>
    <x-slot:title>Campaign Saya</x-slot:title>

    {{-- Header Section --}}
    <div class="flex items-center justify-between mb-10">
        <div>
            <h1 class="text-2xl font-black text-sky-950">Daftar Campaign</h1>
            <p class="text-sm text-slate-400 font-bold tracking-tight">Pantau progres penggalangan dana Anda</p>
        </div>

        <a href="{{ route('fundraiser.campaigns.create') }}" 
           class="flex items-center gap-2 px-6 py-4 bg-sky-500 text-white font-black rounded-2xl shadow-lg shadow-sky-200 hover:bg-sky-600 transition-all active:scale-95">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/>
            </svg>
            <span class="text-sm">Buat Campaign</span>
        </a>
    </div>

    {{-- Table Section --}}
    <div class="bg-white rounded-[2.5rem] border border-sky-50 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-sky-50/50">
                        <th class="px-8 py-5 text-[10px] font-black text-sky-900/40 uppercase tracking-widest">Informasi Campaign</th>
                        <th class="px-8 py-5 text-[10px] font-black text-sky-900/40 uppercase tracking-widest text-center">Lembaga Penanggung Jawab</th>
                        <th class="px-8 py-5 text-[10px] font-black text-sky-900/40 uppercase tracking-widest text-center">Target Dana</th>
                        <th class="px-8 py-5 text-[10px] font-black text-sky-900/40 uppercase tracking-widest text-center">Status</th>
                        <th class="px-8 py-5 text-[10px] font-black text-sky-900/40 uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-sky-50">
                    @forelse($campaigns as $campaign)
                    <tr class="group hover:bg-sky-50/30 transition-colors">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <img src="{{ asset('storage/' . $campaign->image_path) }}" class="w-16 h-12 rounded-xl object-cover shadow-sm">
                                <div>
                                    <p class="text-sm font-black text-sky-950 line-clamp-1">{{ $campaign->title }}</p>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">{{ $campaign->category }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6 text-center">
                            <span class="text-xs font-bold text-[#0c4a6e] bg-slate-100 px-3 py-1 rounded-lg">
                                {{ $campaign->entity->name ?? 'Individu' }}
                            </span>
                        </td>
                        <td class="px-8 py-6 text-center">
                            <p class="text-sm font-black text-emerald-600">Rp {{ number_format($campaign->goal_amount, 0, ',', '.') }}</p>
                            <p class="text-[9px] font-bold text-slate-400 uppercase">Hingga {{ \Carbon\Carbon::parse($campaign->end_at)->format('d M Y') }}</p>
                        </td>
                        <td class="px-8 py-6 text-center">
                            @if($campaign->status == 'approved')
                                <span class="px-3 py-1 bg-emerald-50 text-emerald-500 text-[10px] font-black rounded-full uppercase">Aktif</span>
                            @elseif($campaign->status == 'pending')
                                <span class="px-3 py-1 bg-amber-50 text-amber-500 text-[10px] font-black rounded-full uppercase">Review</span>
                            @else
                                <span class="px-3 py-1 bg-rose-50 text-rose-500 text-[10px] font-black rounded-full uppercase">Selesai</span>
                            @endif
                        </td>
                        <td class="px-8 py-6 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="#" class="p-2 text-slate-400 hover:text-sky-500 hover:bg-sky-50 rounded-xl transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-20 text-center">
                            <p class="text-sm font-black text-sky-950">Belum Ada Campaign</p>
                            <p class="text-xs text-slate-400 font-bold">Mulai langkah kebaikan pertama Anda hari ini.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layout-fundraiser>
<x-layout-admin>
    <x-slot:title>Verified Users</x-slot:title>

    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-black text-gray-900 tracking-tight">User Terverifikasi</h1>
            <p class="text-xs text-gray-400 font-bold mt-1">Daftar warga negara yang identitasnya sudah sah di sistem.</p>
        </div>
        <div class="bg-emerald-50 text-emerald-600 px-4 py-2 rounded-xl border border-emerald-100 flex items-center gap-2">
            <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
            <span class="text-[10px] font-black uppercase tracking-widest">{{ count($verifiedCitizens) }} Verified</span>
        </div>
    </div>

    <div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-sm overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-50/50 border-b border-gray-100">
                <tr>
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Identitas User</th>
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Waktu Verifikasi</th>
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Status</th>
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Manajemen</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($verifiedCitizens as $citizen)
                <tr class="hover:bg-gray-50/30 transition-colors group">
                    <td class="px-8 py-5">
                        <div>
                            <span class="text-sm font-black text-gray-900 block">{{ $citizen->full_name }}</span>
                            <span class="text-[10px] text-gray-400 font-bold tracking-tighter uppercase">NIK: {{ $citizen->id_number }}</span>
                        </div>
                    </td>
                    <td class="px-8 py-5">
                        <p class="text-sm font-black text-gray-700">{{ $citizen->verified_at ? $citizen->verified_at->format('d M Y') : '-' }}</p>
                        <p class="text-[10px] text-gray-300 font-bold uppercase tracking-widest">{{ $citizen->verified_at ? $citizen->verified_at->format('H:i') : '' }} WIB</p>
                    </td>
                    <td class="px-8 py-5">
                        @if($citizen->status == 'approved')
                            <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-emerald-50 border border-emerald-100 rounded-full">
                                <span class="text-[10px] font-black text-emerald-600 uppercase tracking-widest">Approved</span>
                            </div>
                        @else
                            <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-rose-50 border border-rose-100 rounded-full">
                                <span class="text-[10px] font-black text-rose-600 uppercase tracking-widest">Rejected</span>
                            </div>
                        @endif
                    </td>
                    <td class="px-8 py-5 text-right">
                        <a href="{{ route('admin.users.kyc.detail', $citizen->id) }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-gray-100 rounded-xl text-[10px] font-black text-gray-600 uppercase tracking-widest shadow-sm hover:bg-gray-900 hover:text-white hover:border-gray-900 transition-all duration-300">
                            View Profile
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-8 py-20 text-center">
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 bg-gray-50 rounded-3xl flex items-center justify-center mb-4 border border-dashed border-gray-200">
                                <svg class="w-8 h-8 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <p class="text-sm font-black text-gray-400 italic">Belum ada user yang terverifikasi. Sistem masih sepi.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layout-admin>
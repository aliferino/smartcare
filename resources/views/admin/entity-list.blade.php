<x-layout-admin>
    <x-slot:title>Daftar Entitas Aktif</x-slot:title>

    <h1 class="text-2xl font-black text-gray-900 mb-8">Daftar Entitas Aktif</h1>

    <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-50/50 border-b border-gray-100">
                <tr>
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Nama Entitas</th>
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Kategori</th>
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Status & Verifikator</th>
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($verifiedEntities as $ent)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-8 py-5">
                        <div class="flex items-center gap-4">
                            <img src="{{ $ent->logo_path ? asset('storage/'.$ent->logo_path) : 'https://ui-avatars.com/api/?name='.urlencode($ent->name) }}" 
                                 class="w-10 h-10 rounded-xl object-cover bg-gray-100">
                            <div>
                                <p class="text-sm font-black text-gray-900">{{ $ent->name }}</p>
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter">{{ $ent->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-5">
                        <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-3 py-1 rounded-lg">
                            {{ $ent->category?->name ?? 'N/A' }}
                        </span>
                    </td>
                    <td class="px-8 py-5">
                        <div class="flex flex-col">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.5)]"></span>
                                <span class="text-[10px] font-black text-gray-900 uppercase tracking-widest">Verified</span>
                            </div>
                            <p class="text-[9px] text-gray-400 font-bold italic">By: {{ $ent->admin?->name ?? 'System' }}</p>
                        </div>
                    </td>
                    <td class="px-8 py-5 text-right">
                        <a href="{{ route('admin.entities.detail', $ent->id) }}" class="text-xs font-black text-rose-500 hover:text-rose-700 hover:underline transition-all">
                            View Detail
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        @if($verifiedEntities->isEmpty())
        <div class="py-20 text-center">
            <p class="text-gray-400 font-bold italic">Belum ada entitas yang terverifikasi.</p>
        </div>
        @endif
    </div>
</x-layout-admin>
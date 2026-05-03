<x-layout-admin>
    <x-slot:title>Campaign Aktif</x-slot:title>

    <h1 class="text-2xl font-black text-gray-900 mb-8">Campaign Aktif</h1>

    <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-50/50 border-b border-gray-100">
                <tr>
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Judul Campaign</th>
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Kategori</th>
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Status</th>
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($activeCampaigns as $cp)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-8 py-5">
                        <p class="text-sm font-black text-gray-900">{{ $cp->title }}</p>
                        <p class="text-[10px] text-gray-400 font-bold uppercase mt-1">Target: Rp {{ number_format($cp->goal_amount) }}</p>
                    </td>
                    <td class="px-8 py-5">
                        <span class="text-xs font-bold text-gray-600 bg-gray-100 px-3 py-1 rounded-lg">
                            {{ $cp->category->name ?? 'Uncategorized' }}
                        </span>
                    </td>
                    <td class="px-8 py-5">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            <span class="text-xs font-black text-emerald-600 uppercase tracking-tight">Active</span>
                        </div>
                    </td>
                    <td class="px-8 py-5 text-right">
                        <a href="{{ route('admin.campaigns.detail', $cp->id) }}" class="text-xs font-black text-rose-500 hover:text-rose-700 hover:underline transition-all">
                            View Detail
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        @if($activeCampaigns->isEmpty())
        <div class="py-20 text-center">
            <p class="text-gray-400 font-bold italic">Belum ada campaign yang aktif saat ini.</p>
        </div>
        @endif
    </div>
</x-layout-admin>
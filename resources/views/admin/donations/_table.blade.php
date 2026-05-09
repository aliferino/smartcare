<div class="overflow-x-auto">
    <table class="w-full text-left">
        <thead>
            <tr class="bg-blue-600">
                <th class="px-6 py-4 text-xs font-black text-white uppercase tracking-widest border-b border-blue-500">Campaign</th>
                <th class="px-6 py-4 text-xs font-black text-white uppercase tracking-widest border-b border-blue-500">Donor</th>
                <th class="px-6 py-4 text-xs font-black text-white uppercase tracking-widest border-b border-blue-500 text-center">Status</th>
                <th class="px-6 py-4 text-xs font-black text-white uppercase tracking-widest border-b border-blue-500 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-50">
            @forelse($donations as $donation)
            <tr class="group hover:bg-blue-50/20 transition-colors">
                <td class="px-6 py-4">
                    <span class="text-[10px] font-bold text-slate-600 uppercase tracking-tight line-clamp-1">
                        {{ $donation->campaign->title }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <span class="text-[11px] font-black text-slate-900 uppercase tracking-tight">
                        {{ $donation->is_anonymous ? 'Anonymous' : $donation->name }}
                    </span>
                </td>
                <td class="px-6 py-4 text-center">
                    @php
                        $colors = [
                            'pending' => 'bg-amber-100 text-amber-700',
                            'paid' => 'bg-emerald-100 text-emerald-700',
                            'failed' => 'bg-rose-100 text-rose-700',
                            'expired' => 'bg-slate-100 text-slate-500',
                        ];
                        $color = $colors[$donation->status] ?? 'bg-slate-100 text-slate-700';
                    @endphp
                    <span class="inline-flex items-center px-2 py-0.5 text-[9px] uppercase font-black {{ $color }} rounded-full opacity-80">
                        {{ $donation->status }}
                    </span>
                </td>
                <td class="px-6 py-4 text-right">
                    <button type="button" data-donation="{{ json_encode($donation->load('campaign')) }}"class="p-2 btn-detail text-[10px] text-slate-400 hover:text-white hover:bg-blue-600 rounded-lg transition-all inline-flex items-center justify-center">
                        <i data-lucide="info" class="w-4 h-4"></i>
                    </button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="px-6 py-12 text-center">
                    <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em] italic">No Donation Records Found</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="px-6 py-4 bg-slate-50/50 border-t border-slate-50">
    {{ $donations->links() }}
</div>
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
                    @if($donation->status === 'paid')
                        <span class="px-2 py-1 rounded bg-emerald-50 text-emerald-600 text-[10px] font-black uppercase tracking-tighter">Paid</span>
                    @elseif($donation->status === 'pending')
                        <span class="px-2 py-1 rounded bg-amber-50 text-amber-600 text-[10px] font-black uppercase tracking-tighter">Pending</span>
                    @elseif($donation->status === 'failed')
                        <span class="px-2 py-1 rounded bg-rose-50 text-rose-600 text-[10px] font-black uppercase tracking-tighter">Failed</span>
                    @else
                        <span class="px-2 py-1 rounded bg-slate-50 text-slate-600 text-[10px] font-black uppercase tracking-tighter">Expired</span>
                    @endif
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
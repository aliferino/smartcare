<div class="overflow-x-auto">
    <table class="w-full text-left">
        <thead>
            <tr class="bg-blue-600">
                <th class="px-6 py-4 text-xs font-black text-white uppercase tracking-widest border-b border-blue-500">Fundraiser</th>
                <th class="px-6 py-4 text-xs font-black text-white uppercase tracking-widest border-b border-blue-500">Campaign</th>
                <th class="px-6 py-4 text-xs font-black text-white uppercase tracking-widest border-b border-blue-500">Amount</th>
                <th class="px-6 py-4 text-xs font-black text-white uppercase tracking-widest border-b border-blue-500 text-center">Status</th>
                <th class="px-6 py-4 text-xs font-black text-white uppercase tracking-widest border-b border-blue-500 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-50">
            @forelse($withdraws as $withdraw)
            <tr class="group hover:bg-blue-50/20 transition-colors">
                <td class="px-6 py-4">
                    <span class="text-[10px] font-bold text-slate-600 uppercase tracking-tight">
                        {{ $withdraw->campaign->user->name }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <span class="text-[10px] font-bold text-slate-600 uppercase tracking-tight line-clamp-1">
                        {{ $withdraw->campaign->title }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <span class="text-xs font-black text-emerald-600">
                        IDR {{ number_format($withdraw->amount, 0, ',', '.') }}
                    </span>
                </td>
                <td class="px-6 py-4 text-center">
                    @if($withdraw->status === 'approved')
                        <span class="px-2 py-1 rounded bg-emerald-50 text-emerald-600 text-[10px] font-black uppercase tracking-tighter">Approved</span>
                    @elseif($withdraw->status === 'pending')
                        <span class="px-2 py-1 rounded bg-amber-50 text-amber-600 text-[10px] font-black uppercase tracking-tighter">Pending</span>
                    @elseif($withdraw->status === 'rejected')
                        <span class="px-2 py-1 rounded bg-rose-50 text-rose-600 text-[10px] font-black uppercase tracking-tighter">Rejected</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-right">
                    <div class="flex items-center justify-end gap-2">
                        <button type="button"
                                data-withdraw="{{ json_encode($withdraw->load('campaign', 'campaign.user', 'approver')) }}"
                                class="w-8 h-8 flex items-center justify-center btn-detail text-slate-400 hover:text-white hover:bg-blue-600 rounded-lg transition-all"
                                title="Detail">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                        </button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-12 text-center">
                    <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em] italic">No Withdrawal Records Found</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{ $withdraws->links() }}

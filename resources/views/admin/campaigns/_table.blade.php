<div class="overflow-x-auto">
    <table class="w-full text-left">
        <thead>
            <tr class="bg-blue-600">
                <th class="px-6 py-4 text-xs font-black text-white uppercase tracking-widest border-b border-blue-500">Campaign Info</th>
                <th class="px-6 py-4 text-xs font-black text-white uppercase tracking-widest border-b border-blue-500 text-center">Donations Progress</th>
                <th class="px-6 py-4 text-xs font-black text-white uppercase tracking-widest border-b border-blue-500 text-center">Status</th>
                <th class="px-6 py-4 text-xs font-black text-white uppercase tracking-widest border-b border-blue-500 text-right">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-50 font-medium">
            @forelse($campaigns as $campaign)
            <tr class="group hover:bg-blue-50/20 transition-colors">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-slate-100 overflow-hidden flex-shrink-0 shadow-inner">
                            @if($campaign->primaryImage)
                                <img src="{{ asset('storage/' . $campaign->primaryImage->image_path) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-[9px] font-black text-slate-400">NO IMG</div>
                            @endif
                        </div>
                        <div>
                            <p class="text-xs font-black text-slate-900 uppercase line-clamp-1 tracking-tight">{{ $campaign->title }}</p>
                            <p class="text-[9px] text-blue-600 font-bold uppercase tracking-tighter">{{ $campaign->campaignCategory->name ?? 'Uncategorized' }}</p>
                        </div>
                    </div>
                </td>
                
                <td class="px-6 py-4">
                    <div class="w-48 mx-auto">
                        @php 
                            $percent = $campaign->goal_amount > 0 ? ($campaign->current_amount / $campaign->goal_amount) * 100 : 0;
                            $percent = min(100, $percent);
                        @endphp
                        <div class="flex justify-between mb-1">
                            <span class="text-[9px] font-black text-slate-900 tracking-tighter uppercase">Rp {{ number_format($campaign->current_amount, 0, ',', '.') }}</span>
                            <span class="text-[9px] font-black text-blue-600">{{ round($percent, 1) }}%</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-1.5 overflow-hidden shadow-inner">
                            <div class="bg-blue-600 h-1.5 rounded-full transition-all duration-700 ease-out" style="width: {{ $percent }}%"></div>
                        </div>
                    </div>
                </td>

                <td class="px-6 py-4 text-center">
                    @if($campaign->status === 'approved')
                        <span class="px-2 py-1 rounded bg-emerald-50 text-emerald-600 text-[10px] font-black uppercase tracking-tighter">Approved</span>
                    @elseif($campaign->status === 'pending')
                        <span class="px-2 py-1 rounded bg-amber-50 text-amber-600 text-[10px] font-black uppercase tracking-tighter">Pending</span>
                    @elseif($campaign->status === 'rejected')
                        <span class="px-2 py-1 rounded bg-rose-50 text-rose-600 text-[10px] font-black uppercase tracking-tighter">Rejected</span>
                    @else
                        <span class="px-2 py-1 rounded bg-blue-50 text-blue-600 text-[10px] font-black uppercase tracking-tighter">Completed</span>
                    @endif
                </td>
                
                <td class="px-6 py-4 text-right">
                    <button type="button" data-id="{{ $campaign->id }}" class="p-2 btn-detail text-[10px] text-slate-400 hover:text-white hover:bg-blue-600 rounded-lg transition-all">
                        <i data-lucide="info" class="w-4 h-4"></i>
                    </button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="px-6 py-12 text-center text-slate-400 text-[10px] uppercase font-black tracking-[0.2em] italic">
                    No Campaigns Found
                </td>
            </tr>
            @endforelse
        </tbody>
</table>
</div>

@if(($context ?? 'index') !== 'index')
{{ $campaigns->links() }}
@endif
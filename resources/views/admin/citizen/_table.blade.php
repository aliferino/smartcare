<div class="overflow-x-auto">
    <table class="w-full text-left">
        <thead>
            <tr class="bg-blue-600">
                <th class="px-6 py-4 text-xs font-black text-white uppercase tracking-widest border-b border-blue-500">User Info</th>
                <th class="px-6 py-4 text-xs font-black text-white uppercase tracking-widest border-b border-blue-500">Full Name</th>
                <th class="px-6 py-4 text-xs font-black text-white uppercase tracking-widest border-b border-blue-500 text-center">Status</th>
                <th class="px-6 py-4 text-xs font-black text-white uppercase tracking-widest border-b border-blue-500 text-right">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-50 font-medium">
            @forelse($citizens as $citizen)
            <tr class="group hover:bg-blue-50/20 transition-colors">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-blue-100 border-2 border-white shadow-sm flex items-center justify-center text-xs font-black text-blue-600 uppercase flex-shrink-0">
                            {{ substr($citizen->user->name ?? '?', 0, 1) }}
                        </div>
                        <div>
                            <p class="text-xs font-black text-slate-900 uppercase line-clamp-1 tracking-tight">{{ $citizen->user->name ?? 'Unknown' }}</p>
                            <p class="text-[9px] text-blue-600 font-bold lowercase tracking-tighter">{{ $citizen->user->email ?? '-' }}</p>
                        </div>
                    </div>
                </td>

                <td class="px-6 py-4">
                    <p class="text-xs font-bold text-slate-900">{{ $citizen->full_name }}</p>
                    <p class="text-[9px] text-slate-400 font-medium">NIK: {{ $citizen->id_number }}</p>
                </td>

                <td class="px-6 py-4 text-center">
                    @if($citizen->status === 'approved')
                        <span class="px-2 py-1 rounded bg-emerald-50 text-emerald-600 text-[10px] font-black uppercase tracking-tighter">Approved</span>
                    @elseif($citizen->status === 'pending')
                        <span class="px-2 py-1 rounded bg-amber-50 text-amber-600 text-[10px] font-black uppercase tracking-tighter">Pending</span>
                    @else
                        <span class="px-2 py-1 rounded bg-rose-50 text-rose-600 text-[10px] font-black uppercase tracking-tighter">Rejected</span>
                    @endif
                </td>

                <td class="px-6 py-4 text-right">
                    <button type="button" data-id="{{ $citizen->id }}" class="p-2 btn-detail text-[10px] text-slate-400 hover:text-white hover:bg-blue-600 rounded-lg transition-all">
                        <i data-lucide="info" class="w-4 h-4"></i>
                    </button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="px-6 py-12 text-center text-slate-400 text-[10px] uppercase font-black tracking-[0.2em] italic">
                    No Citizens Found
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if(($context ?? 'index') !== 'index')
    <div class="px-6 py-4 border-t border-slate-50 bg-slate-50/30">
        {{ $citizens->links() }}
    </div>
@endif

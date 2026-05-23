<div class="overflow-x-auto">
    <table class="w-full text-left">
        <thead>
            <tr class="bg-blue-600">
                <th class="px-6 py-4 text-xs font-black text-white uppercase tracking-widest border-b border-blue-500">Entity Info</th>
                
                <th class="px-6 py-4 text-xs font-black text-white uppercase tracking-widest border-b border-blue-500">Status</th>
                
                <th class="px-6 py-4 text-xs font-black text-white uppercase tracking-widest border-b border-blue-500 text-right">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-50 font-medium">
            @forelse($entities as $entity)
            <tr class="group hover:bg-blue-50/20 transition-colors">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-slate-100 group-hover:bg-blue-100 flex items-center justify-center text-sm font-black text-slate-900 group-hover:text-blue-600 transition-colors shadow-inner shrink-0">
                            {{ substr($entity->name, 0, 1) }}
                        </div>
                        
                        <div class="flex flex-col">
                            <span class="text-xs font-black text-slate-900 uppercase tracking-tight leading-none mb-1">
                                {{ $entity->name }}
                            </span>
                            <span class="text-[9px] font-bold text-blue-600 uppercase tracking-widest">
                                {{ $entity->entityCategory->name ?? 'Uncategorized' }}
                            </span>
                        </div>
                    </div>
                </td>

                <td class="px-6 py-4">
                    @if($entity->status === 'approved')
                        <span class="px-2 py-1 rounded bg-emerald-50 text-emerald-600 text-[10px] font-black uppercase tracking-tighter">Approved</span>
                    @elseif($entity->status === 'pending')
                        <span class="px-2 py-1 rounded bg-amber-50 text-amber-600 text-[10px] font-black uppercase tracking-tighter">Pending</span>
                    @else
                        <span class="px-2 py-1 rounded bg-rose-50 text-rose-600 text-[10px] font-black uppercase tracking-tighter">Rejected</span>
                    @endif
                </td>
                
                <td class="px-6 py-4 text-right">
                    <button type="button" data-id="{{ $entity->id }}" class="p-2 btn-detail text-[10px] text-slate-400 hover:text-white hover:bg-blue-600 rounded-lg transition-all">
                        <i data-lucide="info" class="w-4 h-4"></i>
                    </button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="px-6 py-10 text-center text-slate-500 text-[10px] uppercase font-bold italic tracking-widest">
                    No Entities Found
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if(($context ?? 'index') !== 'index')
<div class="px-6 py-4 border-t border-slate-50">
    {{ $entities->links() }}
</div>
@endif
<div class="overflow-x-auto">
    <table class="w-full text-left">
        <thead>
            <tr class="bg-blue-600">
                <th class="px-6 py-4 text-xs font-black text-white uppercase tracking-widest border-b border-blue-500">Entity Name</th>
                <th class="px-6 py-4 text-xs font-black text-white uppercase tracking-widest border-b border-blue-500">Category</th>
                
                {{-- Gunakan default 'index' jika context tidak ada --}}
                @if(($context ?? 'index') !== 'index')
                    <th class="px-6 py-4 text-xs font-black text-white uppercase tracking-widest border-b border-blue-500">Status</th>
                @endif
                
                <th class="px-6 py-4 text-xs font-black text-white uppercase tracking-widest border-b border-blue-500 text-right">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-50 font-medium">
            @forelse($entities as $entity)
            <tr class="group hover:bg-blue-50/20 transition-colors">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-slate-100 group-hover:bg-blue-100 flex items-center justify-center text-[11px] font-black text-slate-900 group-hover:text-blue-600 transition-colors">
                            {{ substr($entity->name, 0, 1) }}
                        </div>
                        <span class="text-xs font-bold text-slate-900">{{ $entity->name }}</span>
                    </div>
                </td>
                <td class="px-6 py-4 text-xs font-bold text-slate-500">
                    {{ $entity->entityCategory->name ?? 'Uncategorized' }}
                </td>
                
                @if(($context ?? 'index') !== 'index')
                <td class="px-6 py-4">
                    @php
                        $statusMap = [
                            'pending' => ['bg' => 'bg-amber-100', 'text' => 'text-amber-700'],
                            'approved' => ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-700'],
                            'rejected' => ['bg' => 'bg-rose-100', 'text' => 'text-rose-700'],
                        ];
                        $s = $statusMap[$entity->status] ?? $statusMap['pending'];
                    @endphp
                    <span class="inline-flex items-center px-2 py-0.5 text-[10px] uppercase font-black {{ $s['bg'] }} {{ $s['text'] }} rounded border border-current opacity-80">
                        {{ $entity->status }}
                    </span>
                </td>
                @endif
                
                <td class="px-6 py-4 text-right">
                    <button type="button" 
                            data-id="{{ $entity->id }}" 
                            class="btn-detail text-[10px] uppercase font-black text-blue-600 tracking-widest">
                        Detail
                    </button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-10 text-center text-slate-500 text-[10px] uppercase font-bold italic tracking-widest">
                    No Activity Found
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if(($context ?? 'index') !== 'index')
<div class="px-6 py-4 border-t border-slate-50 pagination-container">
    {{ $entities->links() }}
</div>
@endif
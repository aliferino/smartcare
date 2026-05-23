<div class="overflow-x-auto">
    <table class="w-full text-left">
        <thead>
            <tr class="bg-blue-600">
                <th class="px-6 py-4 text-xs font-black text-white uppercase tracking-widest border-b border-blue-500">Entity Info</th>
                <th class="px-6 py-4 text-xs font-black text-white uppercase tracking-widest border-b border-blue-500">Contact</th>
                <th class="px-6 py-4 text-xs font-black text-white uppercase tracking-widest border-b border-blue-500">Status</th>
                <th class="px-6 py-4 text-xs font-black text-white uppercase tracking-widest border-b border-blue-500 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-50 font-medium">
            @forelse($entities as $entity)
            <tr class="group hover:bg-blue-50/20 transition-colors">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        @if($entity->logo_path)
                            <img src="{{ asset('storage/' . $entity->logo_path) }}"
                                 class="w-10 h-10 rounded-xl object-cover shadow-inner shrink-0">
                        @else
                            <div class="w-10 h-10 rounded-xl bg-slate-100 group-hover:bg-blue-100 flex items-center justify-center text-sm font-black text-slate-900 group-hover:text-blue-600 transition-colors shadow-inner shrink-0">
                                {{ substr($entity->name, 0, 1) }}
                            </div>
                        @endif

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
                    <div class="flex flex-col">
                        <span class="text-xs font-medium text-slate-900">{{ $entity->email }}</span>
                        <span class="text-[10px] text-slate-500 mt-0.5">{{ Str::limit($entity->address, 30) }}</span>
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

                    @if($entity->status === 'rejected' && $entity->rejection_reason)
                        <div class="mt-2 text-[10px] text-rose-600 font-medium">
                            {{ Str::limit($entity->rejection_reason, 50) }}
                        </div>
                    @endif
                </td>

                <td class="px-6 py-4 text-right">
                    <div class="flex items-center justify-end gap-2">
                        <button type="button"
                                onclick="editEntity({{ $entity->id }})"
                                class="p-2 text-[10px] text-slate-400 hover:text-white hover:bg-blue-600 rounded-lg transition-all"
                                title="Edit">
                            <i data-lucide="pencil" class="w-4 h-4"></i>
                        </button>

                        <button type="button"
                                onclick="deleteEntity({{ $entity->id }}, '{{ $entity->name }}')"
                                class="p-2 text-[10px] text-slate-400 hover:text-white hover:bg-red-600 rounded-lg transition-all"
                                title="Delete">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="px-6 py-10 text-center text-slate-500 text-[10px] uppercase font-bold italic tracking-widest">
                    No Entities Found
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($entities instanceof \Illuminate\Pagination\LengthAwarePaginator)
<div class="px-6 py-4 border-t border-slate-50">
    {{ $entities->links() }}
</div>
@endif

@push('scripts')
<script>
    function editEntity(id) {
        $.get(`/fundraiser/entities/${id}/edit`, function(data) {
            Modal.open('entityModal', {
                mode: 'edit',
                entity: data
            });
        }).fail(function() {
            alert('Failed to load entity data');
        });
    }

    function deleteEntity(id, name) {
        if (!confirm(`Are you sure you want to delete "${name}"?`)) {
            return;
        }

        $.ajax({
            url: `/fundraiser/entities/${id}/destroy`,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    location.reload();
                } else {
                    alert(response.message || 'Failed to delete entity');
                }
            },
            error: function(xhr) {
                const message = xhr.responseJSON?.message || 'Failed to delete entity';
                alert(message);
            }
        });
    }
</script>
@endpush

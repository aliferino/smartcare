<div class="overflow-x-auto">
    <table class="w-full text-left">
        <thead>
            <tr class="bg-blue-600">
                <th class="px-6 py-4 text-xs font-black text-white uppercase tracking-widest border-b border-blue-500">Campaign Info</th>
                <th class="px-6 py-4 text-xs font-black text-white uppercase tracking-widest border-b border-blue-500">Goal & Progress</th>
                <th class="px-6 py-4 text-xs font-black text-white uppercase tracking-widest border-b border-blue-500">Status</th>
                <th class="px-6 py-4 text-xs font-black text-white uppercase tracking-widest border-b border-blue-500 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-50 font-medium">
            @forelse($campaigns as $campaign)
            <tr class="group hover:bg-blue-50/20 transition-colors">
                <td class="px-6 py-4">
                    <div class="flex flex-col">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-black text-slate-900 uppercase tracking-tight leading-none">
                                {{ Str::limit($campaign->title, 30) }}
                            </span>
                            @if($campaign->is_urgent)
                                <span class="px-1.5 py-0.5 rounded bg-red-50 text-red-600 text-[8px] font-black uppercase tracking-tighter">Urgent</span>
                            @endif
                        </div>
                        <span class="text-[9px] font-bold text-blue-600 uppercase tracking-widest mt-1">
                            {{ $campaign->campaignCategory->name ?? 'Uncategorized' }}
                        </span>
                    </div>
                </td>

                <td class="px-6 py-4">
                    <div class="flex flex-col">
                        <span class="text-xs font-black text-slate-900">IDR {{ number_format($campaign->goal_amount, 0, ',', '.') }}</span>
                        <div class="mt-1 w-full bg-slate-100 rounded-full h-1.5">
                            @php
                                $percentage = $campaign->goal_amount > 0 ? ($campaign->current_amount / $campaign->goal_amount) * 100 : 0;
                                $percentage = min($percentage, 100);
                            @endphp
                            <div class="bg-blue-600 h-1.5 rounded-full" style="width: {{ $percentage }}%"></div>
                        </div>
                        <span class="text-[9px] text-slate-500 mt-0.5">{{ number_format($percentage, 1) }}% ({{ $campaign->donors_count }} donors)</span>
                    </div>
                </td>

                <td class="px-6 py-4">
                    @if($campaign->status === 'approved')
                        <span class="px-2 py-1 rounded bg-emerald-50 text-emerald-600 text-[10px] font-black uppercase tracking-tighter">Approved</span>
                    @elseif($campaign->status === 'pending')
                        <span class="px-2 py-1 rounded bg-amber-50 text-amber-600 text-[10px] font-black uppercase tracking-tighter">Pending</span>
                    @elseif($campaign->status === 'completed')
                        <span class="px-2 py-1 rounded bg-blue-50 text-blue-600 text-[10px] font-black uppercase tracking-tighter">Completed</span>
                    @else
                        <span class="px-2 py-1 rounded bg-rose-50 text-rose-600 text-[10px] font-black uppercase tracking-tighter">Rejected</span>
                    @endif
                </td>

                <td class="px-6 py-4 text-right">
                    <div class="flex items-center justify-end gap-2">
                        <button type="button"
                                onclick="viewCampaignDetail({{ $campaign->id }})"
                                class="w-8 h-8 flex items-center justify-center text-slate-400 hover:text-white hover:bg-blue-600 rounded-lg transition-all"
                                title="Detail">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                        </button>

                        @if($campaign->status !== 'completed' && $campaign->donors_count == 0)
                            <button type="button"
                                    onclick="editCampaign({{ $campaign->id }})"
                                    class="w-8 h-8 flex items-center justify-center text-slate-400 hover:text-white hover:bg-amber-500 rounded-lg transition-all"
                                    title="Edit">
                                <i data-lucide="pencil" class="w-4 h-4"></i>
                            </button>
                        @endif

                        <button type="button"
                                onclick="deleteCampaign({{ $campaign->id }}, '{{ $campaign->title }}')"
                                class="w-8 h-8 flex items-center justify-center text-slate-400 hover:text-white hover:bg-red-600 rounded-lg transition-all"
                                title="Delete">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="px-6 py-10 text-center text-slate-500 text-[10px] uppercase font-bold italic tracking-widest">
                    No Campaigns Found
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($campaigns instanceof \Illuminate\Pagination\LengthAwarePaginator)
{{ $campaigns->links() }}
@endif

@push('scripts')
<script>
    function editCampaign(id) {
        $.get(`/fundraiser/campaigns/${id}/edit`, function(data) {
            Modal.open('campaignModal', {
                mode: 'edit',
                campaign: data
            });
        }).fail(function() {
            alert('Failed to load campaign data');
        });
    }

    function deleteCampaign(id, title) {
        if (!confirm(`Are you sure you want to delete "${title}"?`)) {
            return;
        }

        $.ajax({
            url: `/fundraiser/campaigns/${id}/destroy`,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    location.reload();
                } else {
                    alert(response.message || 'Failed to delete campaign');
                }
            },
            error: function(xhr) {
                const message = xhr.responseJSON?.message || 'Failed to delete campaign';
                alert(message);
            }
        });
    }
</script>
@endpush

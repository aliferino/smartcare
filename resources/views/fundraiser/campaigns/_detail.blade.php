<div id="campaignDetailModal" class="fixed inset-0 z-50 hidden overflow-y-auto opacity-0 transition-opacity duration-300">
    <div class="flex min-h-full items-center justify-center p-4">
        <div data-modal-backdrop class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"></div>

        <div class="bg-white rounded-3xl shadow-2xl z-50 w-full max-w-3xl relative my-8 overflow-hidden transform scale-95 opacity-0 transition-all duration-300 ease-in-out">

            <div class="px-8 py-6 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
                <div>
                    <h3 class="text-lg font-black text-slate-900 uppercase tracking-tight">Campaign Details</h3>
                    <p class="text-[10px] font-bold text-blue-600 uppercase tracking-widest mt-1">View campaign information</p>
                </div>
                <button onclick="Modal.close('campaignDetailModal')" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-slate-200 text-slate-400 transition-colors text-xl">&times;</button>
            </div>

            <div id="campaignDetailContent" class="p-8 space-y-6">
                {{-- Content will be loaded dynamically --}}
            </div>

        </div>
    </div>
</div>

@push('scripts')
<script>
    function viewCampaignDetail(id) {
        $.get(`/fundraiser/campaigns/${id}/detail`, function(data) {
            populateCampaignDetail(data);
            Modal.open('campaignDetailModal');
        }).fail(function() {
            alert('Failed to load campaign details');
        });
    }

    function populateCampaignDetail(campaign) {
        const percentage = campaign.goal_amount > 0 ? (campaign.current_amount / campaign.goal_amount) * 100 : 0;
        const percentageRounded = Math.min(percentage, 100).toFixed(1);

        let statusBadge = '';
        if (campaign.status === 'approved') {
            statusBadge = '<span class="px-3 py-1.5 rounded-lg bg-emerald-50 text-emerald-600 text-xs font-black uppercase">Approved</span>';
        } else if (campaign.status === 'pending') {
            statusBadge = '<span class="px-3 py-1.5 rounded-lg bg-amber-50 text-amber-600 text-xs font-black uppercase">Pending</span>';
        } else if (campaign.status === 'completed') {
            statusBadge = '<span class="px-3 py-1.5 rounded-lg bg-blue-50 text-blue-600 text-xs font-black uppercase">Completed</span>';
        } else {
            statusBadge = '<span class="px-3 py-1.5 rounded-lg bg-rose-50 text-rose-600 text-xs font-black uppercase">Rejected</span>';
        }

        let urgentBadge = campaign.is_urgent
            ? '<span class="px-2 py-1 rounded bg-red-50 text-red-600 text-[9px] font-black uppercase">Urgent</span>'
            : '';

        let imageHtml = '';
        if (campaign.primary_image && campaign.primary_image.image_path) {
            imageHtml = `
                <div class="mb-6">
                    <img src="/storage/${campaign.primary_image.image_path}"
                         class="w-full h-64 object-cover rounded-xl shadow-sm"
                         alt="Campaign Image">
                </div>
            `;
        }

        let rejectionHtml = '';
        if (campaign.status === 'rejected' && campaign.rejection_reason) {
            rejectionHtml = `
                <div class="p-4 bg-rose-50 border border-rose-100 rounded-xl">
                    <p class="text-xs font-bold text-rose-900 uppercase tracking-wider mb-2">Rejection Reason</p>
                    <p class="text-sm text-rose-700">${campaign.rejection_reason}</p>
                </div>
            `;
        }

        const startDate = new Date(campaign.start_at).toLocaleDateString('id-ID', {
            day: 'numeric', month: 'long', year: 'numeric'
        });
        const endDate = new Date(campaign.end_at).toLocaleDateString('id-ID', {
            day: 'numeric', month: 'long', year: 'numeric'
        });

        let entityLogo = '';
        if (campaign.entity.logo_path) {
            entityLogo = `<img src="/storage/${campaign.entity.logo_path}" class="w-12 h-12 rounded-xl object-cover shadow-sm">`;
        } else {
            entityLogo = `
                <div class="w-12 h-12 rounded-xl bg-slate-100 flex items-center justify-center text-lg font-black text-slate-900 shadow-sm">
                    ${campaign.entity.name.charAt(0)}
                </div>
            `;
        }

        const html = `
            ${imageHtml}

            <div class="flex items-start justify-between">
                <div>
                    <div class="flex items-center gap-2 mb-2">
                        <h4 class="text-xl font-black text-slate-900 uppercase tracking-tight">${campaign.title}</h4>
                        ${urgentBadge}
                    </div>
                    <p class="text-xs font-bold text-blue-600 uppercase tracking-widest">${campaign.campaign_category.name}</p>
                </div>
                ${statusBadge}
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="p-4 bg-slate-50 rounded-xl">
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Goal Amount</p>
                    <p class="text-lg font-black text-slate-900">IDR ${Number(campaign.goal_amount).toLocaleString('id-ID')}</p>
                </div>
                <div class="p-4 bg-slate-50 rounded-xl">
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Current Amount</p>
                    <p class="text-lg font-black text-slate-900">IDR ${Number(campaign.current_amount).toLocaleString('id-ID')}</p>
                </div>
            </div>

            <div class="p-4 bg-blue-50 rounded-xl">
                <div class="flex justify-between items-center mb-2">
                    <p class="text-xs font-bold text-blue-900 uppercase tracking-wider">Progress</p>
                    <p class="text-sm font-black text-blue-900">${percentageRounded}%</p>
                </div>
                <div class="w-full bg-white rounded-full h-2.5">
                    <div class="bg-blue-600 h-2.5 rounded-full" style="width: ${percentageRounded}%"></div>
                </div>
                <p class="text-[10px] text-blue-700 mt-2">${campaign.donors_count} donors contributed</p>
            </div>

            <div class="border-t border-slate-100 pt-6">
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">Entity Information</p>
                <div class="flex items-start gap-4 p-4 bg-slate-50 rounded-xl">
                    ${entityLogo}
                    <div class="flex-1">
                        <p class="text-sm font-black text-slate-900 uppercase tracking-tight mb-1">${campaign.entity.name}</p>
                        <p class="text-xs text-slate-600 mb-1">${campaign.entity.email}</p>
                        <p class="text-xs text-slate-500">${campaign.entity.address}</p>
                    </div>
                </div>
            </div>

            <div class="border-t border-slate-100 pt-6">
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">Campaign Duration</p>
                <div class="grid grid-cols-2 gap-4">
                    <div class="p-4 bg-slate-50 rounded-xl">
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Start Date</p>
                        <p class="text-sm font-medium text-slate-900">${startDate}</p>
                    </div>
                    <div class="p-4 bg-slate-50 rounded-xl">
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">End Date</p>
                        <p class="text-sm font-medium text-slate-900">${endDate}</p>
                    </div>
                </div>
            </div>

            <div class="border-t border-slate-100 pt-6">
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">Description</p>
                <div class="p-4 bg-slate-50 rounded-xl">
                    <p class="text-sm text-slate-700 leading-relaxed whitespace-pre-line">${campaign.description}</p>
                </div>
            </div>

            ${rejectionHtml}
        `;

        $('#campaignDetailContent').html(html);
    }

    // Backdrop click handler
    $(document).on('click', '[data-modal-backdrop]', function(e) {
        if ($(e.target).is('[data-modal-backdrop]')) {
            const openModal = $('.fixed.inset-0.z-50:not(.hidden)').attr('id');
            if (openModal) {
                Modal.close(openModal);
            }
        }
    });

    // ESC key handler
    $(document).on('keydown', function(e) {
        if (e.key === 'Escape' && !$('#campaignDetailModal').hasClass('hidden')) {
            Modal.close('campaignDetailModal');
        }
    });
</script>
@endpush

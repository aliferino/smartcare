{{-- Campaign Form Modal --}}
<div id="campaignModal" class="fixed inset-0 z-50 hidden overflow-y-auto opacity-0 transition-opacity duration-300">
    <div class="flex min-h-full items-center justify-center p-4">
        <div data-modal-backdrop class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
        <div class="bg-white rounded-3xl shadow-2xl z-50 w-full max-w-2xl relative my-8 overflow-hidden transform scale-95 opacity-0 transition-all duration-300 ease-in-out">
            <div class="px-8 py-6 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
                <div>
                    <h3 id="modalTitle" class="text-lg font-black text-slate-900 uppercase tracking-tight">Create Campaign</h3>
                    <p class="text-[10px] font-bold text-blue-600 uppercase tracking-widest mt-1">Fill in the details below</p>
                </div>
                <button onclick="Modal.close('campaignModal')" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-slate-200 text-slate-400 transition-colors text-xl">&times;</button>
            </div>
            <form id="campaignForm" class="p-8">
                @csrf
                <input type="hidden" id="campaignId" name="campaign_id">
                <input type="hidden" id="formMethod" value="create">
                <div class="space-y-6">
                    <div>
                        <label class="block mb-2 text-sm font-medium text-slate-700">Entity <span class="text-red-500">*</span></label>
                        <select name="entity_id" id="entityId" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                            <option value="">Select entity</option>
                            @foreach($entities as $entity)
                                <option value="{{ $entity->id }}">{{ $entity->name }}</option>
                            @endforeach
                        </select>
                        @if($entities->isEmpty())
                            <p class="mt-1 text-xs text-amber-600">You need at least one approved entity to create a campaign.</p>
                        @endif
                        <span class="text-xs text-red-600 hidden" id="error-entity_id"></span>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-slate-700">Category <span class="text-red-500">*</span></label>
                        <select name="category_id" id="categoryId" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                            <option value="">Select category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <span class="text-xs text-red-600 hidden" id="error-category_id"></span>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-slate-700">Campaign Title <span class="text-red-500">*</span></label>
                        <input type="text" name="title" id="campaignTitle" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" placeholder="Enter campaign title">
                        <span class="text-xs text-red-600 hidden" id="error-title"></span>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-slate-700">Description <span class="text-red-500">*</span></label>
                        <textarea name="description" id="campaignDescription" required rows="4" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" placeholder="Describe your campaign..."></textarea>
                        <span class="text-xs text-red-600 hidden" id="error-description"></span>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-slate-700">Goal Amount (IDR) <span class="text-red-500">*</span></label>
                        <input type="number" name="goal_amount" id="goalAmount" required min="1" step="0.01" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" placeholder="1000000">
                        <span class="text-xs text-red-600 hidden" id="error-goal_amount"></span>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-slate-700">Start Date <span class="text-red-500">*</span></label>
                        <input type="datetime-local" name="start_at" id="startAt" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                        <span class="text-xs text-red-600 hidden" id="error-start_at"></span>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-slate-700">End Date <span class="text-red-500">*</span></label>
                        <input type="datetime-local" name="end_at" id="endAt" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                        <span class="text-xs text-red-600 hidden" id="error-end_at"></span>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" name="is_urgent" id="isUrgent" value="1" class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-2 focus:ring-blue-500">
                        <label for="isUrgent" class="ml-2 text-sm font-medium text-slate-700">Mark as urgent campaign</label>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-slate-700">Campaign Image <span class="text-red-500">*</span></label>
                        <div id="currentImagePreview" class="hidden mb-3">
                            <p class="text-xs text-slate-500 mb-2">Current Image:</p>
                            <img id="currentImageDisplay" src="" alt="Current Campaign Image" class="w-full h-48 object-cover rounded-lg border border-slate-200">
                            <p class="text-xs text-slate-500 mt-2">Upload a new image to replace the current one</p>
                        </div>
                        <input type="file" name="image" id="campaignImage" accept="image/jpeg,image/png,image/jpg" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                        <p class="mt-1 text-xs text-slate-500">Max 2MB. Formats: JPG, PNG</p>
                        <span class="text-xs text-red-600 hidden" id="error-image"></span>
                    </div>
                </div>
                <div class="mt-8 flex gap-3">
                    <button type="button" onclick="Modal.close('campaignModal')" class="flex-1 px-6 py-3 border border-slate-300 text-slate-700 text-sm font-medium rounded-lg hover:bg-slate-50 transition-colors">Cancel</button>
                    <button type="submit" id="submitBtn" class="flex-1 px-6 py-3 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors"><span id="submitBtnText">Create Campaign</span></button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Campaign Detail Modal --}}
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
            <div id="campaignDetailContent" class="p-8 space-y-6"></div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

    window.Modal = window.Modal || {};
    const originalOpen = window.Modal.open;
    window.Modal.open = function(modalId, options = {}) {
        if (modalId === 'campaignModal') {
            resetForm();
            if (options.mode === 'edit' && options.campaign) populateForm(options.campaign);
        }
        if (originalOpen) {
            originalOpen(modalId, options);
        } else {
            $('#' + modalId).removeClass('hidden');
            $('body').css('overflow', 'hidden');
            requestAnimationFrame(() => {
                requestAnimationFrame(() => {
                    $('#' + modalId).removeClass('opacity-0');
                    $('#' + modalId + ' .transform').removeClass('opacity-0 scale-95').addClass('scale-100 opacity-100');
                });
            });
        }
    };

    const originalClose = window.Modal.close;
    window.Modal.close = function(modalId) {
        if (originalClose) {
            originalClose(modalId);
        } else {
            $('#' + modalId).addClass('opacity-0');
            $('#' + modalId + ' .transform').removeClass('scale-100 opacity-100').addClass('opacity-0 scale-95');
            setTimeout(() => {
                $('#' + modalId).addClass('hidden');
                $('body').css('overflow', '');
            }, 300);
        }
    };

    function resetForm() {
        $('#campaignForm')[0].reset();
        $('#campaignId').val('');
        $('#formMethod').val('create');
        $('#modalTitle').text('Create Campaign');
        $('#submitBtnText').text('Create Campaign');
        $('.text-red-600').addClass('hidden').text('');
        $('#currentImagePreview').addClass('hidden');
        $('#campaignImage').prop('required', true);
    }

    function populateForm(campaign) {
        $('#campaignId').val(campaign.id);
        $('#formMethod').val('edit');
        $('#modalTitle').text('Edit Campaign');
        $('#submitBtnText').text('Update Campaign');
        $('#entityId').val(campaign.entity_id);
        $('#categoryId').val(campaign.category_id);
        $('#campaignTitle').val(campaign.title);
        $('#campaignDescription').val(campaign.description);
        $('#goalAmount').val(campaign.goal_amount);
        if (campaign.start_at) {
            const startDate = new Date(campaign.start_at);
            $('#startAt').val(startDate.toISOString().slice(0, 16));
        }
        if (campaign.end_at) {
            const endDate = new Date(campaign.end_at);
            $('#endAt').val(endDate.toISOString().slice(0, 16));
        }
        $('#isUrgent').prop('checked', campaign.is_urgent);
        if (campaign.primary_image && campaign.primary_image.image_path) {
            $('#currentImageDisplay').attr('src', '/storage/' + campaign.primary_image.image_path);
            $('#currentImagePreview').removeClass('hidden');
            $('#campaignImage').prop('required', false);
        }
    }

    $('#campaignForm').on('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const method = $('#formMethod').val();
        const campaignId = $('#campaignId').val();
        let url = method === 'edit' ? `/fundraiser/campaigns/${campaignId}/update` : '/fundraiser/campaigns/store';
        if (method === 'edit') formData.append('_method', 'PUT');
        $('.text-red-600').addClass('hidden').text('');
        $('#submitBtn').prop('disabled', true).addClass('opacity-50');
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    Modal.close('campaignModal');
                    location.reload();
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    for (let field in errors) {
                        $(`#error-${field}`).removeClass('hidden').text(errors[field][0]);
                    }
                } else {
                    alert(xhr.responseJSON?.message || 'An error occurred');
                }
            },
            complete: function() {
                $('#submitBtn').prop('disabled', false).removeClass('opacity-50');
            }
        });
    });

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
        let statusBadge = campaign.status === 'approved' ? '<span class="px-3 py-1.5 rounded-lg bg-emerald-50 text-emerald-600 text-xs font-black uppercase">Approved</span>' :
            campaign.status === 'pending' ? '<span class="px-3 py-1.5 rounded-lg bg-amber-50 text-amber-600 text-xs font-black uppercase">Pending</span>' :
            campaign.status === 'completed' ? '<span class="px-3 py-1.5 rounded-lg bg-blue-50 text-blue-600 text-xs font-black uppercase">Completed</span>' :
            '<span class="px-3 py-1.5 rounded-lg bg-rose-50 text-rose-600 text-xs font-black uppercase">Rejected</span>';
        let urgentBadge = campaign.is_urgent ? '<span class="px-2 py-1 rounded bg-red-50 text-red-600 text-[9px] font-black uppercase">Urgent</span>' : '';
        let imageHtml = (campaign.primary_image && campaign.primary_image.image_path) ? `<div class="mb-6"><img src="/storage/${campaign.primary_image.image_path}" class="w-full h-64 object-cover rounded-xl shadow-sm" alt="Campaign Image"></div>` : '';
        let rejectionHtml = (campaign.status === 'rejected' && campaign.rejection_reason) ? `<div class="p-4 bg-rose-50 border border-rose-100 rounded-xl"><p class="text-xs font-bold text-rose-900 uppercase tracking-wider mb-2">Rejection Reason</p><p class="text-sm text-rose-700">${campaign.rejection_reason}</p></div>` : '';
        const startDate = new Date(campaign.start_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
        const endDate = new Date(campaign.end_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
        let entityLogo = campaign.entity.logo_path ? `<img src="/storage/${campaign.entity.logo_path}" class="w-12 h-12 rounded-xl object-cover shadow-sm">` : `<div class="w-12 h-12 rounded-xl bg-slate-100 flex items-center justify-center text-lg font-black text-slate-900 shadow-sm">${campaign.entity.name.charAt(0)}</div>`;
        const html = `${imageHtml}<div class="flex items-start justify-between"><div><div class="flex items-center gap-2 mb-2"><h4 class="text-xl font-black text-slate-900 uppercase tracking-tight">${campaign.title}</h4>${urgentBadge}</div><p class="text-xs font-bold text-blue-600 uppercase tracking-widest">${campaign.campaign_category.name}</p></div>${statusBadge}</div><div class="grid grid-cols-2 gap-4"><div class="p-4 bg-slate-50 rounded-xl"><p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Goal Amount</p><p class="text-lg font-black text-slate-900">IDR ${Number(campaign.goal_amount).toLocaleString('id-ID')}</p></div><div class="p-4 bg-slate-50 rounded-xl"><p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Current Amount</p><p class="text-lg font-black text-slate-900">IDR ${Number(campaign.current_amount).toLocaleString('id-ID')}</p></div></div><div class="p-4 bg-blue-50 rounded-xl"><div class="flex justify-between items-center mb-2"><p class="text-xs font-bold text-blue-900 uppercase tracking-wider">Progress</p><p class="text-sm font-black text-blue-900">${percentageRounded}%</p></div><div class="w-full bg-white rounded-full h-2.5"><div class="bg-blue-600 h-2.5 rounded-full" style="width: ${percentageRounded}%"></div></div><p class="text-[10px] text-blue-700 mt-2">${campaign.donors_count} donors contributed</p></div><div class="border-t border-slate-100 pt-6"><p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">Entity Information</p><div class="flex items-start gap-4 p-4 bg-slate-50 rounded-xl">${entityLogo}<div class="flex-1"><p class="text-sm font-black text-slate-900 uppercase tracking-tight mb-1">${campaign.entity.name}</p><p class="text-xs text-slate-600 mb-1">${campaign.entity.email}</p><p class="text-xs text-slate-500">${campaign.entity.address}</p></div></div></div><div class="border-t border-slate-100 pt-6"><p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">Campaign Duration</p><div class="grid grid-cols-2 gap-4"><div class="p-4 bg-slate-50 rounded-xl"><p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Start Date</p><p class="text-sm font-medium text-slate-900">${startDate}</p></div><div class="p-4 bg-slate-50 rounded-xl"><p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">End Date</p><p class="text-sm font-medium text-slate-900">${endDate}</p></div></div></div><div class="border-t border-slate-100 pt-6"><p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">Description</p><div class="p-4 bg-slate-50 rounded-xl"><p class="text-sm text-slate-700 leading-relaxed whitespace-pre-line">${campaign.description}</p></div></div>${rejectionHtml}`;
        $('#campaignDetailContent').html(html);
    }

    $(document).on('click', '[data-modal-backdrop]', function(e) {
        if ($(e.target).is('[data-modal-backdrop]')) {
            const openModal = $('.fixed.inset-0.z-50:not(.hidden)').attr('id');
            if (openModal) Modal.close(openModal);
        }
    });

    $(document).on('keydown', function(e) {
        if (e.key === 'Escape') {
            if (!$('#campaignModal').hasClass('hidden')) Modal.close('campaignModal');
            if (!$('#campaignDetailModal').hasClass('hidden')) Modal.close('campaignDetailModal');
        }
    });
</script>
@endpush

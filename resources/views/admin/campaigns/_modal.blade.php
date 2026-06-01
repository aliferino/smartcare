<div id="campaignModal" class="fixed inset-0 z-50 hidden overflow-y-auto opacity-0 transition-opacity duration-300">
    <div class="flex min-h-full items-center justify-center p-4">
        <div data-modal-backdrop class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"></div>

        <div class="bg-white rounded-3xl shadow-2xl z-50 w-full max-w-2xl relative my-8 overflow-hidden transform scale-95 opacity-0 transition-all duration-300 ease-in-out">
            <div class="px-8 py-6 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
                <div class="flex items-center gap-4">
                    <div id="detImageWrapper" class="w-12 h-12 rounded-xl bg-slate-200 overflow-hidden shadow-inner flex items-center justify-center border border-slate-100"></div>
                    <div>
                        <h3 id="detTitle" class="text-lg font-black text-slate-900 uppercase tracking-tight leading-none"></h3>
                        <p id="detCategory" class="text-[10px] font-bold text-blue-600 uppercase tracking-widest mt-1"></p>
                    </div>
                </div>
                <button onclick="Modal.close('campaignModal')" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-slate-200 text-slate-400 transition-colors text-xl font-bold">&times;</button>
            </div>

            <div class="px-8 py-8 space-y-6">
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-1.5">Entity / Organizer</label>
                        <p id="detEntity" class="text-xs font-bold text-slate-900 uppercase"></p>
                    </div>
                    <div>
                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-1.5">Urgent Status</label>
                        <div id="detUrgentBadge"></div> 
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-1.5">Approval Status</label>
                        <div id="detStatusBadge"></div>
                    </div>
                    <div>
                        <label id="dynamicLabel" class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-1.5">Visibility Status</label>
                        <div id="dynamicStatusContent" class="group transition-all"></div>
                    </div>
                </div>

                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100 space-y-6">
                    <div class="text-center">
                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-2 italic">Campaign Period</label>
                        <div class="flex items-center gap-4">
                            <div class="flex-1">
                                <p class="text-[8px] font-black text-slate-400 uppercase">Start Date</p>
                                <p id="detStart" class="text-xs font-bold text-slate-700"></p>
                            </div>
                            <div class="w-px h-8 bg-slate-200"></div>
                            <div class="flex-1">
                                <p class="text-[8px] font-black text-slate-400 uppercase">End Date</p>
                                <p id="detEnd" class="text-xs font-bold text-slate-700"></p>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-200/60">
                        <div class="flex justify-between items-end mb-2">
                            <p class="text-xs font-black text-slate-900 uppercase tracking-tighter">
                                <span id="detCurrentAmount">Rp 0</span> <span class="text-[9px] text-slate-400 font-bold ml-1">Collected</span>
                            </p>
                            <p class="text-[10px] font-bold text-slate-400 italic">Target: <span id="detGoalAmount">Rp 0</span></p>
                        </div>
                        <div class="w-full bg-white rounded-full h-2.5 shadow-inner overflow-hidden border border-slate-200/50">
                            <div id="detProgressBar" class="bg-blue-600 h-full rounded-full transition-all duration-1000" style="width: 0%"></div>
                        </div>
                        <div class="flex justify-end mt-1">
                            <span id="detProgressPercentage" class="text-[10px] font-black text-blue-600">0%</span>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-2">Description</label>
                    <div id="detDescription" class="text-xs font-medium text-slate-600 leading-relaxed bg-slate-50/50 p-4 rounded-2xl border border-slate-100 max-h-32 overflow-y-auto italic text-justify"></div>
                </div>

                <div id="rejectionReasonWrapper" class="hidden bg-rose-50 border border-rose-100 rounded-2xl p-4 animate-in fade-in slide-in-from-top-2 duration-300">
                    <div class="flex gap-3">
                        <div class="w-8 h-8 rounded-lg bg-rose-500 flex items-center justify-center shrink-0">
                            <span class="text-white text-xs font-black">!</span>
                        </div>
                        <div>
                            <label class="text-[9px] font-black text-rose-500 uppercase tracking-widest block mb-0.5">Rejection Reason</label>
                            <p id="detRejectionReason" class="text-xs font-bold text-rose-700 leading-relaxed"></p>
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-100 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div id="detUserAvatar" class="w-10 h-10 rounded-full bg-blue-100 border-2 border-white shadow-sm flex items-center justify-center text-xs font-black text-blue-600 uppercase"></div>
                        <div>
                            <p id="detUserName" class="text-xs font-black text-slate-900 uppercase tracking-tight leading-none mb-1"></p>
                            <p id="detUserEmail" class="text-[10px] font-bold text-slate-400 lowercase"></p>
                        </div>
                    </div>
                    <div class="text-right space-y-1">
                        <div class="flex flex-col">
                            <span class="text-[8px] font-black text-slate-300 uppercase italic">Created:</span>
                            <span id="detCreatedAt" class="text-[10px] font-bold text-slate-500 font-mono"></span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[8px] font-black text-slate-300 uppercase italic">Updated:</span>
                            <span id="detUpdatedAt" class="text-[10px] font-bold text-slate-500 font-mono"></span>
                        </div>
                    </div>
                </div>
            </div>

            <div id="modalActions" class="px-8 py-6 bg-slate-50 border-t border-slate-100 hidden">
                <div id="rejectSection" class="hidden pt-4 border-t-2 border-rose-50 animate-pulse mb-4">
                    <label class="text-[9px] font-black text-rose-500 uppercase tracking-widest block mb-2">Rejection Reason</label>
                    <textarea id="rejectionReason" class="w-full p-4 bg-rose-50/30 border border-rose-100 rounded-xl text-sm focus:ring-2 focus:ring-rose-500 outline-none transition-all" placeholder="Explain why this campaign is being rejected..." rows="2"></textarea>
                </div>
                <div class="flex gap-3">
                    <button id="btnApprove" class="flex-1 bg-emerald-500 text-white text-xs font-black py-4 rounded-xl uppercase hover:bg-emerald-600 transition-all shadow-lg shadow-emerald-200">Approve Campaign</button>
                    <button id="btnRejectMode" class="flex-1 bg-rose-500 text-white text-xs font-black py-4 rounded-xl uppercase hover:bg-rose-600 transition-all shadow-lg shadow-rose-200">Reject Campaign</button>
                    <button id="btnSubmitReject" class="hidden flex-1 bg-rose-600 text-white text-xs font-black py-4 rounded-xl uppercase hover:bg-rose-700 transition-all shadow-lg shadow-rose-200">Confirm Rejection</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let currentCampaignId = null;

    // Setup CSRF token
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    // Helper functions
    function formatRupiah(amount) {
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(amount);
    }

    function formatDate(dateString, options = {}) {
        const defaults = { day: 'numeric', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit' };
        return new Date(dateString).toLocaleString('id-ID', { ...defaults, ...options });
    }

    function statusBadge(status) {
        const colors = {
            'pending': 'bg-amber-50 text-amber-600',
            'approved': 'bg-emerald-50 text-emerald-600',
            'rejected': 'bg-rose-50 text-rose-600',
            'completed': 'bg-blue-50 text-blue-600'
        };
        const className = colors[status] || 'bg-slate-50 text-slate-600';
        return `<span class="px-2 py-1 rounded text-[10px] font-black uppercase tracking-tighter ${className}">${status}</span>`;
    }

    // Modal functions
    function openCampaignModal(id) {
        currentCampaignId = id;

        $.get(`/admin/campaigns/list/${id}/detail`, function(data) {
            // Reset form state
            $('#rejectSection, #btnSubmitReject').addClass('hidden');
            $('#btnApprove, #btnRejectMode').removeClass('hidden');
            $('#rejectionReason').val('');

            // Populate modal with data
            $('#detTitle').text(data.title);
            $('#detCategory').text(data.campaign_category?.name || 'Uncategorized');
            $('#detEntity').text(data.entity?.name || '-');
            $('#detDescription').text(data.description);

            const rejectWrapper = $('#rejectionReasonWrapper');
            if(data.status === 'rejected' && data.rejection_reason) {
                rejectWrapper.removeClass('hidden');
                $('#detRejectionReason').text(data.rejection_reason);
            } else {
                rejectWrapper.addClass('hidden');
                $('#detRejectionReason').text('');
            }

            $('#detStart').text(formatDate(data.start_at));
            $('#detEnd').text(formatDate(data.end_at));
            $('#detCreatedAt').text(formatDate(data.created_at));
            $('#detUpdatedAt').text(formatDate(data.updated_at));

            $('#detImageWrapper').html(data.image_path ? `<img src="/storage/${data.image_path}" class="w-full h-full object-cover">` : '<span class="text-[9px] text-slate-300 font-black">NO IMG</span>');

            const goal = parseFloat(data.goal_amount) || 0;
            const current = parseFloat(data.current_amount) || 0;
            const percentage = goal > 0 ? Math.min(100, Math.round((current / goal) * 100)) : 0;

            $('#detGoalAmount').text(formatRupiah(goal));
            $('#detCurrentAmount').text(formatRupiah(current));
            $('#detProgressPercentage').text(percentage + '%');
            $('#detProgressBar').css('width', percentage + '%');

            $('#detStatusBadge').html(statusBadge(data.status));

            if(data.is_urgent) {
                $('#detUrgentBadge').html('<span class="px-2 py-0.5 rounded bg-rose-100 text-rose-600 text-[8px] font-black uppercase tracking-tighter">Urgent</span>');
            } else {
                $('#detUrgentBadge').html('<span class="px-2 py-0.5 rounded bg-slate-100 text-slate-400 text-[8px] font-black uppercase tracking-tighter">Regular</span>');
            }

            const user = data.user || {};
            $('#detUserName').text(user.name || 'Unknown');
            $('#detUserEmail').text(user.email || '-');
            $('#detUserAvatar').text(user.name ? user.name.charAt(0).toUpperCase() : '?');

            const dynamicContent = $('#dynamicStatusContent');
            dynamicContent.removeClass('clickable-status');

            if(data.status !== 'pending') {
                $('#dynamicLabel').text('Visibility Status');
                dynamicContent.addClass('clickable-status');
                const isVisible = data.is_active;
                const activeLabel = isVisible ? 'VISIBLE' : 'INVISIBLE';
                const activeColor = isVisible ? 'text-emerald-600' : 'text-rose-500';
                const hoverText = isVisible ? 'Click to Invisible' : 'Click to Visible';

                dynamicContent.html(`
                    <div class="flex flex-col group cursor-pointer">
                        <span class="text-sm font-black ${activeColor} leading-none transition-colors">${activeLabel}</span>
                        <span class="text-[8px] font-bold text-slate-400 uppercase tracking-tighter opacity-0 group-hover:opacity-100 transition-opacity">${hoverText}</span>
                    </div>
                `);
            } else {
                $('#dynamicLabel').text('Visibility Status');
                dynamicContent.html('<span class="text-xs font-bold text-slate-300 italic">Waiting Approval</span>');
            }

            data.status === 'pending' ? $('#modalActions').removeClass('hidden') : $('#modalActions').addClass('hidden');

            // Show modal with animation
            $('#campaignModal').removeClass('hidden');
            $('body').css('overflow', 'hidden');

            requestAnimationFrame(() => {
                requestAnimationFrame(() => {
                    $('#campaignModal').removeClass('opacity-0');
                    $('#campaignModal .transform').removeClass('opacity-0 scale-95').addClass('scale-100 opacity-100');
                });
            });
        }).fail(() => alert('Gagal memuat data'));
    }

    function closeCampaignModal() {
        $('#campaignModal').addClass('opacity-0');
        $('#campaignModal .transform').removeClass('scale-100 opacity-100').addClass('opacity-0 scale-95');

        setTimeout(() => {
            $('#campaignModal').addClass('hidden');
            $('body').css('overflow', '');
        }, 300);
    }

    $(document).ready(function() {
        // Detail button click handler
        $(document).on('click', '.btn-detail', function() {
            const id = $(this).data('id');
            openCampaignModal(id);
        });

        // Close button and backdrop handlers
        $(document).on('click', '[data-modal-backdrop]', function() {
            closeCampaignModal();
        });

        // ESC key handler
        $(document).on('keydown', function(e) {
            if (e.key === 'Escape' && !$('#campaignModal').hasClass('hidden')) {
                closeCampaignModal();
            }
        });

        // Toggle active status
        $(document).on('click', '#dynamicStatusContent.clickable-status', function() {
            const container = $(this);
            container.addClass('opacity-50 pointer-events-none');

            $.post(`/admin/campaigns/list/${currentCampaignId}/toggle-active`, function(data) {
                if(data.success) {
                    const isNowVisible = data.new_status === 'VISIBLE';
                    const activeColor = isNowVisible ? 'text-emerald-600' : 'text-rose-500';
                    const hoverText = isNowVisible ? 'Click to Invisible' : 'Click to Visible';

                    container.html(`
                        <div class="flex flex-col group cursor-pointer">
                            <span class="text-sm font-black ${activeColor} leading-none transition-colors">${data.new_status}</span>
                            <span class="text-[8px] font-bold text-slate-400 uppercase tracking-tighter opacity-0 group-hover:opacity-100 transition-opacity">${hoverText}</span>
                        </div>
                    `);

                    $(`.status-active-${currentCampaignId}`).text(data.new_status);
                }
            })
            .fail(() => alert('Gagal memperbarui visibilitas.'))
            .always(() => container.removeClass('opacity-50 pointer-events-none'));
        });
    });

    // Approve/Reject handlers
    $('#btnRejectMode').click(function() {
        $('#rejectSection, #btnSubmitReject').removeClass('hidden');
        $(this).addClass('hidden');
        $('#btnApprove').addClass('hidden');
    });

    $('#btnApprove').click(() => updateCampaignStatus('approved'));
    $('#btnSubmitReject').click(() => updateCampaignStatus('rejected', $('#rejectionReason').val()));

    function updateCampaignStatus(status, reason = '') {
        $.post(`/admin/campaigns/list/${currentCampaignId}/update-status`, { status, reason })
        .done(() => location.reload())
        .fail(() => alert('Gagal memperbarui status.'));
    }
</script>
<div id="campaignModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 py-10">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeModal()"></div>
        
        <div class="bg-white rounded-3xl shadow-2xl z-50 w-full max-w-2xl overflow-hidden border border-slate-100 transition-all">
            <div class="px-8 py-6 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
                <div class="flex items-center gap-4">
                    <div id="detImageWrapper" class="w-12 h-12 rounded-xl bg-slate-200 overflow-hidden shadow-inner flex items-center justify-center border border-slate-100"></div>
                    <div>
                        <h3 id="detTitle" class="text-lg font-black text-slate-900 uppercase tracking-tight leading-none"></h3>
                        <p id="detCategory" class="text-[10px] font-bold text-blue-600 uppercase tracking-widest mt-1"></p>
                    </div>
                </div>
                <button onclick="closeModal()" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-slate-200 text-slate-400 transition-colors text-xl font-bold">&times;</button>
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

                <div id="rejectionReasonWrapper" class="hidden mt-4">
                    <label class="text-[9px] font-black text-rose-400 uppercase tracking-widest block mb-2">Rejection Reason</label>
                    <div id="detRejectionReason" class="text-xs font-bold text-rose-600 leading-relaxed bg-rose-50/50 p-4 rounded-2xl border border-rose-100 max-h-32 overflow-y-auto italic"></div>
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
                <div id="rejectSection" class="mb-4 hidden">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-2 italic">Reason for Rejection</label>
                    <textarea id="rejectionReason" class="w-full p-4 bg-white border border-slate-200 rounded-xl text-xs font-medium focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 outline-none" rows="2"></textarea>
                </div>
                <div class="flex gap-3">
                    <button id="btnApprove" class="flex-[2] bg-emerald-600 hover:bg-emerald-700 text-white py-3.5 rounded-xl text-[10px] font-black uppercase tracking-[0.2em] shadow-lg shadow-emerald-500/20 transition-all">Approve Campaign</button>
                    <button id="btnRejectMode" class="flex-1 bg-rose-50 text-rose-600 hover:bg-rose-100 py-3.5 rounded-xl text-[10px] font-black uppercase tracking-[0.2em]">Reject</button>
                    <button id="btnSubmitReject" class="flex-1 bg-rose-600 hover:bg-rose-700 text-white py-3.5 rounded-xl text-[10px] font-black uppercase tracking-[0.2em] hidden">Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let currentCampaignId = null;

    $(document).ready(function() {
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        $(document).on('click', '.btn-detail', function() {
            openCampaignDetail($(this).data('id'));
        });

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

    function openCampaignDetail(id) {
        currentCampaignId = id;
        $.get(`/admin/campaigns/list/${id}/detail`, function(data) {
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
            
            const dateCfg = { day: 'numeric', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit' };
            $('#detStart').text(new Date(data.start_at).toLocaleString('id-ID', dateCfg));
            $('#detEnd').text(new Date(data.end_at).toLocaleString('id-ID', dateCfg));
            $('#detCreatedAt').text(new Date(data.created_at).toLocaleString('id-ID', dateCfg));
            $('#detUpdatedAt').text(new Date(data.updated_at).toLocaleString('id-ID', dateCfg));

            $('#detImageWrapper').html(data.primary_image ? `<img src="/storage/${data.primary_image.image_path}" class="w-full h-full object-cover">` : '<span class="text-[9px] text-slate-300 font-black">NO IMG</span>');

            const goal = parseFloat(data.goal_amount) || 0;
            const current = parseFloat(data.current_amount) || 0;
            const percentage = goal > 0 ? Math.min(100, Math.round((current / goal) * 100)) : 0;
            const formatRp = (val) => 'Rp ' + new Intl.NumberFormat('id-ID').format(val);

            $('#detGoalAmount').text(formatRp(goal));
            $('#detCurrentAmount').text(formatRp(current));
            $('#detProgressPercentage').text(percentage + '%');
            $('#detProgressBar').css('width', percentage + '%');

            const sMap = { 
                'pending': 'bg-amber-100 text-amber-600', 
                'approved': 'bg-emerald-100 text-emerald-600', 
                'rejected': 'bg-rose-100 text-rose-600',
                'completed': 'bg-blue-100 text-blue-600'
            };
            $('#detStatusBadge').html(`<span class="px-3 py-1 rounded-full text-[10px] font-black uppercase ${sMap[data.status]}">${data.status}</span>`);

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
            $('#campaignModal').removeClass('hidden');
        });
    }

    function closeModal() {
        $('#campaignModal').addClass('hidden');
        $('#rejectSection, #btnSubmitReject').addClass('hidden');
        $('#btnApprove, #btnRejectMode').removeClass('hidden');
        $('#rejectionReason').val('');
    }

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
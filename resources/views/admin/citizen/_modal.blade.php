<div id="citizenModal" class="fixed inset-0 z-50 hidden overflow-y-auto opacity-0 transition-opacity duration-300">
    <div class="flex min-h-full items-center justify-center p-4">
        <div data-modal-backdrop class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"></div>

        <div class="bg-white rounded-3xl shadow-2xl z-50 w-full max-w-3xl relative my-8 overflow-hidden transform scale-95 opacity-0 transition-all duration-300 ease-in-out">
            <div class="px-8 py-6 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
                <div class="flex items-center gap-4">
                    <div id="detAvatar" class="w-12 h-12 rounded-full bg-blue-100 border-2 border-white shadow-sm flex items-center justify-center text-lg font-black text-blue-600 uppercase"></div>
                    <div>
                        <h3 id="detFullName" class="text-lg font-black text-slate-900 uppercase tracking-tight leading-none"></h3>
                        <p id="detUserName" class="text-[10px] font-bold text-blue-600 uppercase tracking-widest mt-1"></p>
                    </div>
                </div>
                <button onclick="Modal.close('citizenModal')" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-slate-200 text-slate-400 transition-colors text-xl font-bold">&times;</button>
            </div>

            <div class="px-8 py-8 space-y-6">
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-1.5">Full Name</label>
                        <p id="detFullNameField" class="text-xs font-bold text-slate-900"></p>
                    </div>
                    <div>
                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-1.5">ID Number (NIK)</label>
                        <p id="detIdNumber" class="text-xs font-bold text-slate-900 font-mono"></p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-1.5">Gender</label>
                        <p id="detGender" class="text-xs font-bold text-slate-700 uppercase"></p>
                    </div>
                    <div>
                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-1.5">Phone Number</label>
                        <p id="detPhone" class="text-xs font-bold text-slate-700"></p>
                    </div>
                </div>

                <div>
                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-1.5">Status</label>
                    <div id="detStatusBadge"></div>
                </div>

                <div>
                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-1.5">Address</label>
                    <p id="detAddress" class="text-xs font-medium text-slate-600 leading-relaxed bg-slate-50/50 p-4 rounded-2xl border border-slate-100"></p>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-2">ID Card Photo</label>
                        <div id="detIdCard" class="w-full h-48 rounded-2xl bg-slate-100 overflow-hidden border border-slate-200 flex items-center justify-center cursor-zoom-in hover:border-blue-400 transition-all"></div>
                    </div>
                    <div>
                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-2">Selfie Photo</label>
                        <div id="detSelfie" class="w-full h-48 rounded-2xl bg-slate-100 overflow-hidden border border-slate-200 flex items-center justify-center cursor-zoom-in hover:border-blue-400 transition-all"></div>
                    </div>
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
                    <div>
                        <p id="detUserEmail" class="text-xs font-bold text-slate-900 lowercase mb-1"></p>
                        <p class="text-[9px] text-slate-400 font-medium uppercase tracking-tighter">User Account</p>
                    </div>
                    <div class="text-right space-y-1">
                        <div class="flex flex-col">
                            <span class="text-[8px] font-black text-slate-300 uppercase italic">Submitted:</span>
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
                    <textarea id="rejectionReason" class="w-full p-4 bg-rose-50/30 border border-rose-100 rounded-xl text-sm focus:ring-2 focus:ring-rose-500 outline-none transition-all" placeholder="Explain why this KYC submission is being rejected..." rows="2"></textarea>
                </div>
                <div class="flex gap-3">
                    <button id="btnApprove" class="flex-1 bg-emerald-500 text-white text-xs font-black py-4 rounded-xl uppercase hover:bg-emerald-600 transition-all shadow-lg shadow-emerald-200">Approve KYC</button>
                    <button id="btnRejectMode" class="flex-1 bg-rose-500 text-white text-xs font-black py-4 rounded-xl uppercase hover:bg-rose-600 transition-all shadow-lg shadow-rose-200">Reject KYC</button>
                    <button id="btnSubmitReject" class="hidden flex-1 bg-rose-600 text-white text-xs font-black py-4 rounded-xl uppercase hover:bg-rose-700 transition-all shadow-lg shadow-rose-200">Confirm Rejection</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="imageOverlay" class="fixed inset-0 z-[60] hidden bg-slate-900/95 backdrop-blur-md flex items-center justify-center p-4 overflow-hidden">
    <button onclick="closeImageOverlay()" class="absolute top-6 right-6 text-white text-4xl hover:scale-110 transition-transform focus:outline-none">&times;</button>
    <div class="relative w-full h-full flex items-center justify-center overflow-auto p-10">
        <img id="zoomedImg" src="" class="max-w-none transition-transform duration-200 ease-out cursor-move" style="transform: scale(1);">
    </div>
    <div class="absolute bottom-10 left-1/2 -translate-x-1/2 flex gap-4 bg-white/10 backdrop-blur rounded-full px-6 py-3 border border-white/20">
        <button onclick="zoomImage(-0.2)" class="text-white font-black text-lg">-</button>
        <span id="zoomLevel" class="text-white text-[10px] font-black flex items-center">100%</span>
        <button onclick="zoomImage(0.2)" class="text-white font-black text-lg">+</button>
    </div>
</div>

<script>
    let currentCitizenId = null;
    let currentZoom = 1;

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    function formatDate(dateString) {
        return new Date(dateString).toLocaleString('id-ID', { day: 'numeric', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit' });
    }

    function statusBadge(status) {
        const colors = {
            'pending': 'bg-amber-50 text-amber-600',
            'approved': 'bg-emerald-50 text-emerald-600',
            'rejected': 'bg-rose-50 text-rose-600'
        };
        const className = colors[status] || 'bg-slate-50 text-slate-600';
        return `<span class="px-2 py-1 rounded text-[10px] font-black uppercase tracking-tighter ${className}">${status}</span>`;
    }

    function openCitizenModal(id) {
        currentCitizenId = id;

        $.get(`/admin/users/citizens/${id}/detail`, function(data) {
            $('#rejectSection, #btnSubmitReject').addClass('hidden');
            $('#btnApprove, #btnRejectMode').removeClass('hidden');
            $('#rejectionReason').val('');

            $('#detFullName').text(data.full_name);
            $('#detFullNameField').text(data.full_name);
            $('#detUserName').text(data.user?.name || 'Unknown');
            $('#detUserEmail').text(data.user?.email || '-');
            $('#detAvatar').text(data.full_name ? data.full_name.charAt(0).toUpperCase() : '?');
            $('#detIdNumber').text(data.id_number);
            $('#detGender').text(data.gender);
            $('#detPhone').text(data.phone_number);
            $('#detAddress').text(data.address);
            $('#detCreatedAt').text(formatDate(data.created_at));
            $('#detUpdatedAt').text(formatDate(data.updated_at));
            $('#detStatusBadge').html(statusBadge(data.status));

            const rejectWrapper = $('#rejectionReasonWrapper');
            if(data.status === 'rejected' && data.reject_reason) {
                rejectWrapper.removeClass('hidden');
                $('#detRejectionReason').text(data.reject_reason);
            } else {
                rejectWrapper.addClass('hidden');
            }

            $('#detIdCard').html(data.id_card_path ? `<img src="/storage/${data.id_card_path}" class="w-full h-full object-cover">` : '<span class="text-xs text-slate-300 font-black">NO IMAGE</span>');
            $('#detSelfie').html(data.selfie_path ? `<img src="/storage/${data.selfie_path}" class="w-full h-full object-cover">` : '<span class="text-xs text-slate-300 font-black">NO IMAGE</span>');

            data.status === 'pending' ? $('#modalActions').removeClass('hidden') : $('#modalActions').addClass('hidden');

            $('#citizenModal').removeClass('hidden');
            $('body').css('overflow', 'hidden');

            requestAnimationFrame(() => {
                requestAnimationFrame(() => {
                    $('#citizenModal').removeClass('opacity-0');
                    $('#citizenModal .transform').removeClass('opacity-0 scale-95').addClass('scale-100 opacity-100');
                });
            });
        }).fail(() => alert('Gagal memuat data'));
    }

    function closeCitizenModal() {
        $('#citizenModal').addClass('opacity-0');
        $('#citizenModal .transform').removeClass('scale-100 opacity-100').addClass('opacity-0 scale-95');
        setTimeout(() => {
            $('#citizenModal').addClass('hidden');
            $('body').css('overflow', '');
        }, 300);
    }

    $(document).ready(function() {
        $(document).on('click', '.btn-detail', function() {
            openCitizenModal($(this).data('id'));
        });

        $(document).on('click', '[data-modal-backdrop]', closeCitizenModal);

        $(document).on('keydown', function(e) {
            if (e.key === 'Escape' && !$('#citizenModal').hasClass('hidden')) {
                closeCitizenModal();
            }
        });

        // Image zoom handlers
        $('#detIdCard').click(function() {
            const img = $(this).find('img');
            if(img.length && img.attr('src')) {
                $('#zoomedImg').attr('src', img.attr('src'));
                $('#imageOverlay').removeClass('hidden');
                currentZoom = 1;
                updateZoomLevel();
            }
        });

        $('#detSelfie').click(function() {
            const img = $(this).find('img');
            if(img.length && img.attr('src')) {
                $('#zoomedImg').attr('src', img.attr('src'));
                $('#imageOverlay').removeClass('hidden');
                currentZoom = 1;
                updateZoomLevel();
            }
        });
    });

    $('#btnRejectMode').click(function() {
        $('#rejectSection, #btnSubmitReject').removeClass('hidden');
        $(this).addClass('hidden');
        $('#btnApprove').addClass('hidden');
    });

    $('#btnApprove').click(() => updateCitizenStatus('approved'));
    $('#btnSubmitReject').click(() => updateCitizenStatus('rejected', $('#rejectionReason').val()));

    function updateCitizenStatus(status, reason = '') {
        $.post(`/admin/users/citizens/${currentCitizenId}/update`, { status, reason })
        .done(() => location.reload())
        .fail(() => alert('Gagal memperbarui status.'));
    }

    // Zoom functions
    function zoomImage(delta) {
        currentZoom = Math.max(0.5, Math.min(3, currentZoom + delta));
        updateZoomLevel();
    }

    function updateZoomLevel() {
        $('#zoomedImg').css('transform', `scale(${currentZoom})`);
        $('#zoomLevel').text(Math.round(currentZoom * 100) + '%');
    }

    function closeImageOverlay() {
        $('#imageOverlay').addClass('hidden');
    }
</script>

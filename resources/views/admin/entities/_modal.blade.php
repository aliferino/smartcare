<div id="entityModal" class="fixed inset-0 z-50 hidden overflow-y-auto opacity-0 transition-opacity duration-300">
    <div class="flex min-h-full items-center justify-center p-4">
        <div data-modal-backdrop class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"></div>

        <div class="bg-white rounded-3xl shadow-2xl z-50 w-full max-w-2xl relative my-8 overflow-hidden transform scale-95 opacity-0 transition-all duration-300 ease-in-out">

            <div class="px-8 py-6 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
                <div class="flex items-center gap-4">
                    <div id="detLogoWrapper" class="w-12 h-12 rounded-xl flex items-center justify-center text-lg font-black shadow-inner overflow-hidden"></div>
                    <div>
                        <h3 id="detName" class="text-lg font-black text-slate-900 uppercase tracking-tight leading-none"></h3>
                        <p id="detCategory" class="text-[10px] font-bold text-blue-600 uppercase tracking-widest mt-1"></p>
                    </div>
                </div>
                <button onclick="Modal.close('entityModal')" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-slate-200 text-slate-400 transition-colors text-xl">&times;</button>
            </div>
            
            <div class="p-8">
                <div id="modalContent" class="space-y-8">
                    <div class="space-y-6">
                        <div class="grid grid-cols-2 gap-x-8 gap-y-6">
                            <div>
                                <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-1">Email Address</label>
                                <p id="detEmail" class="text-sm font-bold text-slate-800 break-all"></p>
                            </div>
                            <div>
                                <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-1">Location</label>
                                <p id="detAddress" class="text-sm font-bold text-slate-800"></p>
                            </div>
                            <div>
                                <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-1">Status Verification</label>
                                <div id="detStatusBadge"></div>
                            </div>
                            <div id="dynamicStatusWrapper">
                                <label id="dynamicStatusLabel" class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-1"></label>
                                <div id="dynamicStatusContent" class="cursor-pointer group">
                                </div>
                            </div>
                        </div>

                        <div id="detRejectReasonWrapper" class="hidden bg-rose-50 border border-rose-100 rounded-2xl p-4 animate-in fade-in slide-in-from-top-2 duration-300">
                            <div class="flex gap-3">
                                <div class="w-8 h-8 rounded-lg bg-rose-500 flex items-center justify-center shrink-0">
                                    <span class="text-white text-xs font-black">!</span>
                                </div>
                                <div>
                                    <label class="text-[9px] font-black text-rose-500 uppercase tracking-widest block mb-0.5">Rejection Reason</label>
                                    <p id="detRejectReasonText" class="text-xs font-bold text-rose-700 leading-relaxed"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-3">Legal Document Preview</label>
                        <div id="docPreviewContainer" class="relative group cursor-zoom-in overflow-hidden rounded-2xl border-2 border-dashed border-slate-200 hover:border-blue-400 transition-all aspect-video flex items-center justify-center bg-slate-50">
                            <img id="detDocImg" src="" class="hidden w-full h-full object-cover">
                            <div id="docPlaceholder" class="text-center p-6">
                                <p class="text-[10px] font-black text-slate-400 uppercase italic">No Document Preview Available</p>
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

                    <div id="rejectSection" class="hidden pt-4 border-t-2 border-rose-50 animate-pulse">
                        <label class="text-[9px] font-black text-rose-500 uppercase tracking-widest block mb-2">Rejection Reason</label>
                        <textarea id="rejectionReason" class="w-full p-4 bg-rose-50/30 border border-rose-100 rounded-xl text-sm focus:ring-2 focus:ring-rose-500 outline-none transition-all" placeholder="Explain why this entity is being rejected..."></textarea>
                    </div>

                    <div id="modalActions" class="pt-6 flex gap-3">
                        <button id="btnApprove" class="flex-1 bg-emerald-500 text-white text-xs font-black py-4 rounded-xl uppercase hover:bg-emerald-600 transition-all shadow-lg shadow-emerald-200">Approve Entity</button>
                        <button id="btnRejectMode" class="flex-1 bg-rose-500 text-white text-xs font-black py-4 rounded-xl uppercase hover:bg-rose-600 transition-all shadow-lg shadow-rose-200">Reject Entity</button>
                        <button id="btnSubmitReject" class="hidden flex-1 bg-rose-600 text-white text-xs font-black py-4 rounded-xl uppercase hover:bg-rose-700 transition-all shadow-lg shadow-rose-200">Confirm Rejection</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="imageOverlay" class="fixed inset-0 z-[60] hidden bg-slate-900/95 backdrop-blur-md flex items-center justify-center p-4 overflow-hidden">
    <button onclick="closeOverlay()" class="absolute top-6 right-6 text-white text-4xl hover:scale-110 transition-transform focus:outline-none">&times;</button>
    <div class="relative w-full h-full flex items-center justify-center overflow-auto p-10">
        <img id="zoomedImg" src="" class="max-w-none transition-transform duration-200 ease-out cursor-move" style="transform: scale(1);">
    </div>
    <div class="absolute bottom-10 left-1/2 -translate-x-1/2 flex gap-4 bg-white/10 backdrop-blur rounded-full px-6 py-3 border border-white/20">
        <button onclick="zoomImg(-0.2)" class="text-white font-black text-lg">-</button>
        <span id="zoomLevel" class="text-white text-[10px] font-black flex items-center">100%</span>
        <button onclick="zoomImg(0.2)" class="text-white font-black text-lg">+</button>
    </div>
</div>

<script>
    let currentZoom = 1;
    let currentEntityId = null;

    // Setup CSRF token
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    // Helper functions
    function formatDate(dateString, options = {}) {
        const defaults = { day: 'numeric', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit' };
        return new Date(dateString).toLocaleString('id-ID', { ...defaults, ...options });
    }

    function statusBadge(status) {
        const colors = {
            'pending': 'bg-amber-100 text-amber-600',
            'approved': 'bg-emerald-100 text-emerald-600',
            'rejected': 'bg-rose-100 text-rose-600',
            'completed': 'bg-blue-100 text-blue-600'
        };
        const className = colors[status] || 'bg-slate-100 text-slate-600';
        return `<span class="px-3 py-1 rounded-full text-[10px] font-black uppercase ${className}">${status}</span>`;
    }

    // Modal functions
    function openEntityModal(id) {
        currentEntityId = id;

        $.get(`/admin/entities/list/${id}/detail`, function(data) {
            $('#detName').text(data.name);
            $('#detCategory').text(data.entity_category?.name || 'Uncategorized');

            const logoWrapper = $('#detLogoWrapper');
            logoWrapper.removeClass('bg-blue-600');
            if(data.logo_path) {
                logoWrapper.html(`<img src="/storage/${data.logo_path}" class="w-full h-full object-cover">`);
            } else {
                logoWrapper.html(`<span class="text-white font-black">${data.name.charAt(0).toUpperCase()}</span>`).addClass('bg-blue-600');
            }

            $('#detEmail').text(data.email);
            $('#detAddress').text(data.address);
            $('#detStatusBadge').html(statusBadge(data.status));

            if(data.status === 'rejected') {
                $('#detRejectReasonWrapper').removeClass('hidden');
                $('#detRejectReasonText').text(data.rejection_reason || 'No reason provided');
            } else {
                $('#detRejectReasonWrapper').addClass('hidden');
            }

            const dynamicLabel = $('#dynamicStatusLabel');
            const dynamicContent = $('#dynamicStatusContent');
            dynamicContent.removeClass('clickable-status');

            if(data.status === 'approved' || data.status === 'rejected') {
                dynamicLabel.text('Visibility Status');
                dynamicContent.addClass('clickable-status');
                const activeLabel = data.is_active ? 'VISIBLE' : 'INVISBLE';
                const activeColor = data.is_active ? 'text-emerald-600' : 'text-rose-500';
                const hoverText = data.is_active ? 'Click to Invisible' : 'Click to Visible';

                dynamicContent.html(`
                    <div class="flex flex-col">
                        <span class="text-sm font-black ${activeColor} transition-colors">${activeLabel}</span>
                        <span class="text-[8px] font-bold text-slate-400 uppercase tracking-tighter opacity-0 group-hover:opacity-100 transition-opacity">${hoverText}</span>
                    </div>
                `);
            } else {
                dynamicLabel.text('Verification');
                dynamicContent.html(`<p class="text-sm font-bold text-slate-400 italic font-medium tracking-tight">Awaiting Review</p>`);
            }

            const user = data.user || {};
            $('#detUserName').text(user.name || 'System');
            $('#detUserEmail').text(user.email || '-');
            $('#detUserAvatar').text(user.name ? user.name.charAt(0).toUpperCase() : '?');
            $('#detCreatedAt').text(formatDate(data.created_at));
            $('#detUpdatedAt').text(formatDate(data.updated_at));

            if(data.legal_document_path) {
                $('#detDocImg').attr('src', '/storage/' + data.legal_document_path).removeClass('hidden');
                $('#docPlaceholder').addClass('hidden');
            } else {
                $('#detDocImg').addClass('hidden');
                $('#docPlaceholder').removeClass('hidden');
            }

            if(data.status === 'pending') {
                $('#modalActions').removeClass('hidden');
            } else {
                $('#modalActions').addClass('hidden');
            }

            // Show modal with animation
            $('#entityModal').removeClass('hidden');
            $('body').css('overflow', 'hidden');

            requestAnimationFrame(() => {
                requestAnimationFrame(() => {
                    $('#entityModal').removeClass('opacity-0');
                    $('#entityModal .transform').removeClass('opacity-0 scale-95').addClass('scale-100 opacity-100');
                });
            });
        }).fail(() => alert('Gagal memuat data'));
    }

    function closeEntityModal() {
        $('#entityModal').addClass('opacity-0');
        $('#entityModal .transform').removeClass('scale-100 opacity-100').addClass('opacity-0 scale-95');

        setTimeout(() => {
            $('#entityModal').addClass('hidden');
            $('body').css('overflow', '');
            $('#rejectSection').addClass('hidden');
            $('#btnSubmitReject').addClass('hidden');
            $('#btnApprove, #btnRejectMode').removeClass('hidden');
        }, 300);
    }

    $(document).ready(function() {
        // Detail button click handler
        $(document).on('click', '.btn-detail', function() {
            const id = $(this).data('id');
            openEntityModal(id);
        });

        // Close button and backdrop handlers
        $(document).on('click', '[data-modal-backdrop]', function() {
            closeEntityModal();
        });

        // ESC key handler
        $(document).on('keydown', function(e) {
            if (e.key === 'Escape' && !$('#entityModal').hasClass('hidden')) {
                closeEntityModal();
            }
        });

        // Toggle active status
        $(document).on('click', '#dynamicStatusContent.clickable-status', function() {
            const container = $(this);
            container.addClass('opacity-50 pointer-events-none');

            $.post(`/admin/entities/list/${currentEntityId}/toggle-active`, function(data) {
                if(data.success) {
                    const isNowActive = data.new_status === 'VISIBLE';
                    const newColor = isNowActive ? 'text-emerald-600' : 'text-rose-500';
                    const hoverText = isNowActive ? 'Click to Invisible' : 'Click to Visible';

                    container.html(`
                        <div class="flex flex-col">
                            <span class="text-sm font-black ${newColor} transition-colors">${data.new_status}</span>
                            <span class="text-[8px] font-bold text-slate-400 uppercase tracking-tighter opacity-0 group-hover:opacity-100 transition-opacity">${hoverText}</span>
                        </div>
                    `);

                    $(`.status-row-${currentEntityId}`).text(data.new_status);
                }
                container.removeClass('opacity-50 pointer-events-none');
            }).fail(function() {
                alert('Failed to update status.');
                container.removeClass('opacity-50 pointer-events-none');
            });
        });

        // Image preview
        $('#docPreviewContainer').click(function() {
            let src = $('#detDocImg').attr('src');
            if(src && !$('#detDocImg').hasClass('hidden')) {
                $('#zoomedImg').attr('src', src);
                $('#imageOverlay').removeClass('hidden');
                currentZoom = 1;
                updateZoom();
            }
        });
    });

    // Approve/Reject handlers
    $('#btnRejectMode').click(function() {
        $('#rejectSection').removeClass('hidden');
        $('#btnSubmitReject').removeClass('hidden');
        $(this).addClass('hidden');
        $('#btnApprove').addClass('hidden');
    });

    $('#btnApprove').click(function() { updateMainStatus('approved'); });
    $('#btnSubmitReject').click(function() { updateMainStatus('rejected', $('#rejectionReason').val()); });

    function updateMainStatus(status, reason = '') {
        $.post(`/admin/entities/list/${currentEntityId}/update-status`, {
            status: status,
            reason: reason
        })
        .done(function(response) {
            if(response.success) {
                location.reload();
            }
        })
        .fail(function(err) {
            alert("Error updating status. Check console.");
            console.error(err);
        });
    }

    // Zoom functions
    function zoomImg(delta) { currentZoom = Math.max(0.5, Math.min(3, currentZoom + delta)); updateZoom(); }
    function updateZoom() { $('#zoomedImg').css('transform', `scale(${currentZoom})`); $('#zoomLevel').text(Math.round(currentZoom * 100) + '%'); }
    function closeOverlay() { $('#imageOverlay').addClass('hidden'); }
</script>
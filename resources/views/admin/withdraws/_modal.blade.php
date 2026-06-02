<div id="withdrawModal" class="fixed inset-0 z-50 hidden overflow-y-auto opacity-0 transition-opacity duration-300">
    <div class="flex min-h-full items-center justify-center p-4">
        <div data-modal-backdrop class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"></div>

        <div class="bg-white rounded-3xl shadow-2xl z-50 w-full max-w-2xl relative my-8 overflow-hidden transform scale-95 opacity-0 transition-all duration-300 ease-in-out">
            <div class="px-8 py-6 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
                <div>
                    <h3 class="text-lg font-black text-slate-900 uppercase tracking-tight">Withdrawal Detail</h3>
                    <p class="text-[10px] font-bold text-blue-600 uppercase tracking-widest mt-1">Review withdrawal request</p>
                </div>
                <button onclick="Modal.close('withdrawModal')" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-slate-200 text-slate-400 transition-colors text-xl">&times;</button>
            </div>

            <div class="px-8 py-8 space-y-6">
                <div>
                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-1.5">Fundraiser</label>
                    <p id="detFundraiser" class="text-xs font-bold text-slate-900 uppercase"></p>
                </div>

                <div>
                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-1.5">Campaign</label>
                    <p id="detCampaign" class="text-xs font-bold text-blue-600 uppercase"></p>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-1.5">Amount</label>
                        <p id="detAmount" class="text-sm font-black text-emerald-600"></p>
                    </div>
                    <div>
                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-1.5">Status</label>
                        <div id="detStatus"></div>
                    </div>
                </div>

                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100 space-y-4">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-3">Bank Account Details</p>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-[8px] font-black text-slate-400 uppercase">Bank Name</label>
                            <p id="detBank" class="text-xs font-bold text-slate-700"></p>
                        </div>
                        <div>
                            <label class="text-[8px] font-black text-slate-400 uppercase">Account Number</label>
                            <p id="detAccount" class="text-xs font-bold text-slate-700 font-mono"></p>
                        </div>
                    </div>
                    <div class="pt-3 border-t border-slate-200/60">
                        <label class="text-[8px] font-black text-slate-400 uppercase">Account Holder</label>
                        <p id="detHolder" class="text-xs font-bold text-slate-700 uppercase"></p>
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

                <div id="approverDiv" class="hidden">
                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-1.5">Approved By</label>
                    <p id="detApprover" class="text-xs font-bold text-slate-900 uppercase"></p>
                </div>

                <div class="pt-6 border-t border-slate-100 flex items-center justify-between">
                    <div class="text-right space-y-1">
                        <div class="flex flex-col">
                            <span class="text-[8px] font-black text-slate-300 uppercase italic">Requested:</span>
                            <span id="detCreated" class="text-[10px] font-bold text-slate-500 font-mono"></span>
                        </div>
                    </div>
                </div>
            </div>

            <div id="modalActions" class="px-8 py-6 bg-slate-50 border-t border-slate-100 hidden">
                <div id="rejectSection" class="hidden pt-4 border-t-2 border-rose-50 animate-pulse mb-4">
                    <label class="text-[9px] font-black text-rose-500 uppercase tracking-widest block mb-2">Rejection Reason</label>
                    <textarea id="rejectionReason" class="w-full p-4 bg-rose-50/30 border border-rose-100 rounded-xl text-sm focus:ring-2 focus:ring-rose-500 outline-none transition-all" placeholder="Explain why this withdrawal is being rejected..." rows="2"></textarea>
                </div>
                <div class="flex gap-3">
                    <button id="btnApprove" class="flex-1 bg-emerald-500 text-white text-xs font-black py-4 rounded-xl uppercase hover:bg-emerald-600 transition-all shadow-lg shadow-emerald-200">Approve Withdrawal</button>
                    <button id="btnRejectMode" class="flex-1 bg-rose-500 text-white text-xs font-black py-4 rounded-xl uppercase hover:bg-rose-600 transition-all shadow-lg shadow-rose-200">Reject Withdrawal</button>
                    <button id="btnSubmitReject" class="hidden flex-1 bg-rose-600 text-white text-xs font-black py-4 rounded-xl uppercase hover:bg-rose-700 transition-all shadow-lg shadow-rose-200">Confirm Rejection</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    let currentWithdrawId = null;

    function formatRupiah(amount) {
        return 'IDR ' + new Intl.NumberFormat('id-ID').format(amount);
    }

    function formatDate(dateString, options = {}) {
        const defaults = { day: 'numeric', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit' };
        return new Date(dateString).toLocaleString('id-ID', { ...defaults, ...options });
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

    function showWithdrawModal() {
        $('#withdrawModal').removeClass('hidden');
        $('body').css('overflow', 'hidden');

        requestAnimationFrame(() => {
            requestAnimationFrame(() => {
                $('#withdrawModal').removeClass('opacity-0');
                $('#withdrawModal .transform').removeClass('opacity-0 scale-95').addClass('scale-100 opacity-100');
            });
        });
    }

    function closeWithdrawModal() {
        $('#withdrawModal').addClass('opacity-0');
        $('#withdrawModal .transform').removeClass('scale-100 opacity-100').addClass('opacity-0 scale-95');

        setTimeout(() => {
            $('#withdrawModal').addClass('hidden');
            $('body').css('overflow', '');
            $('#rejectSection').addClass('hidden');
            $('#btnSubmitReject').addClass('hidden');
            $('#btnApprove, #btnRejectMode').removeClass('hidden');
            $('#rejectionReason').val('');
        }, 300);
    }

    $(document).ready(function() {
        $(document).on('click', '.btn-detail', function() {
            const withdraw = $(this).data('withdraw');
            currentWithdrawId = withdraw.id;

            $('#detFundraiser').text(withdraw.campaign.user.name);
            $('#detCampaign').text(withdraw.campaign.title);
            $('#detAmount').text(formatRupiah(withdraw.amount));
            $('#detStatus').html(statusBadge(withdraw.status));
            $('#detBank').text(withdraw.bank_name);
            $('#detAccount').text(withdraw.account_number);
            $('#detHolder').text(withdraw.account_holder);
            $('#detCreated').text(formatDate(withdraw.created_at));

            const rejectWrapper = $('#rejectionReasonWrapper');
            if (withdraw.status === 'rejected' && withdraw.rejection_reason) {
                rejectWrapper.removeClass('hidden');
                $('#detRejectionReason').text(withdraw.rejection_reason);
            } else {
                rejectWrapper.addClass('hidden');
                $('#detRejectionReason').text('');
            }

            if (withdraw.status === 'pending') {
                $('#modalActions').removeClass('hidden');
                $('#approverDiv').addClass('hidden');
            } else {
                $('#modalActions').addClass('hidden');
                if (withdraw.approver) {
                    $('#approverDiv').removeClass('hidden');
                    $('#detApprover').text(withdraw.approver.name);
                } else {
                    $('#approverDiv').addClass('hidden');
                }
            }

            showWithdrawModal();
        });

        $('#btnRejectMode').click(function() {
            $('#rejectSection, #btnSubmitReject').removeClass('hidden');
            $(this).addClass('hidden');
            $('#btnApprove').addClass('hidden');
        });

        $('#btnApprove').click(function() {
            if (confirm('Are you sure you want to approve this withdrawal?')) {
                $.ajax({
                    url: '{{ route("admin.withdraws.approve", ":id") }}'.replace(':id', currentWithdrawId),
                    type: 'POST',
                    success: function(response) {
                        location.reload();
                    },
                    error: function() {
                        alert('Failed to approve withdrawal.');
                    }
                });
            }
        });

        $('#btnSubmitReject').click(function() {
            let reason = $('#rejectionReason').val().trim();
            if (!reason) {
                alert('Please provide a rejection reason');
                return;
            }

            $.ajax({
                url: '{{ route("admin.withdraws.reject", ":id") }}'.replace(':id', currentWithdrawId),
                type: 'POST',
                data: { rejection_reason: reason },
                success: function(response) {
                    location.reload();
                },
                error: function() {
                    alert('Failed to reject withdrawal.');
                }
            });
        });

        $(document).on('click', '[data-modal-backdrop]', function() {
            closeWithdrawModal();
        });

        $(document).on('keydown', function(e) {
            if (e.key === 'Escape' && !$('#withdrawModal').hasClass('hidden')) {
                closeWithdrawModal();
            }
        });
    });
</script>
@endpush

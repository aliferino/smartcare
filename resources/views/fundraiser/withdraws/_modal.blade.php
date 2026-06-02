<div id="withdrawModal" class="fixed inset-0 z-50 hidden overflow-y-auto opacity-0 transition-opacity duration-300">
    <div class="flex min-h-full items-center justify-center p-4">
        <div data-modal-backdrop class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"></div>

        <div class="bg-white rounded-3xl shadow-2xl z-50 w-full max-w-2xl relative my-8 overflow-hidden transform scale-95 opacity-0 transition-all duration-300 ease-in-out">
            <div class="px-8 py-6 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
                <div>
                    <h3 id="modalTitle" class="text-lg font-black text-slate-900 uppercase tracking-tight">New Withdrawal Request</h3>
                    <p id="modalSubtitle" class="text-[10px] font-bold text-blue-600 uppercase tracking-widest mt-1">Submit your withdrawal request</p>
                </div>
                <button onclick="Modal.close('withdrawModal')" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-slate-200 text-slate-400 transition-colors text-xl">&times;</button>
            </div>

            <div class="px-8 py-8 space-y-6">
                <!-- CREATE FORM MODE -->
                <div id="createMode" class="grid grid-cols-1 gap-6">
                    <div>
                        <label class="text-[10px] font-black text-slate-600 uppercase tracking-widest block mb-2">Select Campaign *</label>
                        <select name="campaign_id" id="campaignId" class="w-full px-4 py-3 bg-white border border-slate-100 rounded-lg text-xs font-bold uppercase focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all">
                            <option value="">-- Choose Campaign --</option>
                        </select>
                        <span class="text-rose-600 text-[10px] font-bold uppercase hidden" id="campaignError"></span>

                        <!-- Available Amount Info -->
                        <div id="availableAmountInfo" class="hidden mt-3 p-3 bg-emerald-50 border border-emerald-200 rounded-xl">
                            <div class="flex items-center justify-between">
                                <span class="text-[9px] font-black text-emerald-600 uppercase tracking-widest">Available to Withdraw</span>
                                <span id="availableAmount" class="text-xs font-black text-emerald-700"></span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="text-[10px] font-black text-slate-600 uppercase tracking-widest block mb-2">Withdrawal Amount (IDR) *</label>
                        <input type="number" name="amount" id="amount" placeholder="Minimum 100,000" min="100000" step="1000" class="w-full px-4 py-3 bg-white border-2 border-blue-200 rounded-2xl text-xs font-bold uppercase focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all placeholder:text-slate-400">
                        <span class="text-rose-600 text-[10px] font-bold uppercase hidden" id="amountError"></span>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-[10px] font-black text-slate-600 uppercase tracking-widest block mb-2">Bank Name *</label>
                            <input type="text" name="bank_name" id="bankName" placeholder="e.g., BCA, Mandiri" class="w-full px-4 py-3 bg-white border border-slate-100 rounded-lg text-xs font-bold uppercase focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all placeholder:text-slate-400">
                            <span class="text-rose-600 text-[10px] font-bold uppercase hidden" id="bankNameError"></span>
                        </div>

                        <div>
                            <label class="text-[10px] font-black text-slate-600 uppercase tracking-widest block mb-2">Account Number *</label>
                            <input type="text" name="account_number" id="accountNumber" placeholder="Your account number" class="w-full px-4 py-3 bg-white border border-slate-100 rounded-lg text-xs font-bold uppercase focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all placeholder:text-slate-400">
                            <span class="text-rose-600 text-[10px] font-bold uppercase hidden" id="accountNumberError"></span>
                        </div>
                    </div>

                    <div>
                        <label class="text-[10px] font-black text-slate-600 uppercase tracking-widest block mb-2">Account Holder Name *</label>
                        <input type="text" name="account_holder" id="accountHolder" placeholder="Name on bank account" class="w-full px-4 py-3 bg-white border border-slate-100 rounded-lg text-xs font-bold uppercase focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all placeholder:text-slate-400">
                        <span class="text-rose-600 text-[10px] font-bold uppercase hidden" id="accountHolderError"></span>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex gap-3">
                        <button type="button" onclick="Modal.close('withdrawModal')" class="flex-1 px-6 py-3 bg-slate-100 text-slate-600 text-xs font-black uppercase rounded-2xl hover:bg-slate-200 transition-colors">
                            Cancel
                        </button>
                        <button type="button" id="submitBtn" class="flex-1 px-6 py-3 bg-blue-600 text-white text-xs font-black uppercase rounded-2xl hover:bg-blue-700 transition-colors flex items-center justify-center gap-2">
                            <i data-lucide="send" class="w-4 h-4"></i> Submit Request
                        </button>
                    </div>
                </div>

                <!-- DETAIL MODE -->
                <div id="detailMode" class="hidden space-y-6">
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

                    <div id="rejectionReasonDiv" class="hidden bg-rose-50 border border-rose-100 rounded-2xl p-4 animate-in fade-in slide-in-from-top-2 duration-300">
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
                        <div class="text-right space-y-1">
                            <div class="flex flex-col">
                                <span class="text-[8px] font-black text-slate-300 uppercase italic">Requested:</span>
                                <span id="detCreated" class="text-[10px] font-bold text-slate-500 font-mono"></span>
                            </div>
                        </div>
                    </div>
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

    let campaignsData = {}; // Store campaign data with available amounts

    window.Modal = window.Modal || {};
    const originalOpen = window.Modal.open;
    window.Modal.open = function(modalId, options = {}) {
        if (modalId === 'withdrawModal') {
            if (options.mode === 'create') {
                resetForm();
                loadCampaigns();
            } else if (options.mode === 'detail' && options.withdraw) {
                showWithdrawDetail(options.withdraw);
            }
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
                if (modalId === 'withdrawModal') {
                    resetForm();
                }
            }, 300);
        }
    };

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

    function resetForm() {
        $('#campaignId').val('');
        $('#amount').val('');
        $('#bankName').val('');
        $('#accountNumber').val('');
        $('#accountHolder').val('');
        $('[id$="Error"]').addClass('hidden').text('');
        $('#createMode').removeClass('hidden');
        $('#detailMode').addClass('hidden');
        $('#modalTitle').text('New Withdrawal Request');
        $('#modalSubtitle').text('Submit your withdrawal request');
        $('#availableAmountInfo').addClass('hidden');
    }

    function loadCampaigns() {
        $.ajax({
            url: '{{ route("fundraiser.withdraws.api.campaigns") }}',
            type: 'GET',
            success: function(response) {
                let select = $('#campaignId');
                select.find('option:not(:first)').remove();
                campaignsData = {}; // Reset

                if (response.campaigns && response.campaigns.length > 0) {
                    response.campaigns.forEach(function(campaign) {
                        select.append(`<option value="${campaign.id}" data-available="${campaign.available_amount}">${campaign.title}</option>`);
                        campaignsData[campaign.id] = campaign; // Store campaign data
                    });
                }
            }
        });
    }

    function showWithdrawDetail(withdraw) {
        $('#detCampaign').text(withdraw.campaign.title);
        $('#detAmount').text(formatRupiah(withdraw.amount));
        $('#detStatus').html(statusBadge(withdraw.status));
        $('#detBank').text(withdraw.bank_name);
        $('#detAccount').text(withdraw.account_number);
        $('#detHolder').text(withdraw.account_holder);
        $('#detCreated').text(formatDate(withdraw.created_at));

        if (withdraw.status === 'rejected' && withdraw.rejection_reason) {
            $('#rejectionReasonDiv').removeClass('hidden');
            $('#detRejectionReason').text(withdraw.rejection_reason);
        } else {
            $('#rejectionReasonDiv').addClass('hidden');
        }

        $('#createMode').addClass('hidden');
        $('#detailMode').removeClass('hidden');
        $('#modalTitle').text('Withdrawal Detail');
        $('#modalSubtitle').text('View withdrawal request details');
    }

    $(document).ready(function() {

        // Handle campaign selection change
        $(document).on('change', '#campaignId', function() {
            const campaignId = $(this).val();

            if (campaignId && campaignsData[campaignId]) {
                const campaign = campaignsData[campaignId];
                const availableAmount = campaign.available_amount;

                // Show available amount info
                $('#availableAmount').text(formatRupiah(availableAmount));
                $('#availableAmountInfo').removeClass('hidden');

                // Update amount input max attribute
                $('#amount').attr('max', availableAmount);
                $('#amount').attr('placeholder', `Max: ${formatRupiah(availableAmount)}`);
            } else {
                // Hide available amount info
                $('#availableAmountInfo').addClass('hidden');
                $('#amount').removeAttr('max');
                $('#amount').attr('placeholder', 'Minimum 100,000');
            }
        });

        $(document).on('click', '.btn-detail', function() {
            const withdraw = $(this).data('withdraw');
            Modal.open('withdrawModal', { mode: 'detail', withdraw: withdraw });
        });

        $(document).on('click', '#submitBtn', function() {
            $('[id$="Error"]').addClass('hidden').text('');

            let formData = {
                campaign_id: $('#campaignId').val(),
                amount: $('#amount').val(),
                bank_name: $('#bankName').val(),
                account_number: $('#accountNumber').val(),
                account_holder: $('#accountHolder').val(),
            };

            $.ajax({
                url: '{{ route("fundraiser.withdraws.store") }}',
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        alert(response.message);
                        closeWithdrawModal();
                        location.reload();
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function(field, messages) {
                            let errorElement = $('#' + field + 'Error');
                            if (errorElement.length) {
                                errorElement.text(messages[0]).removeClass('hidden');
                            }
                        });
                    } else {
                        alert('An error occurred. Please try again.');
                    }
                }
            });
        });

        $(document).on('click', '[data-modal-backdrop]', function() {
            Modal.close('withdrawModal');
        });

        $(document).on('keydown', function(e) {
            if (e.key === 'Escape' && !$('#withdrawModal').hasClass('hidden')) {
                Modal.close('withdrawModal');
            }
        });
    });
</script>
@endpush

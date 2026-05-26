<div id="donationModal" class="fixed inset-0 z-50 hidden overflow-y-auto opacity-0 transition-opacity duration-300">
    <div class="flex min-h-full items-center justify-center p-4">
        <div data-modal-backdrop class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"></div>

        <div class="bg-white rounded-3xl shadow-2xl z-50 w-full max-w-lg relative my-8 overflow-hidden transform scale-95 opacity-0 transition-all duration-300 ease-in-out">
            <div class="px-8 py-6 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
                <h3 class="text-lg font-black text-slate-900 uppercase tracking-tight leading-none">Donation Detail</h3>
                <button onclick="Modal.close('donationModal')" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-slate-200 text-slate-400 transition-colors text-xl">&times;</button>
            </div>

            <div class="p-8 space-y-6">
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-1">Target Campaign</label>
                        <p id="detCampaign" class="text-xs font-bold text-blue-600 uppercase italic"></p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-1">Donor Name</label>
                            <p id="detName" class="text-xs font-bold text-slate-700 uppercase"></p>
                        </div>
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-1">Amount</label>
                            <p id="detAmount" class="text-sm font-black text-emerald-600"></p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-1">Email</label>
                            <p id="detEmail" class="text-xs font-bold text-slate-600"></p>
                        </div>
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-1">Phone Number</label>
                            <p id="detPhone" class="text-xs font-bold text-slate-600"></p>
                        </div>
                    </div>

                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-1">Message</label>
                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                            <p id="detMessage" class="text-xs font-medium text-slate-500 leading-relaxed italic"></p>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-50 flex justify-between items-center">
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-1">Last Update</label>
                            <p id="detUpdate" class="text-[10px] font-bold text-slate-400"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Setup CSRF token
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    // Helper functions
    function formatRupiah(amount) {
        return 'IDR ' + new Intl.NumberFormat('id-ID').format(amount);
    }

    function formatDate(dateString, options = {}) {
        const defaults = { day: 'numeric', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit' };
        return new Date(dateString).toLocaleString('id-ID', { ...defaults, ...options });
    }

    // Modal functions
    function showDonationModal() {
        $('#donationModal').removeClass('hidden');
        $('body').css('overflow', 'hidden');

        requestAnimationFrame(() => {
            requestAnimationFrame(() => {
                $('#donationModal').removeClass('opacity-0');
                $('#donationModal .transform').removeClass('opacity-0 scale-95').addClass('scale-100 opacity-100');
            });
        });
    }

    function closeDonationModal() {
        $('#donationModal').addClass('opacity-0');
        $('#donationModal .transform').removeClass('scale-100 opacity-100').addClass('opacity-0 scale-95');

        setTimeout(() => {
            $('#donationModal').addClass('hidden');
            $('body').css('overflow', '');
        }, 300);
    }

    $(document).ready(function() {
        // Detail button click handler
        $(document).on('click', '.btn-detail', function() {
            const donation = $(this).data('donation');

            $('#detCampaign').text(donation.campaign.title);
            $('#detName').text(donation.is_anonymous ? 'Anonymous (' + donation.name + ')' : donation.name);
            $('#detAmount').text(formatRupiah(donation.amount));
            $('#detEmail').text(donation.email || '-');
            $('#detPhone').text(donation.phone_number || '-');
            $('#detMessage').text(donation.message || 'No message provided.');
            $('#detUpdate').text(formatDate(donation.updated_at, { day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' }));

            showDonationModal();
        });

        // Close button and backdrop handlers
        $(document).on('click', '[data-modal-backdrop]', function() {
            closeDonationModal();
        });

        // ESC key handler
        $(document).on('keydown', function(e) {
            if (e.key === 'Escape' && !$('#donationModal').hasClass('hidden')) {
                closeDonationModal();
            }
        });
    });
</script>
@endpush

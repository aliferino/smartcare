<div id="donationModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen w-full px-4 py-10">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeModal()"></div>
        
        <div class="bg-white rounded-3xl shadow-2xl z-50 w-full max-w-lg overflow-hidden border border-slate-100 transition-all">
            <div class="px-8 py-6 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
                <h3 class="text-lg font-black text-slate-900 uppercase tracking-tight leading-none">Donation Detail</h3>
                <button onclick="closeModal()" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-slate-200 text-slate-400 transition-colors">&times;</button>
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

<script>
    $(document).on('click', '.btn-detail', function() {
        const data = $(this).data('donation');
        
        $('#detCampaign').text(data.campaign.title);
        $('#detName').text(data.is_anonymous ? 'Anonymous (' + data.name + ')' : data.name);
        $('#detAmount').text('Rp ' + new Intl.NumberFormat('id-ID').format(data.amount));
        $('#detEmail').text(data.email || '-');
        $('#detPhone').text(data.phone_number || '-');
        $('#detMessage').text(data.message || 'No message provided.');
        
        const date = new Date(data.updated_at);
        $('#detUpdate').text(date.toLocaleString('id-ID', { day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' }));

        $('#donationModal').removeClass('hidden').addClass('flex');
    });

    function closeModal() {
        $('#donationModal').addClass('hidden').removeClass('flex');
    }
</script>
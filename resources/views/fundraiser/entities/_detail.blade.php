<div id="entityDetailModal" class="fixed inset-0 z-50 hidden overflow-y-auto opacity-0 transition-opacity duration-300">
    <div class="flex min-h-full items-center justify-center p-4">
        <div data-modal-backdrop class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"></div>

        <div class="bg-white rounded-3xl shadow-2xl z-50 w-full max-w-2xl relative my-8 overflow-hidden transform scale-95 opacity-0 transition-all duration-300 ease-in-out">

            <div class="px-8 py-6 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
                <div>
                    <h3 class="text-lg font-black text-slate-900 uppercase tracking-tight">Entity Details</h3>
                    <p class="text-[10px] font-bold text-blue-600 uppercase tracking-widest mt-1">View entity information</p>
                </div>
                <button onclick="Modal.close('entityDetailModal')" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-slate-200 text-slate-400 transition-colors text-xl">&times;</button>
            </div>

            <div id="entityDetailContent" class="p-8 space-y-6">
                {{-- Content will be loaded dynamically --}}
            </div>

        </div>
    </div>
</div>

@push('scripts')
<script>
    function viewEntityDetail(id) {
        $.get(`/fundraiser/entities/${id}/detail`, function(data) {
            populateEntityDetail(data);
            Modal.open('entityDetailModal');
        }).fail(function() {
            alert('Failed to load entity details');
        });
    }

    function populateEntityDetail(entity) {
        let statusBadge = '';
        if (entity.status === 'approved') {
            statusBadge = '<span class="px-3 py-1.5 rounded-lg bg-emerald-50 text-emerald-600 text-xs font-black uppercase">Approved</span>';
        } else if (entity.status === 'pending') {
            statusBadge = '<span class="px-3 py-1.5 rounded-lg bg-amber-50 text-amber-600 text-xs font-black uppercase">Pending</span>';
        } else {
            statusBadge = '<span class="px-3 py-1.5 rounded-lg bg-rose-50 text-rose-600 text-xs font-black uppercase">Rejected</span>';
        }

        let logoHtml = '';
        if (entity.logo_path) {
            logoHtml = `
                <div class="mb-6 flex justify-center">
                    <img src="/storage/${entity.logo_path}"
                         class="w-32 h-32 object-cover rounded-2xl shadow-lg"
                         alt="Entity Logo">
                </div>
            `;
        }

        let rejectionHtml = '';
        if (entity.status === 'rejected' && entity.rejection_reason) {
            rejectionHtml = `
                <div class="p-4 bg-rose-50 border border-rose-100 rounded-xl">
                    <p class="text-xs font-bold text-rose-900 uppercase tracking-wider mb-2">Rejection Reason</p>
                    <p class="text-sm text-rose-700">${entity.rejection_reason}</p>
                </div>
            `;
        }

        let legalDocHtml = '';
        if (entity.legal_document_path) {
            legalDocHtml = `
                <div class="border-t border-slate-100 pt-6">
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">Legal Document</p>
                    <a href="/storage/${entity.legal_document_path}" target="_blank"
                       class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors">
                        <i data-lucide="file-text" class="w-4 h-4"></i>
                        <span class="text-sm font-medium">View Document</span>
                    </a>
                </div>
            `;
        }

        const html = `
            ${logoHtml}

            <div class="flex items-start justify-between">
                <div>
                    <h4 class="text-xl font-black text-slate-900 uppercase tracking-tight mb-2">${entity.name}</h4>
                    <p class="text-xs font-bold text-blue-600 uppercase tracking-widest">${entity.entity_category.name}</p>
                </div>
                ${statusBadge}
            </div>

            <div class="border-t border-slate-100 pt-6">
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">Contact Information</p>
                <div class="space-y-3">
                    <div class="p-4 bg-slate-50 rounded-xl">
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Email Address</p>
                        <p class="text-sm font-medium text-slate-900">${entity.email}</p>
                    </div>
                    <div class="p-4 bg-slate-50 rounded-xl">
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Address</p>
                        <p class="text-sm text-slate-700 leading-relaxed">${entity.address}</p>
                    </div>
                </div>
            </div>

            ${legalDocHtml}

            ${rejectionHtml}
        `;

        $('#entityDetailContent').html(html);

        // Re-initialize lucide icons for the new content
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    }
</script>
@endpush

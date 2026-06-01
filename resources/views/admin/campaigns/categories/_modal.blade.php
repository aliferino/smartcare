<div id="categoryModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm" data-modal-backdrop>
    <div class="bg-white w-full max-w-md rounded-2xl shadow-xl overflow-hidden">

        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center">
            <h3 id="modalTitle" class="font-bold text-slate-800">Add New Campaign Category</h3>
            <button onclick="Modal.close('categoryModal')" class="text-slate-400 hover:text-slate-600">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form id="categoryForm" class="p-6">
            <input type="hidden" id="categoryId">
            <input type="hidden" id="formMethod" value="create">

            <div class="mb-4">
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Category Name</label>
                <input type="text" id="categoryName" name="name" required
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 focus:outline-none transition-all text-sm"
                       placeholder="e.g. Bencana Alam, Kesehatan, Pendidikan">
            </div>

            <div class="flex gap-3 mt-6">
                <button type="button" onclick="Modal.close('categoryModal')"
                        class="flex-1 px-4 py-2.5 border border-slate-200 text-slate-600 rounded-xl text-sm font-semibold hover:bg-slate-50 transition-all text-center">
                    Cancel
                </button>
                <button type="submit"
                        class="flex-1 px-4 py-2.5 bg-blue-600 text-white rounded-xl text-sm font-semibold hover:bg-blue-700 shadow-md shadow-blue-200 transition-all">
                    Save Category
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Define Modal API if not already defined
    window.Modal = window.Modal || {};

    if (!window.Modal.open) {
        window.Modal.open = function(modalId) {
            $('#' + modalId).removeClass('hidden');
            $('body').css('overflow', 'hidden');
            lucide.createIcons();
        };
    }

    if (!window.Modal.close) {
        window.Modal.close = function(modalId) {
            $('#' + modalId).addClass('hidden');
            $('body').css('overflow', '');
        };
    }

    // Close modal when clicking backdrop
    $(document).on('click', '[data-modal-backdrop]', function(e) {
        if (e.target === this) {
            Modal.close('categoryModal');
        }
    });
</script>
@endpush

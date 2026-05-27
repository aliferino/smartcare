<!-- Filter Modal -->
<div id="filterModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden items-center justify-center">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl mx-4 max-h-[90vh] overflow-hidden">
        <!-- Modal Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-200">
            <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight">Filter Campaigns</h3>
            <button type="button" onclick="closeFilterModal()" class="text-slate-400 hover:text-slate-600 transition-colors">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="px-6 py-6 overflow-y-auto max-h-[calc(90vh-140px)]">
            <form id="filterForm" method="GET" action="/campaigns">
                <!-- Categories Section -->
                <div class="mb-6">
                    <h4 class="text-sm font-black text-slate-900 uppercase tracking-wider mb-3">Categories</h4>
                    <div class="grid grid-cols-2 gap-3">
                        @foreach($categories ?? [] as $category)
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                                {{ in_array($category->id, request('categories', [])) ? 'checked' : '' }}
                                class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-2 focus:ring-blue-500">
                            <span class="text-sm font-medium text-slate-700 group-hover:text-blue-600 transition-colors">{{ $category->name }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <!-- Campaign Type Section -->
                <div class="mb-6">
                    <h4 class="text-sm font-black text-slate-900 uppercase tracking-wider mb-3">Campaign Type</h4>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input type="checkbox" name="types[]" value="urgent"
                                {{ in_array('urgent', request('types', [])) ? 'checked' : '' }}
                                class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-2 focus:ring-blue-500">
                            <span class="text-sm font-medium text-slate-700 group-hover:text-blue-600 transition-colors">Urgent</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input type="checkbox" name="types[]" value="normal"
                                {{ in_array('normal', request('types', [])) ? 'checked' : '' }}
                                class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-2 focus:ring-blue-500">
                            <span class="text-sm font-medium text-slate-700 group-hover:text-blue-600 transition-colors">Normal</span>
                        </label>
                    </div>
                </div>

                <!-- Sort By Section -->
                <div class="mb-6">
                    <h4 class="text-sm font-black text-slate-900 uppercase tracking-wider mb-3">Sort By</h4>
                    <div class="space-y-2">
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input type="radio" name="sort" value="newest"
                                {{ request('sort', 'urgent') == 'newest' ? 'checked' : '' }}
                                class="w-4 h-4 text-blue-600 border-slate-300 focus:ring-2 focus:ring-blue-500">
                            <span class="text-sm font-medium text-slate-700 group-hover:text-blue-600 transition-colors">Newest First</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input type="radio" name="sort" value="oldest"
                                {{ request('sort') == 'oldest' ? 'checked' : '' }}
                                class="w-4 h-4 text-blue-600 border-slate-300 focus:ring-2 focus:ring-blue-500">
                            <span class="text-sm font-medium text-slate-700 group-hover:text-blue-600 transition-colors">Oldest First</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input type="radio" name="sort" value="ending"
                                {{ request('sort') == 'ending' ? 'checked' : '' }}
                                class="w-4 h-4 text-blue-600 border-slate-300 focus:ring-2 focus:ring-blue-500">
                            <span class="text-sm font-medium text-slate-700 group-hover:text-blue-600 transition-colors">Ending Soon</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input type="radio" name="sort" value="urgent"
                                {{ request('sort', 'urgent') == 'urgent' ? 'checked' : '' }}
                                class="w-4 h-4 text-blue-600 border-slate-300 focus:ring-2 focus:ring-blue-500">
                            <span class="text-sm font-medium text-slate-700 group-hover:text-blue-600 transition-colors">Urgent First</span>
                        </label>
                    </div>
                </div>

                <!-- Preserve search parameter -->
                @if(request('search'))
                <input type="hidden" name="search" value="{{ request('search') }}">
                @endif
            </form>
        </div>

        <!-- Modal Footer -->
        <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-slate-200 bg-slate-50">
            <button type="button" onclick="resetFilters()" class="px-6 py-2.5 text-sm font-bold text-slate-700 hover:text-slate-900 transition-colors">
                Reset
            </button>
            <button type="button" onclick="applyFilters()" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-bold transition-colors">
                Apply Filters
            </button>
        </div>
    </div>
</div>

<script>
function openFilterModal() {
    document.getElementById('filterModal').classList.remove('hidden');
    document.getElementById('filterModal').classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeFilterModal() {
    document.getElementById('filterModal').classList.add('hidden');
    document.getElementById('filterModal').classList.remove('flex');
    document.body.style.overflow = 'auto';
}

function applyFilters() {
    document.getElementById('filterForm').submit();
}

function resetFilters() {
    // Uncheck all checkboxes
    document.querySelectorAll('#filterForm input[type="checkbox"]').forEach(cb => cb.checked = false);
    // Reset radio to default (urgent)
    document.querySelector('#filterForm input[name="sort"][value="urgent"]').checked = true;
    // Submit form
    document.getElementById('filterForm').submit();
}

// Close modal on outside click
document.getElementById('filterModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeFilterModal();
    }
});

// Close modal on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeFilterModal();
    }
});
</script>

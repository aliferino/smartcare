@extends('layouts.panel')

@section('content')
<div x-data="categoryHandler()" x-init="init()">
    <div class="mb-6 flex justify-between items-end">
        <div>
            <h1 class="text-2xl font-black text-slate-900 uppercase">Campaign Categories</h1>
            <p class="text-slate-500 text-xs font-medium uppercase tracking-widest opacity-70">Manage campaign classification types</p>
        </div>
        <button @click="resetForm(); openModal = true"
                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-black rounded-lg transition-colors flex items-center gap-2">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Add Category
        </button>
    </div>

    <div class="bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-blue-600">
                    <th class="px-6 py-4 text-xs font-black text-white uppercase tracking-widest border-b border-blue-500">Name</th>
                    <th class="px-6 py-4 text-xs font-black text-white uppercase tracking-widest border-b border-blue-500 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50 font-medium">
                <template x-for="category in categories" :key="category.id">
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4 text-sm font-black text-slate-900 uppercase tracking-tight" x-text="category.name"></td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                <button @click="editCategory(category)" class="w-8 h-8 flex items-center justify-center text-slate-400 hover:text-white hover:bg-yellow-400 rounded-lg transition-all duration-200">
                                    <i data-lucide="pencil" class="w-4 h-4"></i>
                                </button>
                                <button @click="deleteCategory(category.id)" class="w-8 h-8 flex items-center justify-center text-slate-400 hover:text-white hover:bg-red-600 rounded-lg transition-all duration-200">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>

    @include('admin.campaigns.categories._modal')
</div>

<script>
function categoryHandler() {
    return {
        categories: @json($categories),
        openModal: false,
        editMode: false,
        categoryName: '',
        categoryId: '',
        actionUrl: '',

        init() {
            this.$nextTick(() => lucide.createIcons());
        },

        resetForm() {
            this.editMode = false;
            this.categoryName = '';
            this.categoryId = '';
            this.actionUrl = '{{ route("admin.campaigns.categories.store") }}';
        },

        editCategory(category) {
            this.editMode = true;
            this.categoryName = category.name;
            this.categoryId = category.id;
            this.actionUrl = `/admin/campaigns/categories/${category.id}/update`;
            this.openModal = true;
            this.$nextTick(() => lucide.createIcons());
        },

        async submitForm() {
            try {
                const method = this.editMode ? 'PUT' : 'POST';
                const response = await fetch(this.actionUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        name: this.categoryName,
                        _method: method
                    })
                });

                const data = await response.json();

                if (response.ok) {
                    if (this.editMode) {
                        const idx = this.categories.findIndex(c => c.id == this.categoryId);
                        this.categories[idx].name = data.name;
                    } else {
                        this.categories.unshift(data);
                    }
                    this.openModal = false;
                    this.$nextTick(() => lucide.createIcons());
                }
            } catch (err) {
                alert('Gagal menyimpan data');
            }
        },

        async deleteCategory(id) {
            if (!confirm('Yakin ingin menghapus kategori ini?')) return;

            try {
                const response = await fetch(`/admin/campaigns/categories/${id}/delete`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ _method: 'DELETE' })
                });

                if (response.ok) {
                    this.categories = this.categories.filter(c => c.id !== id);
                } else {
                    const errData = await response.json();
                    alert(errData.message || 'Gagal menghapus');
                }
            } catch (err) {
                alert('Terjadi kesalahan jaringan');
            }
        }
    }
}
</script>
@endsection
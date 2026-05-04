@extends('layouts.panel')

@section('content')
{{-- Inisialisasi data categories langsung dari Laravel ke Alpine --}}
<div x-data="categoryHandler()" x-init="init()">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-slate-800">Entity Categories</h2>
        <button @click="resetForm(); openModal = true" 
                class="px-4 py-2 bg-blue-600 text-white rounded-xl text-sm font-semibold hover:bg-blue-700 transition-all">
            Add New Category
        </button>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                {{-- Loop Reaktif Alpine.js --}}
                <template x-for="category in categories" :key="category.id">
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4 text-sm font-medium text-slate-700" x-text="category.name"></td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-3">
                                <button @click="editCategory(category)" 
                                        class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all">
                                    <i data-lucide="pencil" class="w-4 h-4"></i>
                                </button>

                                <button @click="deleteCategory(category.id)" 
                                        class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>

    @include('admin.entities.categories._form')
</div>

<script>

function categoryHandler() {
    return {
        categories: @json($categories), // Ambil data awal dari Laravel
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
            this.actionUrl = '{{ route("admin.entities.categories.store") }}';
        },

        editCategory(category) {
            this.editMode = true;
            this.categoryName = category.name;
            this.categoryId = category.id;
            this.actionUrl = `/admin/entities/categories/${category.id}/update`; // Gunakan URL update kamu
            this.openModal = true;
            this.$nextTick(() => lucide.createIcons());
        },

        async submitForm() {
            try {
                const method = this.editMode ? 'PUT' : 'POST';
                const response = await fetch(this.actionUrl, {
                    method: 'POST', // Laravel butuh POST dengan _method spoofing
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
                        // Cari data di array dan update langsung[cite: 8]
                        const idx = this.categories.findIndex(c => c.id == this.categoryId);
                        this.categories[idx].name = data.name;
                    } else {
                        // Tambah data baru ke atas tabel[cite: 8]
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
            if (!confirm('Yakin ingin menghapus?')) return;

            try {
                const response = await fetch(`/admin/entities/categories/${id}/delete`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ _method: 'DELETE' })
                });

                if (response.ok) {
                    // Hapus data dari array Alpine[cite: 8]
                    this.categories = this.categories.filter(c => c.id !== id);
                }
            } catch (err) {
                alert('Gagal menghapus');
            }
        }
    }
}
</script>
@endsection
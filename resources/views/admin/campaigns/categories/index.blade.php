@extends('layouts.panel', ['title' => 'Campaign Categories'])

@section('content')
<div class="mb-6 flex justify-between items-end">
    <div>
        <h1 class="text-2xl font-black text-slate-900 uppercase">Campaign Categories</h1>
        <p class="text-slate-500 text-xs font-medium uppercase tracking-widest opacity-70">Manage campaign classification types</p>
    </div>
    <button onclick="openCreateModal()" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-black rounded-lg transition-colors flex items-center gap-2">
        <i data-lucide="plus" class="w-4 h-4"></i>
        Add Category
    </button>
</div>

<div id="table-container" class="bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden">
    @include('admin.campaigns.categories._table', ['categories' => $categories])
</div>

@include('admin.campaigns.categories._modal')

@push('scripts')
<script>
    $(document).ready(function() {
        // Handle pagination clicks
        $(document).on('click', '.pagination-link', function(e) {
            e.preventDefault();
            const page = $(this).data('page');
            loadPage(page);
        });
    });

    function loadPage(page = 1) {
        const container = $('#table-container');
        container.css('opacity', '0.5');

        $.ajax({
            url: '{{ route("admin.campaigns.categories.index") }}',
            method: 'GET',
            data: { page: page },
            success: function(response) {
                container.html(response);
                container.css('opacity', '1');
                lucide.createIcons();

                // Scroll to top smoothly
                $('html, body').animate({ scrollTop: 0 }, 'fast');

                // Keep URL clean
                history.replaceState(null, '', '{{ route("admin.campaigns.categories.index") }}');
            },
            error: function() {
                container.css('opacity', '1');
                alert('Failed to load page. Please try again.');
            }
        });
    }

    function openCreateModal() {
        $('#modalTitle').text('Add New Category');
        $('#categoryName').val('');
        $('#categoryId').val('');
        $('#formMethod').val('create');
        Modal.open('categoryModal');
    }

    function editCategory(id, name) {
        $('#modalTitle').text('Edit Category');
        $('#categoryName').val(name);
        $('#categoryId').val(id);
        $('#formMethod').val('edit');
        Modal.open('categoryModal');
    }

    $('#categoryForm').on('submit', function(e) {
        e.preventDefault();
        const method = $('#formMethod').val();
        const categoryId = $('#categoryId').val();
        const categoryName = $('#categoryName').val();

        let url = method === 'edit'
            ? `/admin/campaigns/categories/${categoryId}/update`
            : '{{ route("admin.campaigns.categories.store") }}';

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                _method: method === 'edit' ? 'PUT' : 'POST',
                name: categoryName
            },
            success: function(response) {
                Modal.close('categoryModal');
                loadPage();
            },
            error: function(xhr) {
                alert(xhr.responseJSON?.message || 'Failed to save category');
            }
        });
    });

    function deleteCategory(id) {
        if (!confirm('Are you sure you want to delete this category?')) return;

        $.ajax({
            url: `/admin/campaigns/categories/${id}/delete`,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                _method: 'DELETE'
            },
            success: function(response) {
                loadPage();
            },
            error: function(xhr) {
                alert(xhr.responseJSON?.message || 'Failed to delete category');
            }
        });
    }
</script>
@endpush
@endsection

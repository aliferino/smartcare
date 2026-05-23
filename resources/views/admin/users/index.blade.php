@extends('layouts.panel')

@section('title', 'User Management')

@section('content')
<div class="mb-6 flex justify-between items-end">
    <div>
        <h1 class="text-2xl font-black text-slate-900 uppercase">User Management</h1>
        <p class="text-slate-500 text-xs font-medium uppercase tracking-widest opacity-70">Manage and verify user accounts</p>
    </div>
    <button onclick="openCreateUserModal()" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-black rounded-lg transition-colors flex items-center gap-2">
        <i data-lucide="user-plus" class="w-4 h-4"></i>
        Create User
    </button>
</div>

<div class="mb-6">
    <div class="relative">
        <input
            type="text"
            id="searchInput"
            placeholder="Type name or email and press Enter..."
            class="w-full pl-11 pr-4 py-3.5 bg-white border border-slate-100 rounded-2xl text-xs font-black uppercase focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all shadow-sm placeholder:text-slate-400 placeholder:font-bold"
        >
        <div class="absolute left-4 top-4 text-slate-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
    </div>
</div>

<div id="table-container">
    @include('admin.users._table')
</div>

@include('admin.users._modal')
@include('admin.citizen._modal')

<script>
    $(document).ready(function() {
        $('#searchInput').on('keypress', function(e) {
            if(e.which === 13) {
                e.preventDefault();
                const query = $(this).val();
                performSearch(query, 1);
            }
        });

        // Handle pagination clicks
        $(document).on('click', '.pagination-link', function(e) {
            e.preventDefault();
            const page = $(this).data('page');
            const query = $('#searchInput').val();
            performSearch(query, page);
        });
    });

    function performSearch(query, page = 1) {
        const container = $('#table-container');
        container.css('opacity', '0.5');

        $.ajax({
            url: '{{ route("admin.users.index") }}',
            method: 'GET',
            data: { search: query, page: page },
            success: function(response) {
                const parser = new DOMParser();
                const doc = parser.parseFromString(response, 'text/html');
                const newContent = $(doc).find('#table-container').html();

                if(newContent) {
                    container.html(newContent);
                } else {
                    container.html(response);
                }

                container.css('opacity', '1');
                lucide.createIcons();

                // Keep URL clean (no query params)
                history.replaceState(null, '', '{{ route("admin.users.index") }}');
            },
            error: function() {
                container.css('opacity', '1');
                alert('Search failed. Please try again.');
            }
        });
    }
</script>
@endsection

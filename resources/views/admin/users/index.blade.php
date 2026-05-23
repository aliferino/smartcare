@extends('layouts.panel')

@section('title', 'User Management')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-black text-slate-900 uppercase">User Management</h1>
    <p class="text-slate-500 text-xs font-medium uppercase tracking-widest opacity-70">Manage and verify user accounts</p>
</div>

<div class="flex items-center justify-between mb-4">
    <div class="relative flex-1 max-w-md">
        <i data-lucide="search" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
        <input
            type="text"
            id="searchInput"
            placeholder="Search by name or email..."
            class="w-full pl-10 pr-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all"
        >
    </div>
    <button onclick="openCreateUserModal()" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-black uppercase tracking-wider transition-all duration-200 shadow-lg shadow-blue-200 hover:shadow-xl hover:shadow-blue-300 flex items-center gap-2">
        <i data-lucide="user-plus" class="w-4 h-4"></i>
        Create User
    </button>
</div>

<div id="table-container">
    @include('admin.users._table')
</div>

@include('admin.users._modal')
@include('admin.citizen._modal')

<script>
    $(document).ready(function() {
        $('#searchInput').on('keypress', function(e) {
            if(e.which === 13) { // Enter key
                e.preventDefault();
                const query = $(this).val();
                performSearch(query);
            }
        });
    });

    function performSearch(query) {
        const container = $('#table-container');
        container.css('opacity', '0.5');

        $.ajax({
            url: '{{ route("admin.users.index") }}',
            method: 'GET',
            data: { search: query },
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
            },
            error: function() {
                container.css('opacity', '1');
                alert('Search failed. Please try again.');
            }
        });
    }
</script>
@endsection

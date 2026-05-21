@extends('layouts.panel', ['title' => 'My Entities'])

@section('content')

{{-- Header --}}
<div class="mb-8">
    <h1 class="text-2xl font-black text-slate-900 uppercase tracking-tight">My Entities</h1>
    <p class="text-slate-500 text-xs font-medium uppercase tracking-widest opacity-70">Manage your organization entities</p>
</div>

{{-- Action Bar --}}
<div class="flex items-center justify-between mb-4">
    <div class="relative">
        <input type="text"
               id="searchInput"
               placeholder="Search entities..."
               class="pl-10 pr-4 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent w-64">
        <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
    </div>

    <button onclick="Modal.open('entityModal', { mode: 'create' })"
            class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2">
        <i data-lucide="plus" class="w-4 h-4"></i>
        Create Entity
    </button>
</div>

{{-- Table Container --}}
<div id="table-container" class="bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden">
    @include('fundraiser.entities._table')
</div>

@include('fundraiser.entities._modal')

@endsection

@push('scripts')
<script>
    // Search functionality
    $('#searchInput').on('keyup', function() {
        const value = $(this).val().toLowerCase();
        $('#table-container tbody tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });

    // Refresh table after modal actions
    window.addEventListener('modal:closed', function(e) {
        if (e.detail.modalId === 'entityModal' && e.detail.refresh) {
            location.reload();
        }
    });
</script>
@endpush

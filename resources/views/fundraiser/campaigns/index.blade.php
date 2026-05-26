@extends('layouts.panel', ['title' => 'My Campaigns'])

@section('content')

<div class="mb-6 flex justify-between items-end">
    <div>
        <h1 class="text-2xl font-black text-slate-900 uppercase">My Campaigns</h1>
        <p class="text-slate-500 text-xs font-medium uppercase tracking-widest opacity-70">Manage your fundraising campaigns</p>
    </div>
    <button onclick="Modal.open('campaignModal', { mode: 'create' })" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-black rounded-lg transition-colors flex items-center gap-2">
        <i data-lucide="plus" class="w-4 h-4"></i>
        Create Campaign
    </button>
</div>

<div class="mb-6">
    <div class="relative">
        <input
            type="text"
            id="searchInput"
            placeholder="Type campaign title and press Enter..."
            class="w-full pl-11 pr-4 py-3.5 bg-white border border-slate-100 rounded-2xl text-xs font-black uppercase focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all shadow-sm placeholder:text-slate-400 placeholder:font-bold"
        >
        <div class="absolute left-4 top-4 text-slate-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
    </div>
</div>

{{-- Table Container --}}
<div id="table-container" class="bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden">
    @include('fundraiser.campaigns._table')
</div>

@include('fundraiser.campaigns._modal')

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

    // Clear search when pagination links are clicked
    $(document).on('click', '.pagination a', function() {
        $('#searchInput').val('');
    });

    // Refresh table after modal actions
    window.addEventListener('modal:closed', function(e) {
        if (e.detail.modalId === 'campaignModal' && e.detail.refresh) {
            location.reload();
        }
    });
</script>
@endpush

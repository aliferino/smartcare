@extends('layouts.panel', ['title' => 'Withdraws Dashboard'])

@section('content')
<div class="mb-6 flex justify-between items-end">
    <div>
        <h1 class="text-2xl font-black text-slate-900 uppercase">Withdraws Record</h1>
        <p class="text-slate-500 text-xs font-medium uppercase tracking-widest opacity-70">Manage your fund withdrawal requests</p>
    </div>
    <button onclick="Modal.open('withdrawModal', { mode: 'create' })" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-black rounded-lg transition-colors flex items-center gap-2">
        <i data-lucide="plus" class="w-4 h-4"></i>
        New Request
    </button>
</div>

<div class="mb-6">
    <div class="relative">
        <input type="text" id="searchInput"
            placeholder="Search by account holder, bank, or campaign..."
            class="w-full pl-11 pr-4 py-3.5 bg-white border border-slate-100 rounded-2xl text-xs font-black uppercase focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all shadow-sm placeholder:text-slate-400 placeholder:font-bold">
        <div class="absolute left-4 top-4 text-slate-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
    </div>
</div>

<div id="table-container" class="bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden">
    @include('fundraiser.withdraws._table', ['withdraws' => $withdraws])
</div>

@include('fundraiser.withdraws._modal')

@push('scripts')
<script>
    $(document).ready(function() {
        function fetchData() {
            $('#table-container').addClass('opacity-50 pointer-events-none');
            let search = $('#searchInput').val();
            let url = window.location.href.split('?')[0];

            $.ajax({
                url: url,
                type: 'GET',
                data: { search: search },
                success: function (data) {
                    $('#table-container').html(data).removeClass('opacity-50 pointer-events-none');
                    lucide.createIcons();
                },
                error: function () {
                    $('#table-container').removeClass('opacity-50 pointer-events-none');
                }
            });
        }

        $('#searchInput').on('keypress', function (e) {
            if (e.which == 13) { fetchData(); }
        });

        $(document).on('click', '.pagination-link', function (e) {
            e.preventDefault();
            let page = $(this).data('page');
            let search = $('#searchInput').val();

            $.ajax({
                url: '{{ route("fundraiser.withdraws.index") }}',
                type: 'GET',
                data: { search: search, page: page },
                success: function (data) {
                    $('#table-container').html(data);
                    lucide.createIcons();
                    $('html, body').animate({ scrollTop: 0 }, 'fast');
                    history.replaceState(null, '', '{{ route("fundraiser.withdraws.index") }}');
                }
            });
        });
    });
</script>
@endpush
@endsection

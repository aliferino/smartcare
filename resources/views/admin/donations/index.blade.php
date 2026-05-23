@extends('layouts.panel', ['title' => 'Manage Donations'])

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-black text-slate-900 uppercase">Donation Records</h1>
    <p class="text-slate-500 text-xs font-medium uppercase tracking-widest opacity-70">Monitor and track all incoming contributions.</p>
</div>

<div class="mb-6">
    <div class="relative">
        <input type="text" id="searchInput"
            placeholder="Type donor name, campaign title and press Enter..."
            class="w-full pl-11 pr-4 py-3.5 bg-white border border-slate-100 rounded-2xl text-xs font-black uppercase focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all shadow-sm placeholder:text-slate-400 placeholder:font-bold">
        <div class="absolute left-4 top-4 text-slate-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
    </div>
</div>

<div id="table-container" class="bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden">
    @include('admin.donations._table', ['donations' => $donations])
</div>

@include('admin.donations._modal')

@push('scripts')
<script>
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
            },
            error: function () {
                $('#table-container').removeClass('opacity-50 pointer-events-none');
            }
        });
    }

    $('#searchInput').on('keypress', function (e) {
        if (e.which == 13) { fetchData(); }
    });

    $('#searchIcon').on('click', fetchData);

    $(document).on('click', '.pagination-link', function (e) {
        e.preventDefault();
        let page = $(this).data('page');
        let search = $('#searchInput').val();

        $.ajax({
            url: '{{ route("admin.donations.index") }}',
            type: 'GET',
            data: { search: search, page: page },
            success: function (data) {
                $('#table-container').html(data);
                $('html, body').animate({ scrollTop: 0 }, 'fast');

                // Keep URL clean
                history.replaceState(null, '', '{{ route("admin.donations.index") }}');
            }
        });
    });
</script>
@endpush
@endsection
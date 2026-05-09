@extends('layouts.panel', ['title' => 'Manage Donations'])

@section('content')
<div class="mb-6">
    <div>
        <h1 class="text-2xl font-black text-slate-900 uppercase">Donation Records</h1>
        <p class="text-slate-500 text-xs font-medium uppercase opacity-70">Monitor and track all incoming contributions.</p>
    </div>
</div>

<div class="mb-6">
    <div class="relative w-full">
        <input type="text" id="searchInput" 
            placeholder="Search by Donor Name, Email, Phone, or Campaign Title..." 
            class="w-full pl-12 pr-4 py-4 bg-white border border-slate-200 rounded-2xl text-xs font-bold text-slate-700 focus:outline-none focus:ring-4 focus:ring-blue-600/5 focus:border-blue-600 transition-all placeholder:text-slate-300 uppercase tracking-tight shadow-sm">
        <div id="searchIcon" class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 cursor-pointer hover:text-blue-600 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
    </div>
</div>

<div class="bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden">
    <div id="table-container">
        @include('admin.donations._table', ['donations' => $donations])
    </div>
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

    $(document).on('click', '.pagination a', function (e) {
        e.preventDefault();
        let url = $(this).attr('href');
        let search = $('#searchInput').val();

        $.get(url, { search: search }, function (data) {
            $('#table-container').html(data);
            $('html, body').animate({ scrollTop: 0 }, 'fast');
        });
    });
</script>
@endpush
@endsection
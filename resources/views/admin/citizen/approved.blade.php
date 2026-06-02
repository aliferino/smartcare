@extends('layouts.panel', ['title' => 'Approved Citizens'])

@section('content')
<div class="mb-6 flex justify-between items-end">
    <div>
        <h1 class="text-2xl font-black text-slate-900 uppercase">Approved KYC Submissions</h1>
        <p class="text-slate-500 text-xs font-medium uppercase opacity-70">View all verified citizen accounts.</p>
    </div>
    <a href="{{ route('admin.users.citizens.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-black rounded-lg transition-colors flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Back to Dashboard
    </a>
</div>

<div class="mb-6">
    <div class="relative">
        <input type="text" id="searchInput" placeholder="Type name or NIK and press Enter..."
            class="w-full pl-11 pr-4 py-3.5 bg-white border border-slate-100 rounded-2xl text-xs font-black uppercase focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all shadow-sm placeholder:text-slate-400 placeholder:font-bold">
        <div class="absolute left-4 top-4 text-slate-400" id="searchIcon">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
    </div>
</div>

<div id="table-container" class="bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden">
    @include('admin.citizen._table', ['citizens' => $citizens, 'context' => 'approved'])
</div>

@include('admin.citizen._modal')

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
                const parser = new DOMParser();
                const doc = parser.parseFromString(data, 'text/html');
                const newContent = $(doc).find('#table-container').html();

                if(newContent) {
                    $('#table-container').html(newContent).removeClass('opacity-50 pointer-events-none');
                } else {
                    $('#table-container').html(data).removeClass('opacity-50 pointer-events-none');
                }
                lucide.createIcons();
            },
            error: function () {
                $('#table-container').removeClass('opacity-50 pointer-events-none');
            }
        });
    }

    $(document).ready(function () {
        $('#searchInput').on('keypress', function (e) {
            if (e.which == 13) {
                e.preventDefault();
                fetchData();
            }
        });

        $('#searchIcon').on('click', function () {
            fetchData();
        });

        $(document).on('click', '.pagination a', function (e) {
            e.preventDefault();
            let url = $(this).attr('href');
            let search = $('#searchInput').val();

            $.get(url, { search: search }, function (data) {
                const parser = new DOMParser();
                const doc = parser.parseFromString(data, 'text/html');
                const newContent = $(doc).find('#table-container').html();

                if(newContent) {
                    $('#table-container').html(newContent);
                } else {
                    $('#table-container').html(data);
                }
                lucide.createIcons();
                $('html, body').animate({ scrollTop: $('#table-container').offset().top - 100 }, 200);
            });
        });
    });
</script>
@endpush
@endsection

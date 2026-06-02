@extends('layouts.panel', ['title' => 'Pending Campaigns'])

@section('content')
<div class="mb-6 flex justify-between items-end">
    <div>
        <h1 class="text-2xl font-black text-slate-900 uppercase">Pending Approval</h1>
        <p class="text-slate-500 text-xs font-medium uppercase opacity-70">Review and verify new campaign submissions.</p>
    </div>
    <a href="{{ route('admin.campaigns.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-black rounded-lg transition-colors flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Back to Dashboard
    </a>
</div>

<div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
    <div class="relative col-span-2">
        <input type="text" id="searchInput" placeholder="Type name and press Enter..." 
            class="w-full pl-11 pr-4 py-3.5 bg-white border border-slate-100 rounded-2xl text-xs font-black uppercase focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all shadow-sm placeholder:text-slate-400 placeholder:font-bold">
        <div class="absolute left-4 top-4 text-slate-400" id="searchIcon">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
    </div>

    <div class="relative" id="categoryDropdown">
        <input type="hidden" id="categoryFilter" value="">
        <button type="button" id="dropdownToggle"
            class="w-full pl-5 pr-4 py-3.5 bg-white border border-slate-100 rounded-2xl text-xs font-black uppercase text-slate-700 text-left outline-none transition-all shadow-sm cursor-pointer flex items-center justify-between hover:border-blue-300 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500">
            <span id="dropdownLabel">ALL CATEGORIES</span>
            <svg xmlns="http://www.w3.org/2000/svg" id="dropdownArrow" class="h-4 w-4 text-blue-500 transition-transform duration-200 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" />
            </svg>
        </button>
        <div id="dropdownMenu"
            class="hidden absolute z-50 top-full mt-2 w-full bg-white border border-slate-100 rounded-2xl shadow-xl overflow-hidden">
            <div data-value="" 
                class="dropdown-option px-5 py-3 text-xs font-black uppercase cursor-pointer bg-blue-500 text-white transition-colors">
                ALL CATEGORIES
            </div>
            @foreach($categories as $cat)
                <div data-value="{{ $cat->id }}"
                    class="dropdown-option px-5 py-3 text-xs font-black uppercase cursor-pointer text-slate-700 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                    {{ strtoupper($cat->name) }}
                </div>
            @endforeach
        </div>
    </div>
</div>

<div id="table-container" class="bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden">
    @include('admin.campaigns._table', ['campaigns' => $campaigns, 'context' => 'pending'])
</div>

@include('admin.campaigns._modal')

@push('scripts')
<script>
    $(document).ready(function () {
        $('#dropdownToggle').on('click', function (e) {
        e.stopPropagation();
        const menu = $('#dropdownMenu');
        const arrow = $('#dropdownArrow');
        const isOpen = !menu.hasClass('hidden');

        if (isOpen) {
            menu.addClass('hidden');
            arrow.css('transform', 'rotate(0deg)');
        } else {
            menu.removeClass('hidden');
            arrow.css('transform', 'rotate(180deg)');
        }
    });

    $(document).on('click', '.dropdown-option', function () {
        const value = $(this).data('value');
        const label = $(this).text().trim();
        $('#categoryFilter').val(value);
        $('#dropdownLabel').text(label);
        $('.dropdown-option').removeClass('bg-blue-500 text-white').addClass('text-slate-700 hover:bg-blue-50 hover:text-blue-600');
        $(this).addClass('bg-blue-500 text-white').removeClass('text-slate-700 hover:bg-blue-50 hover:text-blue-600');
        $('#dropdownMenu').addClass('hidden');
        $('#dropdownArrow').css('transform', 'rotate(0deg)');
        fetchData();
    });

    $(document).on('click', function (e) {
        if (!$('#categoryDropdown').is(e.target) && $('#categoryDropdown').has(e.target).length === 0) {
            $('#dropdownMenu').addClass('hidden');
            $('#dropdownArrow').css('transform', 'rotate(0deg)');
        }
    });

    function fetchData() {
        $('#table-container').addClass('opacity-50 pointer-events-none');

        let search = $('#searchInput').val();
        let category = $('#categoryFilter').val();
        let url = window.location.href.split('?')[0];

        $.ajax({
            url: url,
            type: 'GET',
            data: { search: search, category: category },
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
        let category = $('#categoryFilter').val();

        $.get(url, { search: search, category: category }, function (data) {
            $('#table-container').html(data);
            lucide.createIcons();
            $('html, body').animate({ scrollTop: $('#table-container').offset().top - 100 }, 200);
        });
    });

});
</script>
@endpush
@endsection
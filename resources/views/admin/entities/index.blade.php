@extends('layouts.panel', ['title' => 'Entity Management'])

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-black text-slate-900 uppercase">Entity Dashboard</h1>
    <p class="text-slate-500 text-xs font-medium uppercase tracking-widest opacity-70">Monitor and manage organization entities.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
    @php
        $stats = [
            ['title' => 'Pending Entities', 'count' => $counts['pending'], 'route' => 'admin.entities.pending', 'color' => 'bg-amber-400'],
            ['title' => 'Approved Entities', 'count' => $counts['approved'], 'route' => 'admin.entities.approved', 'color' => 'bg-emerald-400'],
            ['title' => 'Rejected Entities', 'count' => $counts['rejected'], 'route' => 'admin.entities.rejected', 'color' => 'bg-rose-400'],
        ];
    @endphp

    @foreach($stats as $stat)
    <a href="{{ route($stat['route']) }}" class="bg-white border border-slate-100 rounded-xl p-6 hover:shadow-lg transition-all group">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-[10px] font-black uppercase tracking-widest mb-2">
                    @if(strpos($stat['title'], 'Pending') !== false)
                        <span class="text-amber-600">{{ $stat['title'] }}</span>
                    @elseif(strpos($stat['title'], 'Approved') !== false)
                        <span class="text-emerald-600">{{ $stat['title'] }}</span>
                    @else
                        <span class="text-rose-600">{{ $stat['title'] }}</span>
                    @endif
                </p>
                <p class="text-4xl font-black text-slate-900">{{ $stat['count'] }}</p>
            </div>
            <div class="w-12 h-12 rounded-full flex items-center justify-center group-hover:transition-colors
                @if(strpos($stat['title'], 'Pending') !== false)
                    bg-amber-50 group-hover:bg-amber-100
                @elseif(strpos($stat['title'], 'Approved') !== false)
                    bg-emerald-50 group-hover:bg-emerald-100
                @else
                    bg-rose-50 group-hover:bg-rose-100
                @endif
            ">
                @if(strpos($stat['title'], 'Pending') !== false)
                    <i data-lucide="clock" class="w-6 h-6 text-amber-600"></i>
                @elseif(strpos($stat['title'], 'Approved') !== false)
                    <i data-lucide="check-circle" class="w-6 h-6 text-emerald-600"></i>
                @else
                    <i data-lucide="x-circle" class="w-6 h-6 text-rose-600"></i>
                @endif
            </div>
        </div>
    </a>
    @endforeach
</div>

<div class="flex items-center justify-between mb-4">
    <h2 class="text-md font-black text-slate-900 uppercase">Recently Added</h2>
</div>

<div id="table-container" class="bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden">
    @include('admin.entities._table')
</div>

@include('admin.entities._modal')

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
            url: '{{ route("admin.entities.index") }}',
            method: 'GET',
            data: { page: page },
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

                // Scroll to top smoothly
                $('html, body').animate({ scrollTop: 0 }, 'fast');

                // Keep URL clean
                history.replaceState(null, '', '{{ route("admin.entities.index") }}');
            },
            error: function() {
                container.css('opacity', '1');
                alert('Failed to load page. Please try again.');
            }
        });
    }
</script>
@endsection
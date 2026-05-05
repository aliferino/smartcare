@extends('layouts.panel', ['title' => 'Entity Management'])

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-black text-slate-900 text-uppercase">Entity Dashboard</h1>
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
    <a href="{{ route($stat['route']) }}" class="group bg-white p-5 rounded-2xl border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-blue-500/10 hover:-translate-y-1 transition-all duration-300">
        <div class="flex justify-between items-center mb-2">
            <p class="text-slate-400 text-[9px] font-black uppercase tracking-widest">{{ $stat['title'] }}</p>
            <div class="w-1.5 h-1.5 rounded-full {{ $stat['color'] }}"></div>
        </div>
        <div class="flex items-baseline gap-2">
            <h3 class="text-3xl font-black text-slate-900">{{ $stat['count'] }}</h3>
            <span class="text-[10px] text-blue-600 font-bold opacity-0 group-hover:opacity-100 transition-opacity">View List →</span>
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

@push('scripts')
<script>
    $(document).ready(function() {
        $(document).on('click', '.pagination a', function(event) {
            event.preventDefault();
            let page = $(this).attr('href').split('page=')[1];
            fetchData(page);
        });

        function fetchData(page) {
            $('#table-container').css('opacity', '0.5');

            $.ajax({
                url: "{{ route('admin.entities.index') }}?page=" + page,
                success: function(data) {
                    $('#table-container').html(data);
                    $('#table-container').css('opacity', '1');
                },
                error: function() {
                    alert('Gagal mengambil data. Silakan coba lagi.');
                    $('#table-container').css('opacity', '1');
                }
            });
        }
    });
</script>
@endpush
@endsection
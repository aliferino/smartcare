@extends('layouts.panel', ['title' => 'Campaign Management'])

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-black text-slate-900 uppercase">Campaign Dashboard</h1>
    <p class="text-slate-500 text-xs font-medium uppercase tracking-widest opacity-70">Monitor and manage all fundraising campaigns.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
    @php
        $stats = [
            ['title' => 'Pending', 'count' => $counts['pending'], 'route' => 'admin.campaigns.pending', 'color' => 'bg-amber-400'],
            ['title' => 'Approved', 'count' => $counts['approved'], 'route' => 'admin.campaigns.approved', 'color' => 'bg-emerald-400'],
            ['title' => 'Rejected', 'count' => $counts['rejected'], 'route' => 'admin.campaigns.rejected', 'color' => 'bg-rose-400'],
            ['title' => 'Completed', 'count' => $counts['completed'], 'route' => 'admin.campaigns.completed', 'color' => 'bg-blue-400'],
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
            <span class="text-[10px] text-blue-600 font-bold opacity-0 group-hover:opacity-100 transition-opacity">View →</span>
        </div>
    </a>
    @endforeach
</div>

<div class="flex items-center justify-between mb-4">
    <h2 class="text-md font-black text-slate-900 uppercase">Recently Added</h2>
</div>

<div id="table-container" class="bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden">
    @include('admin.campaigns._table', ['campaigns' => $campaigns, 'context' => 'index'])
</div>

@include('admin.campaigns._modal')
@endsection
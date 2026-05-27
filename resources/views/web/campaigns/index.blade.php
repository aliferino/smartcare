@extends('layouts.web')

@section('title', 'All Campaigns - SmartCare')

@section('content')

<!-- Filter Button Section -->
<section class="py-4 bg-blue-50 border-b border-blue-100">
    <div class="container mx-auto px-4">
        <button onclick="openFilterModal()" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-black uppercase tracking-wider transition-colors flex items-center gap-2">
            <i data-lucide="filter" class="w-4 h-4"></i>
            Filter Campaigns
        </button>
    </div>
</section>

<!-- Campaigns Grid -->
<section class="py-8 bg-slate-50">
    <div class="container mx-auto px-4">
        <div id="campaignsContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($campaigns ?? [] as $campaign)
                @include('layouts.components.card-campaign', ['campaign' => $campaign, 'isUrgent' => $campaign->is_urgent])
            @empty
            <div class="col-span-full text-center py-12">
                <i data-lucide="inbox" class="w-16 h-16 text-slate-300 mx-auto mb-4"></i>
                <p class="text-lg font-bold text-slate-400">No campaigns found</p>
            </div>
            @endforelse
        </div>

        @if(isset($campaigns) && $campaigns->hasPages())
        <div class="mt-8 bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden">
            {{ $campaigns->links() }}
        </div>
        @endif
    </div>
</section>

@include('web.campaigns._modal')

@endsection

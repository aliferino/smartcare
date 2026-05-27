@extends('layouts.web')

@section('title', 'SmartCare - Platform Donasi & Penggalangan Dana')

@section('content')

<!-- Hero Section -->
<section class="bg-gradient-to-br from-blue-800 via-blue-900 to-slate-900 text-white py-32 min-h-screen flex items-center">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-6xl md:text-7xl font-black uppercase tracking-tight mb-8">Make a Difference Today</h1>
            <p class="text-2xl md:text-3xl font-medium text-blue-100 leading-relaxed">Join thousands of people helping those in need. Every donation counts. Together, we create lasting change in communities around the world.</p>
        </div>
    </div>
</section>

<!-- Urgent Campaigns -->
@if(isset($urgentCampaigns) && $urgentCampaigns->count() > 0)
<section class="py-16 bg-slate-50">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center gap-3">
                <i data-lucide="alert-circle" class="w-6 h-6 text-rose-600"></i>
                <h2 class="text-3xl font-black text-slate-900 uppercase tracking-tight">Urgent Campaigns</h2>
            </div>
            <a href="/campaigns?sort=urgent" class="px-6 py-2.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-sm font-black uppercase tracking-wider transition-colors">
                Show All Campaigns
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($urgentCampaigns as $campaign)
                @include('layouts.components.card-campaign', ['campaign' => $campaign, 'isUrgent' => true])
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- All Campaigns -->
<section id="campaigns" class="py-16 bg-slate-50">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-3xl font-black text-slate-900 uppercase tracking-tight">All Campaigns</h2>
            <a href="/campaigns" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-black uppercase tracking-wider transition-colors">
                Show All Campaigns
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($campaigns ?? [] as $campaign)
                @include('layouts.components.card-campaign', ['campaign' => $campaign, 'isUrgent' => $campaign->is_urgent])
            @empty
            <div class="col-span-full text-center py-12">
                <i data-lucide="inbox" class="w-16 h-16 text-slate-300 mx-auto mb-4"></i>
                <p class="text-lg font-bold text-slate-400">No campaigns available at the moment</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Join Our Mission Banner -->
<section class="py-20 bg-gradient-to-r from-blue-600 via-blue-700 to-blue-800 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-0 w-96 h-96 bg-white rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-white rounded-full blur-3xl"></div>
    </div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-4xl mx-auto text-center text-white">
            <h2 class="text-4xl md:text-5xl font-black uppercase tracking-tight mb-6">Join Our Mission</h2>
            <p class="text-xl font-medium text-blue-100 mb-8 leading-relaxed">Every contribution makes a difference. Browse our campaigns and support causes that matter to you. Together, we can create positive change in communities around the world.</p>
            <div class="flex gap-4 justify-center">
                <a href="/campaigns" class="px-8 py-4 bg-white text-blue-600 rounded-xl text-sm font-black uppercase tracking-wider hover:bg-blue-50 transition-colors shadow-lg">
                    Explore All Campaigns
                </a>
                <a href="/register" class="px-8 py-4 bg-blue-500 text-white rounded-xl text-sm font-black uppercase tracking-wider hover:bg-blue-400 transition-colors border-2 border-white/20">
                    Start Your Campaign
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Impact Statistics -->
<section class="py-12 bg-blue-600">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-6xl mx-auto">
            <!-- Total Donors -->
            <div class="flex items-center gap-4 text-white">
                <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center flex-shrink-0">
                    <i data-lucide="users" class="w-8 h-8"></i>
                </div>
                <div>
                    <div class="text-4xl font-black mb-1">{{ $stats['total_donors'] ?? 0 }}</div>
                    <div class="text-lg font-bold uppercase tracking-wider">Total Donors</div>
                </div>
            </div>
            <!-- Total Raised -->
            <div class="flex items-center gap-4 text-white">
                <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center flex-shrink-0">
                    <i data-lucide="credit-card" class="w-8 h-8"></i>
                </div>
                <div>
                    <div class="text-4xl font-black mb-1">Rp {{ number_format($stats['total_raised'] ?? 0, 0, ',', '.') }}</div>
                    <div class="text-lg font-bold uppercase tracking-wider">Total Raised</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Sponsors Section -->
<!-- <section class="py-12 bg-white overflow-hidden">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-black text-slate-900 uppercase tracking-tight text-center mb-8">#BrandPeduli</h2>
        <div class="relative">
            <div class="flex gap-12 animate-scroll-infinite">
                <div class="flex gap-12 flex-shrink-0">
                    <img src="{{ asset('images/sponsors/logo1.png') }}" alt="Sponsor 1" class="h-16 object-contain">
                    <img src="{{ asset('images/sponsors/logo2.png') }}" alt="Sponsor 2" class="h-16 object-contain">
                    <img src="{{ asset('images/sponsors/logo3.png') }}" alt="Sponsor 3" class="h-16 object-contain">
                    <img src="{{ asset('images/sponsors/logo4.png') }}" alt="Sponsor 4" class="h-16 object-contain">
                    <img src="{{ asset('images/sponsors/logo5.png') }}" alt="Sponsor 5" class="h-16 object-contain">
                    <img src="{{ asset('images/sponsors/logo6.png') }}" alt="Sponsor 6" class="h-16 object-contain">
                    <img src="{{ asset('images/sponsors/logo7.png') }}" alt="Sponsor 7" class="h-16 object-contain">
                    <img src="{{ asset('images/sponsors/logo8.png') }}" alt="Sponsor 8" class="h-16 object-contain">
                    <img src="{{ asset('images/sponsors/logo9.png') }}" alt="Sponsor 9" class="h-16 object-contain">
                    <img src="{{ asset('images/sponsors/logo10.png') }}" alt="Sponsor 10" class="h-16 object-contain">
                </div>
                <div class="flex gap-12 flex-shrink-0">
                    <img src="{{ asset('images/sponsors/logo1.png') }}" alt="Sponsor 1" class="h-16 object-contain">
                    <img src="{{ asset('images/sponsors/logo2.png') }}" alt="Sponsor 2" class="h-16 object-contain">
                    <img src="{{ asset('images/sponsors/logo3.png') }}" alt="Sponsor 3" class="h-16 object-contain">
                    <img src="{{ asset('images/sponsors/logo4.png') }}" alt="Sponsor 4" class="h-16 object-contain">
                    <img src="{{ asset('images/sponsors/logo5.png') }}" alt="Sponsor 5" class="h-16 object-contain">
                    <img src="{{ asset('images/sponsors/logo6.png') }}" alt="Sponsor 6" class="h-16 object-contain">
                    <img src="{{ asset('images/sponsors/logo7.png') }}" alt="Sponsor 7" class="h-16 object-contain">
                    <img src="{{ asset('images/sponsors/logo8.png') }}" alt="Sponsor 8" class="h-16 object-contain">
                    <img src="{{ asset('images/sponsors/logo9.png') }}" alt="Sponsor 9" class="h-16 object-contain">
                    <img src="{{ asset('images/sponsors/logo10.png') }}" alt="Sponsor 10" class="h-16 object-contain">
                </div>
                <div class="flex gap-12 flex-shrink-0">
                    <img src="{{ asset('images/sponsors/logo1.png') }}" alt="Sponsor 1" class="h-16 object-contain">
                    <img src="{{ asset('images/sponsors/logo2.png') }}" alt="Sponsor 2" class="h-16 object-contain">
                    <img src="{{ asset('images/sponsors/logo3.png') }}" alt="Sponsor 3" class="h-16 object-contain">
                    <img src="{{ asset('images/sponsors/logo4.png') }}" alt="Sponsor 4" class="h-16 object-contain">
                    <img src="{{ asset('images/sponsors/logo5.png') }}" alt="Sponsor 5" class="h-16 object-contain">
                    <img src="{{ asset('images/sponsors/logo6.png') }}" alt="Sponsor 6" class="h-16 object-contain">
                    <img src="{{ asset('images/sponsors/logo7.png') }}" alt="Sponsor 7" class="h-16 object-contain">
                    <img src="{{ asset('images/sponsors/logo8.png') }}" alt="Sponsor 8" class="h-16 object-contain">
                    <img src="{{ asset('images/sponsors/logo9.png') }}" alt="Sponsor 9" class="h-16 object-contain">
                    <img src="{{ asset('images/sponsors/logo10.png') }}" alt="Sponsor 10" class="h-16 object-contain">
                </div>
            </div>
        </div>
    </div>
</section> -->

@endsection

@push('styles')
<style>
    @keyframes scroll-infinite {
        0% {
            transform: translateX(0);
        }
        100% {
            transform: translateX(-33.333%);
        }
    }

    .animate-scroll-infinite {
        animation: scroll-infinite 10s linear infinite;
    }

    .animate-scroll-infinite:hover {
        animation-play-state: paused;
    }
</style>
@endpush

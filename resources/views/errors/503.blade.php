@extends('layouts.layout', ['title' => '503 - Under Maintenance'])

@section('body')
<div class="min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full">
        <div class="bg-white rounded-3xl shadow-xl p-12 text-center">
            <!-- Illustration -->
            <div class="mb-8 flex justify-center">
                <svg class="w-40 h-40" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <!-- Road -->
                    <path d="M50 180 L100 80 L150 180" fill="#F1F5F9" stroke="#CBD5E1" stroke-width="2"/>
                    <!-- Barrier -->
                    <rect x="85" y="100" width="30" height="50" rx="4" fill="#FEF3C7" stroke="#F59E0B" stroke-width="2"/>
                    <line x1="85" y1="115" x2="115" y2="115" stroke="#F59E0B" stroke-width="2"/>
                    <line x1="85" y1="135" x2="115" y2="135" stroke="#F59E0B" stroke-width="2"/>
                    <!-- Warning Sign -->
                    <circle cx="100" cy="60" r="20" fill="white" stroke="#F59E0B" stroke-width="3"/>
                    <path d="M100 50 L100 65" stroke="#F59E0B" stroke-width="3" stroke-linecap="round"/>
                    <circle cx="100" cy="70" r="2" fill="#F59E0B"/>
                </svg>
            </div>

            <!-- Error Code -->
            <h1 class="text-7xl font-black text-blue-600 mb-4">503</h1>

            <!-- Title -->
            <h2 class="text-xl font-bold text-slate-900 mb-3">System is down for Maintenance</h2>

            <!-- Description -->
            <p class="text-sm text-slate-500 mb-8">
                We promise, we'll be right back!
            </p>

            <!-- Button -->
            <button onclick="window.location.reload()"
                    class="inline-block px-8 py-3 bg-slate-900 hover:bg-slate-800 text-white text-sm font-medium rounded-full transition-all duration-200">
                Check Status
            </button>
        </div>
    </div>
</div>
@endsection

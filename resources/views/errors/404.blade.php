@extends('layouts.layout', ['title' => '404 - Page Not Found'])

@section('body')
<div class="min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full">
        <div class="bg-white rounded-3xl shadow-xl p-12 text-center">
            <!-- Illustration -->
            <div class="mb-8 flex justify-center">
                <svg class="w-40 h-40" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <!-- Document -->
                    <rect x="50" y="30" width="100" height="130" rx="8" fill="#F1F5F9" stroke="#CBD5E1" stroke-width="2"/>
                    <line x1="65" y1="50" x2="100" y2="50" stroke="#CBD5E1" stroke-width="3" stroke-linecap="round"/>
                    <line x1="65" y1="65" x2="135" y2="65" stroke="#CBD5E1" stroke-width="3" stroke-linecap="round"/>
                    <line x1="65" y1="80" x2="135" y2="80" stroke="#CBD5E1" stroke-width="3" stroke-linecap="round"/>
                    <line x1="65" y1="95" x2="120" y2="95" stroke="#CBD5E1" stroke-width="3" stroke-linecap="round"/>
                    <!-- Magnifying Glass -->
                    <circle cx="140" cy="120" r="25" fill="white" stroke="#2563EB" stroke-width="4"/>
                    <circle cx="140" cy="120" r="18" fill="#EFF6FF"/>
                    <line x1="158" y1="138" x2="175" y2="155" stroke="#2563EB" stroke-width="6" stroke-linecap="round"/>
                </svg>
            </div>

            <!-- Error Code -->
            <h1 class="text-7xl font-black text-blue-600 mb-4">404</h1>

            <!-- Title -->
            <h2 class="text-xl font-bold text-slate-900 mb-3">Something went wrong</h2>

            <!-- Description -->
            <p class="text-sm text-slate-500 mb-8">
                Sorry we were unable to find that page
            </p>

            <!-- Button -->
            <a href="{{ route('home') }}"
               class="inline-block px-8 py-3 bg-slate-900 hover:bg-slate-800 text-white text-sm font-medium rounded-full transition-all duration-200">
                Go to Dashboard
            </a>
        </div>
    </div>
</div>
@endsection

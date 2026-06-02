@extends('layouts.layout', ['title' => '500 - Server Error'])

@section('body')
<div class="min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full">
        <div class="bg-white rounded-3xl shadow-xl p-12 text-center">
            <!-- Illustration -->
            <div class="mb-8 flex justify-center">
                <svg class="w-40 h-40" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <!-- Server Stack -->
                    <rect x="60" y="40" width="80" height="25" rx="4" fill="#FEE2E2" stroke="#EF4444" stroke-width="2"/>
                    <rect x="60" y="75" width="80" height="25" rx="4" fill="#FEE2E2" stroke="#EF4444" stroke-width="2"/>
                    <rect x="60" y="110" width="80" height="25" rx="4" fill="#FEE2E2" stroke="#EF4444" stroke-width="2"/>
                    <!-- Warning Icon -->
                    <circle cx="100" cy="87.5" r="30" fill="white" stroke="#EF4444" stroke-width="3"/>
                    <path d="M100 75 L100 92" stroke="#EF4444" stroke-width="4" stroke-linecap="round"/>
                    <circle cx="100" cy="100" r="2.5" fill="#EF4444"/>
                </svg>
            </div>

            <!-- Error Code -->
            <h1 class="text-7xl font-black text-blue-600 mb-4">500</h1>

            <!-- Title -->
            <h2 class="text-xl font-bold text-slate-900 mb-3">This page isn't working</h2>

            <!-- Description -->
            <p class="text-sm text-slate-500 mb-8">
                We apologise and are fixing the problem. Please try again later.
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

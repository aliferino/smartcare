@extends('layouts.panel', ['title' => 'Account Suspended'])

@section('content')

{{-- Header --}}
<div class="mb-8">
    <h1 class="text-3xl font-bold text-slate-900">Account Suspended</h1>
    <p class="mt-2 text-sm text-slate-500">Your account access has been temporarily restricted</p>
</div>

{{-- Status Card --}}
<div class="p-8 mb-6 bg-white border rounded-xl border-slate-200">
    <div class="flex items-start gap-4 mb-6">
        <div class="flex items-center justify-center w-16 h-16 rounded-full bg-red-100 flex-shrink-0">
            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div class="flex-1">
            <h2 class="text-2xl font-bold text-slate-900">Account Temporarily Suspended</h2>
            <p class="mt-2 text-slate-600">Your account has been suspended by our admin team. During this period, access to certain features is restricted.</p>
        </div>
    </div>

    <div class="p-4 border-l-4 rounded-lg bg-red-50 border-red-500">
        <div class="flex items-center gap-2 mb-2">
            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <h3 class="font-semibold text-red-900">Restricted Features</h3>
        </div>
        <ul class="ml-7 space-y-1 text-sm text-red-800">
            <li>• Cannot create or manage entities</li>
            <li>• Cannot create or manage campaigns</li>
            <li>• Cannot view donations</li>
            <li>• Cannot request withdrawals</li>
        </ul>
    </div>
</div>

{{-- Contact Admin Card --}}
<div class="p-8 bg-white border rounded-xl border-slate-200">
    <div class="flex items-start gap-4 mb-6">
        <div class="flex items-center justify-center w-16 h-16 rounded-full bg-amber-100 flex-shrink-0">
            <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div class="flex-1">
            <h2 class="text-2xl font-bold text-slate-900">Need Help?</h2>
            <p class="mt-2 text-slate-600">If you believe this suspension is a mistake or need clarification, please contact our admin team.</p>
        </div>
    </div>

    <div class="p-4 border-l-4 rounded-lg bg-amber-50 border-amber-500">
        <div class="flex items-center gap-2 mb-3">
            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <h3 class="font-semibold text-amber-900">Contact Information</h3>
        </div>
        <div class="space-y-2 text-sm text-amber-800">
            <p>Our admin team is available to assist you with any questions or concerns regarding your account suspension.</p>
            <div class="pt-3">
                <a href="{{ route('fundraiser.chats.index') }}" class="inline-flex items-center gap-2 px-6 py-3 font-semibold text-white transition-all bg-blue-600 rounded-lg hover:bg-blue-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    <span>Chat with Admin</span>
                </a>
            </div>
        </div>
    </div>

    {{-- Additional Info --}}
    <div class="pt-6 mt-6 border-t border-slate-200">
        <div class="flex items-start gap-3">
            <svg class="w-5 h-5 mt-0.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div class="text-sm text-slate-600">
                <p class="font-medium text-slate-900">Response Time</p>
                <p class="mt-1">Our admin team typically responds within 1-2 business days. For urgent matters, please mention it in your message.</p>
            </div>
        </div>
    </div>
</div>

@endsection

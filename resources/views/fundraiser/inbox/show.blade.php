@extends('layouts.panel', ['title' => $broadcast->title])

@section('content')
<div class="mb-6">
        <div>
            <h1 class="text-3xl font-black text-slate-900 uppercase tracking-tight">{{ $broadcast->title }}</h1>
        </div>
        <a href="{{ route('fundraiser.inbox.index') }}" class="px-6 py-2.5 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-xl font-bold transition-colors flex items-center gap-2">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Back to Inbox
        </a>
    </div>

    <!-- Message Content -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 max-w-4xl">
        <!-- Meta Info -->
        <div class="flex items-center gap-6 pb-6 mb-6 border-b border-slate-100">
            <div class="flex items-center gap-2 text-sm text-slate-600">
                <i data-lucide="user" class="w-4 h-4"></i>
                <span class="font-bold">From:</span>
                <span>{{ $broadcast->user->name }}</span>
            </div>
            <div class="flex items-center gap-2 text-sm text-slate-600">
                <i data-lucide="calendar" class="w-4 h-4"></i>
                <span class="font-bold">Sent:</span>
                <span>{{ $broadcast->sent_at->format('d M Y, H:i') }}</span>
            </div>
        </div>

        <!-- Message Body -->
        <div class="prose max-w-none">
            <p class="text-slate-700 whitespace-pre-wrap leading-relaxed">{{ $broadcast->message }}</p>
        </div>
    </div>
@endsection

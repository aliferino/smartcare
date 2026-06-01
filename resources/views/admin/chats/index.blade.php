@extends('layouts.panel', ['title' => 'Chats'])

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-black text-slate-900 uppercase">Chats</h1>
    <p class="text-slate-500 text-xs font-medium uppercase tracking-widest opacity-70">Chat with fundraisers</p>
</div>

    <!-- Chat List -->
    <div class="grid grid-cols-1 gap-4 max-w-4xl">
        @forelse($users as $user)
        <a href="{{ route('admin.chats.show', $user->id) }}" class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 hover:shadow-lg transition-all">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center text-white font-black text-lg">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div class="flex-1">
                    <div class="flex items-center justify-between mb-1">
                        <h3 class="font-black text-slate-900">{{ $user->name }}</h3>
                        @if($user->unread_count > 0)
                        <span class="px-2 py-1 bg-blue-600 text-white text-xs font-bold rounded-full">
                            {{ $user->unread_count }} new
                        </span>
                        @endif
                    </div>
                    <p class="text-sm text-slate-500">{{ $user->email }}</p>
                    @if($user->last_message)
                    <p class="text-sm text-slate-600 mt-2">
                        <span class="font-bold">{{ $user->last_message->sender_id == auth()->id() ? 'You' : $user->name }}:</span>
                        {{ Str::limit($user->last_message->message, 50) }}
                    </p>
                    <p class="text-xs text-slate-400 mt-1">{{ $user->last_message->created_at->diffForHumans() }}</p>
                    @endif
                </div>
                <i data-lucide="chevron-right" class="w-5 h-5 text-slate-400"></i>
            </div>
        </a>
        @empty
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-12 text-center">
            <i data-lucide="message-circle" class="w-16 h-16 text-slate-300 mx-auto mb-4"></i>
            <p class="text-lg font-bold text-slate-400">No conversations yet</p>
            <p class="text-sm text-slate-500 mt-2">Start chatting with fundraisers</p>
        </div>
        @endforelse
    </div>
@endsection

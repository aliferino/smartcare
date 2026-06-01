@extends('layouts.panel', ['title' => 'Chat with Admin'])

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-black text-slate-900 uppercase">Chat with Admin</h1>
    <p class="text-slate-500 text-xs font-medium uppercase tracking-widest opacity-70">Get support from our team</p>
</div>

    <!-- Chat Container -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden" style="height: calc(100vh - 180px);">
        <!-- Messages -->
        <div id="messagesContainer" class="p-6 overflow-y-auto" style="height: calc(100% - 80px);">
            @forelse($messages as $message)
            <div class="mb-4 flex {{ $message->sender_id == auth()->id() ? 'justify-end' : 'justify-start' }}">
                <div class="max-w-[70%]">
                    <div class="flex items-center gap-2 mb-1 {{ $message->sender_id == auth()->id() ? 'justify-end' : 'justify-start' }}">
                        <span class="text-xs font-bold text-slate-500">
                            {{ $message->sender_id == auth()->id() ? 'You' : $message->sender->name }}
                        </span>
                        <span class="text-xs text-slate-400">{{ $message->created_at->format('H:i') }}</span>
                    </div>
                    <div class="px-4 py-3 rounded-2xl {{ $message->sender_id == auth()->id() ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-900' }}">
                        <p class="text-sm whitespace-pre-wrap">{{ $message->message }}</p>
                    </div>
                </div>
            </div>
            @empty
            <div class="flex items-center justify-center h-full">
                <div class="text-center">
                    <i data-lucide="message-circle" class="w-16 h-16 text-slate-300 mx-auto mb-4"></i>
                    <p class="text-lg font-bold text-slate-400">No messages yet</p>
                    <p class="text-sm text-slate-500 mt-2">Start a conversation with admin</p>
                </div>
            </div>
            @endforelse
        </div>

        <!-- Message Form -->
        <div class="border-t border-slate-100 p-3">
            <form method="POST" action="{{ route('fundraiser.chats.store') }}" class="flex gap-2">
                @csrf
                <textarea name="message" rows="1" required
                    class="flex-1 px-3 py-2 text-sm rounded-xl border-2 border-slate-200 focus:border-blue-600 outline-none transition-all resize-none"
                    placeholder="Type your message..."></textarea>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-xl font-bold transition-colors flex items-center gap-2">
                    <i data-lucide="send" class="w-4 h-4"></i>
                    Send
                </button>
            </form>
        </div>
    </div>

<script>
// Auto-scroll to bottom on page load
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('messagesContainer');
    if (container) {
        container.scrollTop = container.scrollHeight;
    }
});
</script>
@endsection

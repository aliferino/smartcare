@extends('layouts.panel', ['title' => 'Broadcasts'])

@section('content')
<div class="mb-6">
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-black text-slate-900 uppercase">Broadcasts</h1>
                <p class="text-slate-500 text-xs font-medium uppercase tracking-widest opacity-70">Send announcements to all fundraisers</p>
            </div>
            <button onclick="openBroadcastModal()" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold transition-colors flex items-center gap-2">
                <i data-lucide="plus" class="w-4 h-4"></i>
                New Broadcast
            </button>
        </div>
    </div>

    <!-- Search -->
    <div class="mb-6">
    <div class="mb-6">
        <div class="relative">
            <input type="text" id="searchInput"
                placeholder="Type to search broadcasts and press Enter..."
                class="w-full pl-11 pr-4 py-3.5 bg-white border border-slate-100 rounded-2xl text-xs font-black uppercase focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all shadow-sm placeholder:text-slate-400 placeholder:font-bold">
            <div class="absolute left-4 top-4 text-slate-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div id="table-container" class="bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden">
        <table class="w-full">
            <thead class="bg-blue-600 text-white">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-wider">Title</th>
                    <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-wider">Message</th>
                    <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-wider">Sent By</th>
                    <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-wider">Sent At</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($broadcasts as $broadcast)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4 font-bold text-slate-900">{{ $broadcast->title }}</td>
                    <td class="px-6 py-4 text-slate-600">{{ Str::limit($broadcast->message, 100) }}</td>
                    <td class="px-6 py-4">
                        <div class="font-bold text-slate-900">{{ $broadcast->user->name }}</div>
                        <div class="text-xs text-slate-500">{{ $broadcast->user->email }}</div>
                    </td>
                    <td class="px-6 py-4 text-slate-600 text-sm">{{ $broadcast->sent_at ? $broadcast->sent_at->format('d M Y, H:i') : 'Not sent' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center">
                        <i data-lucide="inbox" class="w-16 h-16 text-slate-300 mx-auto mb-4"></i>
                        <p class="text-lg font-bold text-slate-400">No broadcasts found</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        @if($broadcasts->hasPages())
        <div class="border-t border-slate-100 px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="text-sm text-slate-500">
                    Showing {{ $broadcasts->firstItem() }} to {{ $broadcasts->lastItem() }} of {{ $broadcasts->total() }} entries
                </div>
                <div>
                    {{ $broadcasts->links() }}
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

@include('admin.broadcasts._modal')
@endsection

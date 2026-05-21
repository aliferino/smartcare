@extends('layouts.panel')

@section('title', 'User Management')

@section('content')
<div class="container-fluid px-4 py-6">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-slate-900 uppercase tracking-tight">User Management</h1>
            <p class="text-sm font-medium text-slate-500 mt-1">Manage and verify user accounts</p>
        </div>
        <button class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-black uppercase tracking-wider transition-all duration-200 shadow-lg shadow-blue-200 hover:shadow-xl hover:shadow-blue-300 flex items-center gap-2">
            <i data-lucide="user-plus" class="w-4 h-4"></i>
            Create User
        </button>
    </div>

    <div class="mb-6 bg-white rounded-2xl shadow-sm border border-slate-100 p-4">
        <form method="GET" action="{{ route('admin.users.index') }}" class="flex gap-3">
            <div class="flex-1 relative">
                <i data-lucide="search" class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search by name or email..."
                    class="w-full pl-12 pr-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all"
                >
            </div>
            <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-black uppercase tracking-wider transition-all duration-200 shadow-sm hover:shadow-md">
                Search
            </button>
            @if(request('search'))
                <a href="{{ route('admin.users.index') }}" class="px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-sm font-black uppercase tracking-wider transition-all duration-200">
                    Clear
                </a>
            @endif
        </form>
    </div>

    @include('admin.users._table')
</div>

@include('admin.users._modal')
@endsection

@extends('layouts.panel', ['title' => 'Fundraiser Dashboard'])

@section('content')
{{-- Header Section --}}
<div class="mb-10 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-black text-slate-900 uppercase tracking-tight">Fundraiser Overview</h1>
        <p class="text-slate-500 text-xs font-medium uppercase opacity-70">Monitor your entities and campaign performance.</p>
    </div>
    <div class="hidden md:block">
        <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Last Updated: {{ now()->format('d M Y, H:i') }}</span>
    </div>
</div>

{{-- Stats Grid --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
    
    {{-- Total Donations --}}
    <div class="bg-white p-6 rounded-[2.5rem] border border-slate-100 shadow-sm relative overflow-hidden group">
        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Funds Raised</p>
        <h3 class="text-xl font-black text-blue-600">Rp {{ number_format($stats['total_raised'] ?? 0, 0, ',', '.') }}</h3>
        <div class="mt-4 flex items-center gap-2">
            <span class="px-2 py-0.5 bg-blue-50 text-blue-600 text-[9px] font-black rounded-lg border border-blue-100 uppercase italic">Gross Revenue</span>
        </div>
        <div class="absolute -bottom-2 -right-2 opacity-[0.03] group-hover:opacity-[0.07] transition-opacity">
            <i data-lucide="hand-coins" class="w-16 h-16 text-slate-900 -rotate-12"></i>
        </div>
    </div>

    {{-- Entities Stats --}}
    <div class="bg-white p-6 rounded-[2.5rem] border border-slate-100 shadow-sm relative overflow-hidden group">
        <div class="flex justify-between items-start mb-1">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Your Entities</p>
            @if(($stats['pending_entities_count'] ?? 0) > 0)
                <div class="flex items-center gap-1.5 px-2 py-1 bg-amber-50 border border-amber-100 rounded-lg animate-pulse">
                    <span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span>
                    <span class="text-[9px] font-black text-amber-600 uppercase">{{ $stats['pending_entities_count'] }} Pending</span>
                </div>
            @endif
        </div>
        <h3 class="text-xl font-black text-slate-900">{{ $stats['total_entities'] ?? 0 }}</h3>
        <div class="mt-4 flex items-center gap-2">
            <span class="px-2 py-0.5 bg-slate-50 text-slate-600 text-[9px] font-black rounded-lg border border-slate-100 uppercase italic">Registered Org</span>
        </div>
        <div class="absolute -bottom-2 -right-2 opacity-[0.03] group-hover:opacity-[0.07] transition-opacity">
            <i data-lucide="building-2" class="w-16 h-16 text-slate-900 -rotate-12"></i>
        </div>
    </div>

    {{-- Campaigns Stats --}}
    <div class="bg-white p-6 rounded-[2.5rem] border border-slate-100 shadow-sm relative overflow-hidden group">
        <div class="flex justify-between items-start mb-1">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Active Campaigns</p>
            @if(($stats['pending_campaigns_count'] ?? 0) > 0)
                <div class="flex items-center gap-1.5 px-2 py-1 bg-amber-50 border border-amber-100 rounded-lg animate-pulse">
                    <span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span>
                    <span class="text-[9px] font-black text-amber-600 uppercase">{{ $stats['pending_campaigns_count'] }} Pending</span>
                </div>
            @endif
        </div>
        <h3 class="text-xl font-black text-slate-900">{{ $stats['total_campaigns'] ?? 0 }}</h3>
        <div class="mt-4 flex items-center gap-2">
            <span class="px-2 py-0.5 bg-emerald-50 text-emerald-600 text-[9px] font-black rounded-lg border border-emerald-100 uppercase italic">Live Now</span>
        </div>
        <div class="absolute -bottom-2 -right-2 opacity-[0.03] group-hover:opacity-[0.07] transition-opacity">
            <i data-lucide="megaphone" class="w-16 h-16 text-slate-900 -rotate-12"></i>
        </div>
    </div>

    {{-- Withdrawal --}}
    <div class="bg-white p-6 rounded-[2.5rem] border border-slate-100 shadow-sm relative overflow-hidden group">
        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Balance Available</p>
        <h3 class="text-xl font-black text-slate-900">Rp {{ number_format($stats['balance'] ?? 0, 0, ',', '.') }}</h3>
        <div class="mt-4 flex items-center gap-2">
            <a href="#" class="px-2 py-0.5 bg-rose-50 text-rose-600 text-[9px] font-black rounded-lg border border-rose-100 uppercase hover:bg-rose-600 hover:text-white transition-colors">
                Withdraw Now →
            </a>
        </div>
        <div class="absolute -bottom-2 -right-2 opacity-[0.03] group-hover:opacity-[0.07] transition-opacity">
            <i data-lucide="wallet" class="w-16 h-16 text-slate-900 -rotate-12"></i>
        </div>
    </div>
</div>

{{-- Recent Activities --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    {{-- Latest Donations Table --}}
    <div class="lg:col-span-2 bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-8 py-6 border-b border-slate-50 flex justify-between items-center">
            <h4 class="text-xs font-black text-slate-900 uppercase tracking-[0.2em]">Recent Donations</h4>
            <a href="#" class="text-[10px] font-black text-blue-600 uppercase hover:underline">View All</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <tbody class="divide-y divide-slate-50">
                    @forelse($recent_donations ?? [] as $donation)
                    <tr class="group hover:bg-slate-50/50 transition-colors">
                        <td class="px-8 py-4">
                            <div class="flex flex-col">
                                <span class="text-[11px] font-black text-slate-900 uppercase tracking-tight">{{ $donation->is_anonymous ? 'Anonymous' : $donation->name }}</span>
                                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">{{ $donation->campaign->title }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-4 text-right">
                            <span class="text-[11px] font-black text-emerald-600">+Rp {{ number_format($donation->amount, 0, ',', '.') }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td class="px-8 py-12 text-center">
                            <p class="text-[10px] font-bold text-slate-400 uppercase italic">No recent donations yet.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Quick Actions / System Status --}}
    <div class="space-y-6">
        <div class="bg-blue-600 p-8 rounded-[2.5rem] text-white shadow-xl shadow-blue-100 relative overflow-hidden">
            <div class="relative z-10">
                <i data-lucide="shield-check" class="w-8 h-8 mb-4 opacity-50"></i>
                <h4 class="text-sm font-black uppercase tracking-widest mb-2">Fundraiser Status</h4>
                <p class="text-xs font-medium text-blue-100 leading-relaxed">Pastikan semua dokumen entitas kamu sudah lengkap untuk mempercepat proses verifikasi admin.</p>
                
                <div class="mt-6 pt-6 border-t border-blue-500/30 flex justify-between items-center text-[10px] font-black uppercase">
                    <span>KYC Verification</span>
                    <span class="flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full"></span>
                        Verified
                    </span>
                </div>
            </div>
            {{-- Decor --}}
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-blue-500 rounded-full opacity-20"></div>
        </div>
    </div>
</div>
@endsection
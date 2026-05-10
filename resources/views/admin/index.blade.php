@extends('layouts.panel', ['title' => 'Dashboard'])

@section('content')
{{-- Header --}}
<div class="mb-10">
    <h1 class="text-2xl font-black text-slate-900 uppercase tracking-tight">System Analytics</h1>
    <p class="text-slate-500 text-xs font-medium uppercase opacity-70">Real-time overview of SmartCare ecosystem.</p>
</div>

{{-- Stats Grid --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
    {{-- Total Funds --}}
    <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Funds Collected</p>
        <h3 class="text-xl font-black text-blue-600">Rp {{ number_format($stats['total_donation_amount'], 0, ',', '.') }}</h3>
        <div class="mt-4 flex items-center gap-2">
            <span class="px-2 py-0.5 bg-emerald-50 text-emerald-600 text-[9px] font-black rounded-lg border border-emerald-100 uppercase">Verified</span>
        </div>
    </div>

    {{-- Entities --}}
    <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Entities</p>
        <h3 class="text-xl font-black text-slate-900">{{ $stats['total_entities'] }}</h3>
        <div class="mt-4 flex items-center gap-2">
            <span class="text-[9px] font-bold text-amber-600 uppercase">{{ $stats['pending_entities'] }} Pending Approval</span>
        </div>
    </div>

    {{-- Campaigns --}}
    <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Campaigns</p>
        <h3 class="text-xl font-black text-slate-900">{{ $stats['total_campaigns'] }}</h3>
        <div class="mt-4 flex items-center gap-2">
            <span class="text-[9px] font-bold text-amber-600 uppercase">{{ $stats['pending_campaigns'] }} Pending Approval</span>
        </div>
    </div>


    {{-- Donors --}}
    <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Contributions</p>
        <h3 class="text-xl font-black text-slate-900">{{ number_format($stats['total_donors'], 0, ',', '.') }}</h3>
        <p class="mt-4 text-[9px] font-bold text-slate-400 uppercase">Donations Processed</p>
    </div>
</div>

{{-- Recent Activity Table --}}
<div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
    <div class="px-8 py-6 border-b border-slate-50 flex justify-between items-center bg-slate-50/30">
        <h3 class="text-xs font-black text-slate-900 uppercase tracking-widest">Recent Donations</h3>
        <a href="{{ route('admin.donations.index') }}" class="text-[10px] font-black text-blue-600 uppercase hover:underline">View All</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <tbody class="divide-y divide-slate-50">
                @forelse($recentDonations as $donation)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-8 py-4">
                        <div class="flex flex-col">
                            <span class="text-[11px] font-black text-slate-900 uppercase tracking-tight">{{ $donation->is_anonymous ? 'Anonymous' : $donation->name }}</span>
                            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-tighter">{{ $donation->campaign->title }}</span>
                        </div>
                    </td>
                    <td class="px-8 py-4 text-right">
                        <span class="text-[11px] font-black text-emerald-600 tracking-tight">+Rp {{ number_format($donation->amount, 0, ',', '.') }}</span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td class="px-8 py-10 text-center text-[10px] font-bold text-slate-400 uppercase italic">No activity recorded</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
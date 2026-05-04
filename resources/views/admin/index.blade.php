@extends('layouts.panel')

@section('content')
    {{-- Header Dashboard --}}
    <div class="flex justify-between items-center mb-10">
        <div>
            <h1 class="text-2xl font-medium text-slate-800 tracking-tight">Dashboard Overview</h1>
            <p class="text-slate-400 mt-1 text-sm font-light">Selamat datang kembali di panel kendali SmartCare.</p>
        </div>
        <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-xl text-sm font-medium shadow-sm shadow-blue-100 transition-all active:scale-95 cta-letter-spacing">
            EXPORT REPORT
        </button>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        {{-- Total Donasi --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-blue-50/50 hover:border-blue-100 transition-colors">
            <p class="text-[10px] font-medium text-slate-400 uppercase tracking-widest">Total Donasi</p>
            <h3 class="text-xl font-medium text-blue-600 mt-1">Rp 1.250.000.000</h3>
            <div class="flex items-center mt-3 text-[10px] font-medium text-emerald-600 bg-emerald-50 w-fit px-2 py-0.5 rounded-lg">
                ↑ 12% dari bulan lalu
            </div>
        </div>
        
        {{-- Campaign Aktif --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-blue-50/50 hover:border-blue-100 transition-colors">
            <p class="text-[10px] font-medium text-slate-400 uppercase tracking-widest">Campaign Aktif</p>
            <h3 class="text-xl font-medium text-slate-800 mt-1">142</h3>
            <div class="flex items-center mt-3 text-[10px] font-medium text-blue-600 bg-blue-50 w-fit px-2 py-0.5 rounded-lg">
                8 butuh verifikasi
            </div>
        </div>

        {{-- Total Entities --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-blue-50/50 hover:border-blue-100 transition-colors">
            <p class="text-[10px] font-medium text-slate-400 uppercase tracking-widest">Total Entities</p>
            <h3 class="text-xl font-medium text-slate-800 mt-1">56</h3>
            <div class="flex items-center mt-3 text-[10px] font-medium text-slate-400 bg-slate-50 w-fit px-2 py-0.5 rounded-lg">
                Yayasan & Individu
            </div>
        </div>

        {{-- Donatur Baru --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-blue-50/50 hover:border-blue-100 transition-colors">
            <p class="text-[10px] font-medium text-slate-400 uppercase tracking-widest">Donatur Baru</p>
            <h3 class="text-xl font-medium text-slate-800 mt-1">1.024</h3>
            <div class="flex items-center mt-3 text-[10px] font-medium text-emerald-600 bg-emerald-50 w-fit px-2 py-0.5 rounded-lg">
                Minggu ini
            </div>
        </div>
    </div>

    {{-- Empty State --}}
    <div class="bg-white p-12 rounded-3xl border border-dashed border-blue-100 flex flex-col items-center justify-center text-center">
        <div class="w-16 h-16 bg-blue-50 rounded-full flex items-center justify-center mb-6">
            <svg class="w-8 h-8 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
            </svg>
        </div>
        <h2 class="text-lg font-medium text-slate-800">Belum ada aktivitas campaign</h2>
        <p class="text-slate-400 mt-2 max-w-xs mx-auto text-sm font-light leading-relaxed">
            Segera verifikasi entitas penggalang dana agar mereka bisa mulai beraksi.
        </p>
        <a href="#" class="mt-8 text-sm font-medium text-blue-600 hover:text-blue-800 transition-colors">
            Lihat Permohonan Verifikasi Entities →
        </a>
    </div>
@endsection
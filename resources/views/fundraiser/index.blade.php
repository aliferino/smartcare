@extends('layouts.layout')

@section('content')
<div class="flex justify-between items-center mb-10">
    <div>
        <h1 class="text-3xl font-medium text-gray-900 uppercase">Markas Fundraiser 🚀</h1>[cite: 7]
        <p class="text-gray-500">Pantau performa kampanye dan kontribusi sosial Anda di sini.</p>[cite: 7]
    </div>
    <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100">
        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Total Balance</p>[cite: 7]
        <p class="text-2xl font-medium text-emerald-600">Rp 25.000.000</p>[cite: 7]
    </div>
</div>

{{-- Stats Cards --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
    <div class="bg-white p-6 rounded-[2rem] border border-gray-100 shadow-sm">
        <div class="w-12 h-12 bg-rose-100 text-rose-600 rounded-xl flex items-center justify-center mb-4">
            <i class="fas fa-fire text-xl"></i>[cite: 7]
        </div>
        <p class="text-gray-500 text-sm font-bold">Campaign Aktif</p>[cite: 7]
        <h3 class="text-4xl font-medium text-gray-900">12</h3>[cite: 7]
    </div>

    <div class="bg-white p-6 rounded-[2rem] border border-gray-100 shadow-sm">
        <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center mb-4">
            <i class="fas fa-wallet text-xl"></i>[cite: 7]
        </div>
        <p class="text-gray-500 text-sm font-bold">Siap Withdraw</p>[cite: 7]
        <h3 class="text-4xl font-medium text-gray-900">Rp 10.5M</h3>[cite: 5, 7]
    </div>

    <div class="bg-white p-6 rounded-[2rem] border border-gray-100 shadow-sm">
        <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center mb-4">
            <i class="fas fa-check-double text-xl"></i>[cite: 7]
        </div>
        <p class="text-gray-500 text-sm font-bold">Sudah Cair</p>[cite: 7]
        <h3 class="text-4xl font-medium text-gray-900">Rp 14.5M</h3>[cite: 5, 7]
    </div>
</div>

{{-- Table Section --}}
<div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-sm overflow-hidden">
    <div class="p-8 border-b border-gray-50 flex justify-between items-center">
        <h2 class="text-xl font-medium text-gray-900">Performa Entitas & Campaign</h2>[cite: 7]
        <button class="text-sm font-bold text-rose-600 hover:underline">Lihat Semua</button>[cite: 7]
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-gray-50/50">
                    <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Entitas</th>[cite: 7]
                    <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Campaign Terkini</th>[cite: 7]
                    <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest text-center">Donasi</th>[cite: 7]
                    <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest text-right">Status</th>[cite: 7]
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-8 py-6">
                        <p class="font-medium text-gray-900 text-sm">Yayasan Berbagi Kasih</p>[cite: 7]
                        <p class="text-xs text-gray-400 font-normal">Social & Humanity</p>[cite: 7]
                    </td>
                    <td class="px-8 py-6">
                        <p class="text-sm font-normal text-gray-700">Bantu Korban Banjir Bandang</p>[cite: 7]
                    </td>
                    <td class="px-8 py-6 text-center">
                        <span class="px-4 py-2 bg-emerald-50 text-emerald-700 rounded-full text-xs font-bold">Rp 150.200.000</span>[cite: 7]
                    </td>
                    <td class="px-8 py-6 text-right text-xs font-bold text-rose-500 uppercase tracking-tighter">
                        Active[cite: 7]
                    </td>
                </tr>
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-8 py-6">
                        <p class="font-medium text-gray-900 text-sm">Panti Asuhan Mentari</p>[cite: 7]
                        <p class="text-xs text-gray-400 font-normal">Education</p>[cite: 7]
                    </td>
                    <td class="px-8 py-6">
                        <p class="text-sm font-normal text-gray-700">Renovasi Atap Sekolah</p>[cite: 7]
                    </td>
                    <td class="px-8 py-6 text-center">
                        <span class="px-4 py-2 bg-emerald-50 text-emerald-700 rounded-full text-xs font-bold">Rp 45.000.000</span>[cite: 7]
                    </td>
                    <td class="px-8 py-6 text-right text-xs font-bold text-gray-400 uppercase tracking-tighter">
                        Paused[cite: 7]
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
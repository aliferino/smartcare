<aside class="flex flex-col w-64 h-screen px-6 py-8 overflow-y-auto bg-white border-r border-sky-50 shadow-[20px_0_40px_rgba(15,23,42,0.02)]">
    <a href="{{ route('fundraiser.profile') }}" class="flex items-center gap-4 px-3 mb-12 group transition-all duration-500">
        <div class="relative">
            <div class="absolute -inset-1 bg-gradient-to-tr from-sky-400 to-cyan-300 rounded-full blur opacity-25 group-hover:opacity-50 transition duration-500"></div>
            <img class="relative object-cover w-14 h-14 rounded-2xl ring-2 ring-white shadow-md group-hover:scale-105 transition-all duration-300" 
                src="{{ Auth::user()->citizen?->profile_picture ? asset('storage/' . Auth::user()->citizen->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=0ea5e9&color=fff' }}" 
                alt="avatar">
            <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-emerald-500 border-2 border-white rounded-full shadow-sm"></div>
        </div>
        <div class="flex flex-col overflow-hidden">
            <h4 class="text-sm font-extrabold text-[#0c4a6e] truncate tracking-tight group-hover:text-sky-600 transition-colors">{{ Auth::user()->name }}</h4>
            <div class="flex items-center gap-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-sky-400"></span>
                <span class="text-[10px] text-sky-50 font-black uppercase tracking-[0.1em]">{{ Auth::user()->role }}</span>
            </div>
        </div>
    </a>

    <div class="flex flex-col justify-between flex-1">
        <nav class="space-y-3">
            <p class="px-4 mb-4 text-[10px] font-black text-sky-900/30 uppercase tracking-[0.25em]">Menu Utama</p>

            @php
                $isVerified = Auth::user()->citizen && Auth::user()->citizen->status == 'approved';
            @endphp

            <a href="{{ route('fundraiser.index') }}" 
               class="flex items-center px-4 py-3 transition-all duration-300 group rounded-2xl {{ Request::is('fundraiser/dashboard*') ? 'bg-sky-500 text-white shadow-lg shadow-sky-200' : 'text-slate-400 hover:bg-sky-50 hover:text-sky-600' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                <span class="ml-3.5 text-sm font-bold tracking-tight">Dashboard</span>
            </a>

            <a href="{{ $isVerified ? route('fundraiser.entities.index') : route('fundraiser.kyc.form') }}" 
               class="flex items-center px-4 py-3 transition-all duration-300 group rounded-2xl {{ Request::is('fundraiser/entities*') ? 'bg-sky-500 text-white shadow-lg shadow-sky-200' : 'text-slate-400 hover:bg-sky-50 hover:text-sky-600' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                <span class="ml-3.5 text-sm font-bold tracking-tight">Entities</span>
            </a>

            <a href="{{ $isVerified ? route('fundraiser.campaigns.index') : route('fundraiser.kyc.form') }}" 
               class="flex items-center px-4 py-3 transition-all duration-300 group rounded-2xl {{ Request::is('fundraiser/campaigns*') ? 'bg-sky-500 text-white shadow-lg shadow-sky-200' : 'text-slate-400 hover:bg-sky-50 hover:text-sky-600' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                <span class="ml-3.5 text-sm font-bold tracking-tight">Campaigns</span>
            </a>

            <a href="{{ route('fundraiser.donations') }}" 
               class="flex items-center px-4 py-3 transition-all duration-300 group rounded-2xl {{ Request::is('fundraiser/donations*') ? 'bg-sky-500 text-white shadow-lg shadow-sky-200' : 'text-slate-400 hover:bg-sky-50 hover:text-sky-600' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                <span class="ml-3.5 text-sm font-bold tracking-tight">Donations</span>
            </a>

            <a href="{{ $isVerified ? route('fundraiser.withdraw') : route('fundraiser.kyc.form') }}" 
               class="flex items-center px-4 py-3 transition-all duration-300 group rounded-2xl {{ Request::is('fundraiser/withdraw*') ? 'bg-sky-500 text-white shadow-lg shadow-sky-200' : 'text-slate-400 hover:bg-sky-50 hover:text-sky-600' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                <span class="ml-3.5 text-sm font-bold tracking-tight">Withdraw</span>
            </a>
        </nav>

        <div class="pt-4 mt-6 border-t border-slate-50">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center w-full px-4 py-3 text-slate-400 transition-all duration-200 group rounded-xl hover:bg-red-50 hover:text-red-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    <span class="ml-3 text-[14px] font-medium tracking-tight">Sign Out</span>
                </button>
            </form>
        </div>
    </div>
</aside>
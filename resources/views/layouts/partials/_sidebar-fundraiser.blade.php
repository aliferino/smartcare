<aside class="flex flex-col w-52 h-screen px-4 py-4 overflow-y-auto bg-white border-r border-slate-100 shadow-[20px_0_40px_rgba(0,0,0,0.02)] no-scrollbar flex-shrink-0">
    
    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        .simple-vertical-line {
            position: relative;
            margin-left: 1.15rem;
            border-left: 1.5px solid #f1f5f9;
            padding-left: 0.7rem;
            margin-top: 0.25rem;
            margin-bottom: 0.5rem;
        }

        .nav-link-active {
            background-color: #2563eb !important;
            color: white !important;
        }

        .nav-link-active i, .nav-link-active svg {
            color: white !important;
        }

        .nav-link-hover:hover {
            background-color: #eff6ff !important;
            color: #2563eb !important;
        }

        .nav-link-hover:hover i, .nav-link-hover:hover svg {
            color: #2563eb !important;
        }

        .dropdown-item-style {
            display: block;
            padding: 0.4rem 0.8rem;
            font-size: 12.5px;
            font-weight: 500;
            border-radius: 0.5rem;
            transition: all 0.2s;
            margin-bottom: 4px;
        }

        .lucide {
            width: 18px;
            height: 18px;
            stroke-width: 2px;
        }
    </style>

    {{-- Profile Section --}}
    <a href="{{ route('fundraiser.profile') }}" class="flex flex-col px-2 py-2 mb-5 rounded-xl transition-all duration-200 hover:bg-blue-50 cursor-pointer">
        <div class="flex items-center gap-3 mb-2">
            <div class="relative">
                @if(Auth::user()->citizen?->profile_picture)
                    <img class="relative object-cover w-11 h-11 rounded-2xl ring-2 ring-blue-50 shadow-sm"
                         src="{{ asset('storage/' . Auth::user()->citizen->profile_picture) }}" alt="avatar">
                @else
                    {{-- Fallback Inisial Nama --}}
                    <div class="flex items-center justify-center w-11 h-11 text-white shadow-sm rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-700 ring-2 ring-blue-50 font-bold text-[15px]">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                @endif

                {{-- Dot Indicator Status --}}
                <div class="absolute -bottom-1 -right-1 w-3.5 h-3.5 border-2 border-white rounded-full
                    {{ Auth::user()->status === 'active' ? 'bg-emerald-500' :
                    (Auth::user()->status === 'inactive' ? 'bg-slate-400' :
                    (Auth::user()->status === 'suspended' ? 'bg-amber-500' : 'bg-red-500')) }}">
                </div>
            </div>
            <div class="flex flex-col overflow-hidden">
                <h4 class="text-[13px] font-bold text-slate-900 truncate tracking-tight">{{ Auth::user()->name }}</h4>
                <span class="text-[9px] text-slate-400 font-semibold uppercase tracking-widest">{{ Auth::user()->role }}</span>
            </div>
        </div>

        {{-- Badge Status Akun --}}
        @if(Auth::user()->status !== 'active')
            <div class="px-3 py-1.5 rounded-lg border {{Auth::user()->status === 'inactive' ? 'bg-slate-50 border-slate-100 text-slate-500' : (Auth::user()->status === 'suspended' ? 'bg-amber-50 border-amber-100 text-amber-700' : 'bg-red-50 border-red-100 text-red-700') }} flex items-center gap-2">
                <i data-lucide="{{ Auth::user()->status === 'inactive' ? 'clock' : (Auth::user()->status === 'suspended' ? 'alert-circle' : 'shield-alert') }}" class="w-3 h-3"></i>
                <span class="text-[10px] font-bold uppercase tracking-wider">{{ Auth::user()->status }}</span>
            </div>
        @endif
    </a>

    <div class="flex flex-col justify-between flex-1">
        <nav class="space-y-1" x-data="{
            openMenu: '{{ Request::is('fundraiser/inbox*') || Request::is('fundraiser/chats*') ? 'notification' : 'none' }}'
        }">
            
            <p class="px-3 mb-4 text-[10px] font-medium text-slate-300 uppercase tracking-[0.2em]">Main Menu</p>

            {{-- Dashboard --}}
            <a href="{{ route('fundraiser.index') }}" class="flex items-center px-3 py-2 mb-2 transition-all duration-200 rounded-xl nav-link-hover {{ Request::is('fundraiser/dashboard') ? 'nav-link-active' : 'text-slate-500' }}">
                <i data-lucide="bar-chart-3"></i>
                <span class="ml-3 text-[14px] font-medium tracking-tight">Dashboard</span>
            </a>

            {{-- Entities --}}
            <a href="{{ route('fundraiser.entities.index') }}" class="flex items-center px-3 py-2 transition-all duration-200 rounded-xl nav-link-hover {{ Request::is('fundraiser/entities*') ? 'nav-link-active' : 'text-slate-500' }}">
                <i data-lucide="building-2"></i>
                <span class="ml-3 text-[14px] font-medium tracking-tight">Entities</span>
            </a>

            {{-- Campaigns --}}
            <a href="{{ route('fundraiser.campaigns.index') }}" class="flex items-center px-3 py-2 transition-all duration-200 rounded-xl nav-link-hover {{ Request::is('fundraiser/campaigns*') ? 'nav-link-active' : 'text-slate-500' }}">
                <i data-lucide="layout-list"></i>
                <span class="ml-3 text-[14px] font-medium tracking-tight">Campaigns</span>
            </a>

            {{-- Donations --}}
            <a href="{{ route('fundraiser.donations') }}" class="flex items-center px-3 py-2 transition-all duration-200 rounded-xl nav-link-hover {{ Request::is('fundraiser/donations*') ? 'nav-link-active' : 'text-slate-500' }}">
                <i data-lucide="heart-handshake"></i>
                <span class="ml-3 text-[14px] font-medium tracking-tight">Donations</span>
            </a>

            {{-- Withdrawals --}}
            <a href="#" class="flex items-center px-3 py-2 transition-all duration-200 rounded-xl nav-link-hover {{ Request::is('fundraiser/withdraw*') ? 'nav-link-active' : 'text-slate-500' }}">
                <i data-lucide="banknote"></i>
                <span class="ml-3 text-[14px] font-medium tracking-tight">Withdrawals</span>
            </a>

            {{-- Notifications --}}
            <div class="space-y-1">
                <button type="button" @click="openMenu = (openMenu === 'notification' ? 'none' : 'notification')"
                        class="flex items-center justify-between w-full px-3 py-2 transition-all duration-200 rounded-xl nav-link-hover {{ Request::is('fundraiser/inbox*') || Request::is('fundraiser/chats*') ? 'nav-link-active' : 'text-slate-500' }}">
                    <div class="flex items-center">
                        <i data-lucide="bell"></i>
                        <span class="ml-3 text-[14px] font-medium tracking-tight">Notifications</span>
                    </div>
                    <i data-lucide="chevron-down" class="w-3 h-3 transition-transform" :class="openMenu === 'notification' ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="openMenu === 'notification'" x-cloak x-collapse class="simple-vertical-line">
                    <a href="{{ route('fundraiser.inbox.index') }}" class="dropdown-item-style {{ Request::is('fundraiser/inbox*') ? 'nav-link-active' : 'text-slate-400 nav-link-hover font-normal' }}">Inbox</a>
                    <a href="{{ route('fundraiser.chats.index') }}" class="dropdown-item-style {{ Request::is('fundraiser/chats*') ? 'nav-link-active' : 'text-slate-400 nav-link-hover font-normal' }}">Chat</a>
                </div>
            </div>

        </nav>

        {{-- Sign Out --}}
        <div class="pt-4 mt-6 border-t border-slate-50">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center w-full px-4 py-2 text-slate-400 transition-all duration-200 group rounded-xl hover:bg-red-50 hover:text-red-600">
                    <i data-lucide="log-out"></i>
                    <span class="ml-3 text-[14px] font-medium tracking-tight">Sign Out</span>
                </button>
            </form>
        </div>
    </div>

</aside>
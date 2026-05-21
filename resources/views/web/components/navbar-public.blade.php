<nav class="w-full bg-sky-500">
    <div class="max-w-7xl mx-auto flex items-center justify-between px-6 py-4">
        
        <div class="flex items-center space-x-3">
            <span class="text-2xl font-bold text-white tracking-tight">SmartCare</span>
        </div>

        <div class="hidden md:flex items-center space-x-12">
            <a href="/" class="text-sm font-bold uppercase tracking-widest text-white hover:text-emerald-100 transition-colors">home</a>
            <a href="#" class="text-sm font-bold uppercase tracking-widest text-white hover:text-emerald-100 transition-colors">donations</a>
            
            {{-- Link Fundraiser: Langsung ke dashboard jika sudah login, ke login jika belum --}}
            <a href="{{ Auth::check() && Auth::user()->role === 'fundraiser' ? route('fundraiser.index') : route('login') }}" 
               class="text-sm font-bold uppercase tracking-widest text-white hover:text-emerald-100 transition-colors">
                fundraiser
            </a>
        </div>

        <div>
            @guest
                {{-- Belum login? Tampilkan tombol Sign In standar --}}
                <a href="{{ route('login') }}" class="bg-white text-sky-500 hover:bg-sky-50 px-8 py-2.5 rounded-lg text-sm font-black uppercase transition-all shadow-md">
                    Sign in
                </a>
            @endguest

            @auth
                @if(Request::is('admin/*') || Request::is('fundraiser/*'))
                    {{-- Tombol Logout HANYA muncul jika sedang berada di halaman dashboard masing-masing --}}
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-500 text-white hover:bg-red-600 px-6 py-2 rounded-lg text-sm font-bold uppercase transition-all shadow-md">
                            Logout ({{ Auth::user()->role }})
                        </button>
                    </form>
                @else
                    {{-- Di halaman Public, tombol tetap tulisan "Sign In" tapi fungsinya pintar --}}
                    <a href="{{ Auth::user()->role === 'admin' ? route('admin.index') : route('fundraiser.index') }}" 
                       class="bg-white text-sky-500 hover:bg-sky-50 px-8 py-2.5 rounded-lg text-sm font-black uppercase transition-all shadow-md">
                        Sign in
                    </a>
                @endif
            @endauth
        </div>
    </div>
</nav>
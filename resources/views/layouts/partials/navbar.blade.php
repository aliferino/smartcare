<!-- Navbar -->
<nav class="bg-white shadow-sm sticky top-0 z-50">
    <div class="container mx-auto px-4 py-4">
        <div class="flex items-center gap-3">
            <a href="/" class="flex items-center gap-2">
                <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                    <i data-lucide="heart" class="w-6 h-6 text-white"></i>
                </div>
                <span class="text-xl font-black text-slate-900 uppercase tracking-tight">SmartCare</span>
            </a>

            <div class="flex-1 max-w-xl mx-4">
                <form action="/campaigns" method="GET" class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search campaigns..." class="w-full pl-10 pr-4 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                    <button type="submit" class="absolute left-3 top-2.5 text-slate-400 hover:text-blue-600 transition-colors">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </button>
                </form>
            </div>

            <div class="hidden md:flex items-center gap-2">
                <a href="/" class="text-sm font-bold {{ request()->is('/') ? 'text-blue-600 border-b-2 border-blue-600' : 'text-slate-600 hover:text-blue-600' }} px-4 py-2 transition-colors">Home</a>
                <a href="/campaigns" class="text-sm font-bold {{ request()->is('campaigns*') ? 'text-blue-600 border-b-2 border-blue-600' : 'text-slate-600 hover:text-blue-600' }} px-4 py-2 transition-colors">Campaign</a>
            </div>

            <div class="flex items-center gap-3 ml-4">
                <a href="/login" class="px-4 py-2 text-sm font-bold text-slate-700 hover:text-blue-600 transition-all">Login</a>
                <a href="/register" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-bold transition-all shadow-sm hover:shadow-md">Register</a>
            </div>
        </div>
    </div>
</nav>

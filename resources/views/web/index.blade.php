<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartCare - Platform Donasi & Penggalangan Dana</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-slate-50">

    <!-- Navbar -->
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                        <i data-lucide="heart" class="w-6 h-6 text-white"></i>
                    </div>
                    <span class="text-xl font-black text-slate-900 uppercase tracking-tight">SmartCare</span>
                </div>
                <div class="hidden md:flex items-center gap-6">
                    <a href="#campaigns" class="text-sm font-bold text-slate-600 hover:text-blue-600 transition-colors">Campaigns</a>
                    <a href="#about" class="text-sm font-bold text-slate-600 hover:text-blue-600 transition-colors">About</a>
                    <a href="#contact" class="text-sm font-bold text-slate-600 hover:text-blue-600 transition-colors">Contact</a>
                </div>
                <div class="flex items-center gap-3">
                    <a href="/login" class="px-4 py-2 text-sm font-bold text-slate-600 hover:text-blue-600 transition-colors">Login</a>
                    <a href="/register" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-bold transition-colors">Sign Up</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-blue-600 to-blue-800 text-white py-20">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto text-center">
                <h1 class="text-5xl font-black uppercase tracking-tight mb-6">Make a Difference Today</h1>
                <p class="text-xl font-medium text-blue-100 mb-8">Join thousands of people helping those in need. Every donation counts.</p>
                <div class="flex gap-4 justify-center">
                    <a href="#campaigns" class="px-8 py-4 bg-white text-blue-600 rounded-xl text-sm font-black uppercase tracking-wider hover:bg-blue-50 transition-colors shadow-lg">
                        Browse Campaigns
                    </a>
                    <a href="/register" class="px-8 py-4 bg-blue-500 text-white rounded-xl text-sm font-black uppercase tracking-wider hover:bg-blue-400 transition-colors">
                        Start Campaign
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-12 bg-white">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <div>
                    <div class="text-4xl font-black text-blue-600 mb-2">{{ $stats['total_campaigns'] ?? 0 }}</div>
                    <div class="text-sm font-bold text-slate-500 uppercase tracking-wider">Active Campaigns</div>
                </div>
                <div>
                    <div class="text-4xl font-black text-blue-600 mb-2">Rp {{ number_format($stats['total_raised'] ?? 0, 0, ',', '.') }}</div>
                    <div class="text-sm font-bold text-slate-500 uppercase tracking-wider">Total Raised</div>
                </div>
                <div>
                    <div class="text-4xl font-black text-blue-600 mb-2">{{ $stats['total_donors'] ?? 0 }}</div>
                    <div class="text-sm font-bold text-slate-500 uppercase tracking-wider">Total Donors</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Urgent Campaigns -->
    @if(isset($urgentCampaigns) && $urgentCampaigns->count() > 0)
    <section class="py-16 bg-rose-50">
        <div class="container mx-auto px-4">
            <div class="flex items-center gap-3 mb-8">
                <i data-lucide="alert-circle" class="w-6 h-6 text-rose-600"></i>
                <h2 class="text-3xl font-black text-slate-900 uppercase tracking-tight">Urgent Campaigns</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($urgentCampaigns as $campaign)
                <div class="bg-white rounded-2xl shadow-sm border border-rose-100 overflow-hidden hover:shadow-lg transition-shadow">
                    <div class="relative h-48 bg-slate-200">
                        @if($campaign->primaryImage)
                            <img src="{{ asset('storage/' . $campaign->primaryImage->image_path) }}" alt="{{ $campaign->title }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <i data-lucide="image" class="w-12 h-12 text-slate-400"></i>
                            </div>
                        @endif
                        <div class="absolute top-3 right-3">
                            <span class="px-3 py-1 bg-rose-600 text-white text-xs font-black uppercase tracking-wider rounded-full">Urgent</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-lg font-black text-slate-900 uppercase tracking-tight mb-2 line-clamp-2">{{ $campaign->title }}</h3>
                        <p class="text-sm text-slate-600 mb-4 line-clamp-2">{{ Str::limit($campaign->description, 100) }}</p>

                        <div class="mb-4">
                            <div class="flex justify-between text-xs font-bold text-slate-500 mb-2">
                                <span>Rp {{ number_format($campaign->current_amount, 0, ',', '.') }}</span>
                                <span>{{ $campaign->progress_percentage }}%</span>
                            </div>
                            <div class="w-full bg-slate-200 rounded-full h-2">
                                <div class="bg-rose-600 h-2 rounded-full transition-all" style="width: {{ min($campaign->progress_percentage, 100) }}%"></div>
                            </div>
                            <div class="text-xs font-bold text-slate-400 mt-1">Goal: Rp {{ number_format($campaign->goal_amount, 0, ',', '.') }}</div>
                        </div>

                        <div class="flex items-center justify-between pt-4 border-t border-slate-100">
                            <div class="flex items-center gap-2 text-xs font-bold text-slate-500">
                                <i data-lucide="users" class="w-4 h-4"></i>
                                <span>{{ $campaign->donors_count }} Donors</span>
                            </div>
                            <a href="/campaigns/{{ $campaign->slug }}" class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-xs font-black uppercase tracking-wider transition-colors">
                                Donate Now
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- All Campaigns -->
    <section id="campaigns" class="py-16">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-3xl font-black text-slate-900 uppercase tracking-tight">All Campaigns</h2>
                <div class="flex gap-2">
                    <select class="px-4 py-2 border border-slate-200 rounded-lg text-sm font-bold focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="">All Categories</option>
                        @foreach($categories ?? [] as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($campaigns ?? [] as $campaign)
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-lg transition-shadow">
                    <div class="relative h-48 bg-slate-200">
                        @if($campaign->primaryImage)
                            <img src="{{ asset('storage/' . $campaign->primaryImage->image_path) }}" alt="{{ $campaign->title }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <i data-lucide="image" class="w-12 h-12 text-slate-400"></i>
                            </div>
                        @endif
                        <div class="absolute top-3 left-3">
                            <span class="px-3 py-1 bg-blue-600 text-white text-xs font-black uppercase tracking-wider rounded-full">{{ $campaign->campaignCategory->name ?? 'General' }}</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-lg font-black text-slate-900 uppercase tracking-tight mb-2 line-clamp-2">{{ $campaign->title }}</h3>
                        <p class="text-sm text-slate-600 mb-4 line-clamp-2">{{ Str::limit($campaign->description, 100) }}</p>

                        <div class="mb-4">
                            <div class="flex justify-between text-xs font-bold text-slate-500 mb-2">
                                <span>Rp {{ number_format($campaign->current_amount, 0, ',', '.') }}</span>
                                <span>{{ $campaign->progress_percentage }}%</span>
                            </div>
                            <div class="w-full bg-slate-200 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full transition-all" style="width: {{ min($campaign->progress_percentage, 100) }}%"></div>
                            </div>
                            <div class="text-xs font-bold text-slate-400 mt-1">Goal: Rp {{ number_format($campaign->goal_amount, 0, ',', '.') }}</div>
                        </div>

                        <div class="flex items-center justify-between pt-4 border-t border-slate-100">
                            <div class="flex items-center gap-2 text-xs font-bold text-slate-500">
                                <i data-lucide="users" class="w-4 h-4"></i>
                                <span>{{ $campaign->donors_count }} Donors</span>
                            </div>
                            <a href="/campaigns/{{ $campaign->slug }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-black uppercase tracking-wider transition-colors">
                                Donate Now
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-12">
                    <i data-lucide="inbox" class="w-16 h-16 text-slate-300 mx-auto mb-4"></i>
                    <p class="text-lg font-bold text-slate-400">No campaigns available at the moment</p>
                </div>
                @endforelse
            </div>

            @if(isset($campaigns) && $campaigns->hasPages())
            <div class="mt-8">
                {{ $campaigns->links() }}
            </div>
            @endif
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-900 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                            <i data-lucide="heart" class="w-6 h-6 text-white"></i>
                        </div>
                        <span class="text-xl font-black uppercase tracking-tight">SmartCare</span>
                    </div>
                    <p class="text-sm text-slate-400">Making a difference, one donation at a time.</p>
                </div>
                <div>
                    <h4 class="text-sm font-black uppercase tracking-wider mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="#campaigns" class="text-sm text-slate-400 hover:text-white transition-colors">Campaigns</a></li>
                        <li><a href="#about" class="text-sm text-slate-400 hover:text-white transition-colors">About Us</a></li>
                        <li><a href="#contact" class="text-sm text-slate-400 hover:text-white transition-colors">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-sm font-black uppercase tracking-wider mb-4">Support</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-sm text-slate-400 hover:text-white transition-colors">Help Center</a></li>
                        <li><a href="#" class="text-sm text-slate-400 hover:text-white transition-colors">Terms of Service</a></li>
                        <li><a href="#" class="text-sm text-slate-400 hover:text-white transition-colors">Privacy Policy</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-sm font-black uppercase tracking-wider mb-4">Connect</h4>
                    <div class="flex gap-3">
                        <a href="#" class="w-10 h-10 bg-slate-800 hover:bg-blue-600 rounded-lg flex items-center justify-center transition-colors">
                            <i data-lucide="facebook" class="w-5 h-5"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-slate-800 hover:bg-blue-600 rounded-lg flex items-center justify-center transition-colors">
                            <i data-lucide="twitter" class="w-5 h-5"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-slate-800 hover:bg-blue-600 rounded-lg flex items-center justify-center transition-colors">
                            <i data-lucide="instagram" class="w-5 h-5"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="border-t border-slate-800 mt-8 pt-8 text-center">
                <p class="text-sm text-slate-400">&copy; 2026 SmartCare. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        lucide.createIcons();
    </script>

</body>
</html>

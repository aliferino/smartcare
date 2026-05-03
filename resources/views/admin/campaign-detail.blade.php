<x-layout-admin>
    <x-slot:title>Detail: {{ $campaign->title }}</x-slot:title>

    <div class="flex items-center gap-4 mb-8">
        <a href="{{ url()->previous() }}" class="p-3 bg-white border border-gray-100 rounded-2xl hover:bg-gray-50 transition-all">
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </a>
        <h1 class="text-2xl font-black text-gray-900">Detail Campaign</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white p-4 rounded-[2.5rem] border border-gray-100 shadow-sm">
                <img src="{{ asset('storage/' . $campaign->image) }}" class="w-full aspect-square object-cover rounded-[2rem] shadow-inner mb-6">
                
                <div class="px-2">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Current Status</p>
                    <span class="inline-block px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-tighter
                        {{ $campaign->status == 'approved' ? 'bg-emerald-100 text-emerald-600' : ($campaign->status == 'rejected' ? 'bg-rose-100 text-rose-600' : 'bg-amber-100 text-amber-600') }}">
                        {{ $campaign->status }}
                    </span>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white p-8 rounded-[2.5rem] border border-gray-100 shadow-sm">
                <div class="mb-8">
                    <span class="text-xs font-bold text-indigo-600 bg-indigo-50 px-3 py-1 rounded-lg uppercase tracking-wider">
                        {{ $campaign->category->name ?? 'No Category' }}
                    </span>
                    <h2 class="text-3xl font-black text-gray-900 mt-4 leading-tight">{{ $campaign->title }}</h2>
                    <p class="text-gray-500 mt-2 font-medium">Fundraiser: <span class="text-gray-900 font-bold">{{ $campaign->user?->name ?? 'Unknown User' }}</span></p>
                </div>

                <div class="bg-gray-50 p-6 rounded-3xl mb-8">
                    <div class="flex justify-between items-end mb-3">
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Terkumpul</p>
                            <p class="text-xl font-black text-emerald-600">Rp {{ number_format($campaign->current_amount) }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Target</p>
                            <p class="text-sm font-bold text-gray-900">Rp {{ number_format($campaign->goal_amount) }}</p>
                        </div>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        <div class="bg-indigo-600 h-3 rounded-full transition-all duration-1000" style="width: {{ min($percentage, 100) }}%"></div>
                    </div>
                    <p class="text-right mt-2 text-xs font-black text-indigo-600">{{ number_format($percentage, 1) }}% Tercapai</p>
                </div>

                <div class="prose prose-sm max-w-none text-gray-600 leading-relaxed">
                    <p class="text-[10px] font-black text-gray-300 uppercase tracking-widest mb-2">Cerita Campaign</p>
                    {!! nl2br(e($campaign->description)) !!}
                </div>
            </div>

            @if($campaign->status == 'pending')
            <div class="flex gap-4">
                <form action="{{ route('admin.campaigns.approve', $campaign->id) }}" method="POST" class="flex-1">
                    @csrf @method('PATCH')
                    <button class="w-full bg-emerald-500 text-white py-4 rounded-2xl font-black shadow-lg shadow-emerald-100 hover:scale-[1.02] transition-all">Approve Campaign</button>
                </form>
                <button onclick="document.getElementById('reject-modal').classList.remove('hidden')" class="flex-1 bg-white border-2 border-gray-100 text-gray-400 py-4 rounded-2xl font-black hover:bg-rose-50 hover:text-rose-500 hover:border-rose-100 transition-all">Reject Campaign</button>
            </div>
            @endif
        </div>
    </div>
</x-layout-admin>
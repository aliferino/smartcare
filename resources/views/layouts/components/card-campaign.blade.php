@php
    $progressColor = $isUrgent ?? false ? 'bg-rose-600' : 'bg-blue-600';
    $buttonColor = $isUrgent ?? false ? 'bg-rose-600 hover:bg-rose-700' : 'bg-blue-600 hover:bg-blue-700';
    $borderColor = $isUrgent ?? false ? 'border-rose-100' : 'border-slate-100';
@endphp

<div class="bg-white rounded-2xl shadow-sm border {{ $borderColor }} overflow-hidden hover:shadow-lg transition-shadow">
    <div class="relative h-48 bg-slate-200">
        @if($campaign->primaryImage)
            <img src="{{ asset('storage/' . $campaign->primaryImage->image_path) }}" alt="{{ $campaign->title }}" class="w-full h-full object-cover">
        @else
            <div class="w-full h-full flex items-center justify-center">
                <i data-lucide="image" class="w-12 h-12 text-slate-400"></i>
            </div>
        @endif
        <div class="absolute top-3 left-3 flex flex-col gap-2">
            <span class="px-3 py-1 bg-blue-600 text-white text-xs font-black uppercase tracking-wider rounded-full">{{ $campaign->campaignCategory->name ?? 'General' }}</span>
            @if($isUrgent ?? false)
            <span class="px-3 py-1 bg-rose-600 text-white text-xs font-black uppercase tracking-wider rounded-full flex items-center gap-1">
                <i data-lucide="alert-circle" class="w-3 h-3"></i>
                Urgent
            </span>
            @endif
        </div>
    </div>
    <div class="p-6">
        <h3 class="text-lg font-black text-slate-900 uppercase tracking-tight mb-2 line-clamp-2 h-14">{{ $campaign->title }}</h3>
        <p class="text-sm text-slate-600 mb-4 line-clamp-2 h-10">{{ Str::limit($campaign->description, 100) }}</p>

        <div class="mb-4">
            <div class="flex justify-between text-xs font-bold text-slate-500 mb-2">
                <span>Rp {{ number_format($campaign->current_amount, 0, ',', '.') }}</span>
                <span>{{ $campaign->progress_percentage }}%</span>
            </div>
            <div class="w-full bg-slate-200 rounded-full h-2">
                <div class="{{ $progressColor }} h-2 rounded-full transition-all" style="width: {{ min($campaign->progress_percentage, 100) }}%"></div>
            </div>
            <div class="text-xs font-bold text-slate-400 mt-1">Goal: Rp {{ number_format($campaign->goal_amount, 0, ',', '.') }}</div>
        </div>

        <div class="flex items-end justify-between pt-4 border-t border-slate-100">
            <div class="flex items-center gap-2 text-xs font-bold text-slate-500">
                <i data-lucide="users" class="w-4 h-4"></i>
                <span>{{ $campaign->donors_count }} Donors</span>
            </div>
            <a href="/campaigns/{{ $campaign->slug }}" class="px-4 py-2 {{ $buttonColor }} text-white rounded-lg text-xs font-black uppercase tracking-wider transition-colors">
                Donate Now
            </a>
        </div>
    </div>
</div>

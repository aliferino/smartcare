@props(['image' => null, 'title' => '', 'category' => '', 'collected' => 0, 'target' => 0, 'donationUrl' => '#'])

@php
    $percentage = ($target > 0) ? min(100, round(($collected / $target) * 100)) : 0;
@endphp

<div class="bg-white rounded-xl shadow-md overflow-hidden w-full max-w-sm">
    <div class="relative">
        <img src="{{ $image ? asset('storage/' . $image) : asset('images/placeholder.jpg') }}" class="w-full h-48 object-cover" />
        <span class="absolute bottom-3 left-3 bg-white/90 text-gray-700 text-xs font-bold px-3 py-1 rounded-full uppercase">
            {{ $category }}
        </span>
    </div>

    <div class="p-4 space-y-4">
        <h3 class="font-bold text-gray-900 text-lg leading-tight line-clamp-2">{{ $title }}</h3>
        
        <div class="space-y-2">
            <div class="w-full bg-gray-200 rounded-full h-2.5">
                <div class="bg-yellow-500 h-2.5 rounded-full" style="width: {{ $percentage }}%"></div>
            </div>
            <div class="flex justify-between text-sm">
                <span class="font-bold text-blue-600">Rp {{ number_format($collected, 0, ',', '.') }}</span>
                <span class="text-gray-500 text-xs">Target: Rp {{ number_format($target, 0, ',', '.') }}</span>
            </div>
        </div>

        <a href="{{ $donationUrl }}" class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg transition">
            Donate Now
        </a>
    </div>
</div>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation List - Fundraiser</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="flex">
        <x-sidebar-fundraiser />
        <main class="flex-1 p-10">
            <h1 class="text-2xl font-black text-gray-900 mb-8">Riwayat Donasi</h1>
            <div class="space-y-4">
                @forelse($donations as $donation)
                <div class="bg-white p-6 rounded-3xl border border-gray-100 flex justify-between items-center shadow-sm hover:shadow-md transition-shadow">
                    <div>
                        <p class="text-sm font-black text-gray-900">{{ $donation->name }}</p>
                        <p class="text-xs text-gray-400 italic">"{{ $donation->message ?? 'Tanpa pesan' }}"</p>
                        <p class="text-[10px] text-sky-500 font-bold uppercase mt-2">Campaign: {{ $donation->campaign->title }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-black text-emerald-600">+ Rp {{ number_format($donation->amount, 0, ',', '.') }}</p>
                        <p class="text-[10px] font-bold text-gray-300 uppercase">{{ $donation->status }}</p>
                    </div>
                </div>
                @empty
                <div class="bg-white p-10 rounded-3xl border border-dashed border-gray-200 text-center text-gray-400 italic">
                    Belum ada donasi masuk. Sabar ya.
                </div>
                @endforelse
            </div>
        </main>
    </div>
</body>
</html>
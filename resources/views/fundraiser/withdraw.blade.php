<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Withdraw - Fundraiser</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="flex">
        <x-sidebar-fundraiser />
        <main class="flex-1 p-10 text-gray-900">
            <h1 class="text-2xl font-black mb-8">Riwayat Pencairan Dana</h1>
            <div class="bg-white rounded-3xl border border-gray-100 overflow-hidden shadow-sm">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase text-center">Campaign</th>
                            <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase text-center">Jumlah</th>
                            <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase text-center">Bank</th>
                            <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($withdraws as $withdraw)
                        <tr class="text-center">
                            <td class="px-6 py-4 text-sm font-bold text-gray-700 text-left">{{ $withdraw->campaign->title }}</td>
                            <td class="px-6 py-4 text-sm font-black text-red-500">Rp {{ number_format($withdraw->jumlah, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-xs text-gray-500">{{ $withdraw->nama_bank }} - {{ $withdraw->no_rek }}</td>
                            <td class="px-6 py-4">
                                <span class="text-[10px] px-2 py-1 rounded-full font-black uppercase bg-gray-100 text-gray-600">
                                    {{ $withdraw->status }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-gray-400 text-sm italic">Belum ada riwayat penarikan dana.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>
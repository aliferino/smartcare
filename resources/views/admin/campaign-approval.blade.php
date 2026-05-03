<x-layout-admin>
    <x-slot:title>Persetujuan Campaign</x-slot:title>

    <h1 class="text-2xl font-black text-gray-900 mb-8">Persetujuan Campaign</h1>

    <div class="grid grid-cols-1 gap-4">
        @forelse($pendingCampaigns as $cp)
        <div class="bg-white p-6 rounded-[2rem] border border-gray-100 flex justify-between items-center shadow-sm hover:shadow-md transition-shadow">
            <div class="flex gap-5 items-center">
                <img src="{{ asset('storage/' . $cp->image) }}" class="w-20 h-20 object-cover rounded-2xl bg-gray-100">
                <div>
                    <h3 class="font-black text-gray-900 text-lg">{{ $cp->title }}</h3>
                    <p class="text-xs text-gray-400">Fundraiser: <span class="font-bold text-gray-600">{{ $cp->user->name }}</span> • Target: <span class="text-rose-500 font-bold">Rp {{ number_format($cp->goal_amount) }}</span></p>
                </div>
            </div>
            <div class="flex gap-3">
                <form action="{{ route('admin.campaigns.approve', $cp->id) }}" method="POST">
                    @csrf @method('PATCH')
                    <button class="bg-emerald-500 text-white px-6 py-3 rounded-2xl text-xs font-black shadow-lg shadow-emerald-100 transition-transform hover:scale-105">Approve</button>
                </form>
                <button class="bg-gray-100 text-gray-500 px-6 py-3 rounded-2xl text-xs font-black transition-colors hover:bg-rose-50 hover:text-rose-500">Reject</button>
            </div>
        </div>
        @empty
        <div class="py-20 text-center bg-white rounded-[2rem] border border-dashed border-gray-200">
            <p class="text-gray-400 font-bold">Semua campaign sudah diproses. Admin bisa istirahat.</p>
        </div>
        @endforelse
    </div>
</x-layout-admin>
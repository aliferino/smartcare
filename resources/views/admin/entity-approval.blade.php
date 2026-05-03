<x-layout-admin>
    <x-slot:title>Persetujuan Entitas</x-slot:title>

    <h1 class="text-2xl font-black text-gray-900 mb-8">Persetujuan Entitas</h1>

    <div class="grid grid-cols-1 gap-4">
        @forelse($pendingEntities as $ent)
        <div class="bg-white p-6 rounded-[2rem] border border-gray-100 flex justify-between items-center shadow-sm">
            <div class="flex items-center gap-6">
                <img src="{{ $ent->logo_path ? asset('storage/'.$ent->logo_path) : 'https://ui-avatars.com/api/?name='.$ent->name }}" class="w-20 h-20 object-cover rounded-2xl bg-gray-100">
                <div>
                    <h3 class="font-black text-gray-900 text-lg">{{ $ent->name }}</h3>
                    <p class="text-xs text-gray-400">Kategori: <span class="font-bold text-gray-600">{{ $ent->category->name }}</span> • Email: <span class="text-rose-500 font-bold">{{ $ent->email }}</span></p>
                </div>
            </div>
            </div>
        @empty
        <p class="text-center py-20 text-gray-400 font-bold italic">Tidak ada entitas yang butuh divalidasi.</p>
        @endforelse
    </div>
</x-layout-admin>
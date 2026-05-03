<x-layout-admin>
    <x-slot:title>KYC Approval</x-slot:title>

    <div class="flex items-center justify-between mb-8">
        <h1 class="text-2xl font-black text-gray-900 tracking-tight">Verifikasi Identitas (KYC)</h1>
        <div class="bg-amber-50 text-amber-600 px-4 py-2 rounded-xl border border-amber-100 flex items-center gap-2">
            <span class="text-[10px] font-black uppercase tracking-widest">{{ count($pendingKyc) }} Pending Review</span>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4">
        @forelse($pendingKyc as $kyc)
        <div class="bg-white p-6 rounded-[2.5rem] border border-gray-100 flex justify-between items-center shadow-sm hover:shadow-md transition-all">
            <div class="flex gap-6 items-center">
                <div class="w-16 h-16 rounded-2xl bg-gray-50 border border-gray-100 overflow-hidden">
                    <img src="{{ asset('storage/' . $kyc->id_card_path) }}" class="w-full h-full object-cover grayscale opacity-50">
                </div>
                
                <div>
                    <h3 class="font-black text-gray-900 text-lg leading-tight">{{ $kyc->full_name }}</h3>
                    <p class="text-xs text-gray-400 font-bold uppercase mt-1">
                        NIK: <span class="text-gray-900">{{ $kyc->id_number }}</span>
                    </p>
                </div>
            </div>

            <a href="{{ route('admin.users.kyc.detail', $kyc->id) }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gray-900 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-rose-600 transition-all">
                Review Documents
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
        </div>
        @empty
        <div class="py-20 text-center bg-white rounded-[3rem] border border-dashed border-gray-100">
            <p class="text-gray-400 font-black italic">Antrean kosong. Admin bisa lanjut push rank.</p>
        </div>
        @endforelse
    </div>
</x-layout-admin>
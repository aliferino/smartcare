<x-layout-admin>
    <x-slot:title>Detail Entitas: {{ $entity->name }}</x-slot:title>

    <div class="flex items-center gap-4 mb-8">
        <a href="{{ url()->previous() }}" class="p-3 bg-white border border-gray-100 rounded-2xl hover:bg-gray-50 transition-all">
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </a>
        <h1 class="text-2xl font-black text-gray-900">Detail Verifikasi Entitas</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white p-6 rounded-[2.5rem] border border-gray-100 shadow-sm text-center">
                <img src="{{ $entity->logo_path ? asset('storage/'.$entity->logo_path) : 'https://ui-avatars.com/api/?name='.urlencode($entity->name).'&size=200' }}" 
                     class="w-32 h-32 mx-auto rounded-[2rem] object-cover bg-gray-50 border-4 border-white shadow-md mb-4">
                
                <h2 class="text-xl font-black text-gray-900 leading-tight">{{ $entity->name }}</h2>
                <p class="text-xs font-bold text-gray-400 mt-1 uppercase tracking-widest">{{ $entity->category?->name ?? 'No Category' }}</p>

                <div class="mt-6 pt-6 border-t border-gray-50">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">Status Verifikasi</p>
                    <span class="inline-block px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-tighter
                        {{ $entity->status == 'approved' ? 'bg-emerald-100 text-emerald-600' : ($entity->status == 'rejected' ? 'bg-rose-100 text-rose-600' : 'bg-amber-100 text-amber-600') }}">
                        {{ $entity->status }}
                    </span>
                </div>
            </div>

            <div class="bg-white p-6 rounded-[2.5rem] border border-gray-100 shadow-sm">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4">Legal Document</p>
                <a href="{{ asset('storage/' . $entity->legal_document_path) }}" target="_blank" 
                   class="flex items-center justify-between p-4 bg-gray-50 rounded-2xl border border-dashed border-gray-200 hover:border-indigo-300 hover:bg-indigo-50 transition-all group">
                    <span class="text-xs font-black text-gray-600 group-hover:text-indigo-600">Lihat Dokumen Hukum</span>
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                </a>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white p-8 rounded-[2.5rem] border border-gray-100 shadow-sm">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    <div>
                        <p class="text-[10px] font-black text-gray-300 uppercase tracking-widest mb-1">Email Resmi</p>
                        <p class="text-sm font-bold text-gray-700">{{ $entity->email }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-300 uppercase tracking-widest mb-1">Pemilik Akun</p>
                        <p class="text-sm font-bold text-gray-700">{{ $entity->user?->name ?? 'Unknown' }}</p>
                    </div>
                </div>

                <div class="mb-8">
                    <p class="text-[10px] font-black text-gray-300 uppercase tracking-widest mb-1">Alamat Lengkap</p>
                    <p class="text-sm font-medium text-gray-600 leading-relaxed italic">"{{ $entity->address }}"</p>
                </div>

                @if($entity->status == 'approved')
                <div class="bg-emerald-50 p-6 rounded-3xl border border-emerald-100 flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-black text-emerald-400 uppercase tracking-widest">Disetujui Pada</p>
                        <p class="text-sm font-bold text-emerald-700">{{ $entity->approved_at?->format('d F Y, H:i') }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] font-black text-emerald-400 uppercase tracking-widest">Verifikator</p>
                        <p class="text-sm font-black text-emerald-700">{{ $entity->admin?->name ?? 'System' }}</p>
                    </div>
                </div>
                @endif

                @if($entity->status == 'rejected')
                <div class="bg-rose-50 p-6 rounded-3xl border border-rose-100">
                    <p class="text-[10px] font-black text-rose-400 uppercase tracking-widest mb-2">Alasan Penolakan</p>
                    <p class="text-sm font-bold text-rose-700">{{ $entity->rejection_reason ?? 'Tidak ada alasan spesifik.' }}</p>
                </div>
                @endif
            </div>

            @if($entity->status == 'pending')
            <div class="flex gap-4">
                <form action="{{ route('admin.entities.approve', $entity->id) }}" method="POST" class="flex-1">
                    @csrf @method('PATCH')
                    <button class="w-full bg-emerald-500 text-white py-4 rounded-2xl font-black shadow-lg shadow-emerald-100 hover:scale-[1.02] transition-all">Terima Entitas</button>
                </form>
                <button onclick="document.getElementById('reject-modal').classList.remove('hidden')" class="flex-1 bg-white border-2 border-gray-100 text-gray-400 py-4 rounded-2xl font-black hover:bg-rose-50 hover:text-rose-500 hover:border-rose-100 transition-all">Tolak Entitas</button>
            </div>
            @endif
        </div>
    </div>

    <div id="reject-modal" class="hidden fixed inset-0 bg-gray-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-[2.5rem] w-full max-w-md p-8 shadow-2xl">
            <h3 class="text-xl font-black text-gray-900 mb-2">Kenapa ditolak?</h3>
            <p class="text-xs text-gray-400 mb-6 font-bold">User akan melihat alasan ini untuk perbaikan data.</p>
            
            <form action="{{ route('admin.entities.reject', $entity->id) }}" method="POST">
                @csrf @method('PATCH')
                <textarea name="rejection_reason" rows="4" class="w-full bg-gray-50 border border-gray-100 rounded-2xl p-4 text-sm font-medium focus:ring-2 focus:ring-rose-500 outline-none mb-6" placeholder="Contoh: Dokumen hukum tidak valid atau masa berlaku habis..." required></textarea>
                
                <div class="flex gap-3">
                    <button type="button" onclick="document.getElementById('reject-modal').classList.add('hidden')" class="flex-1 py-3 text-xs font-black text-gray-400">Batal</button>
                    <button type="submit" class="flex-1 bg-rose-500 text-white py-3 rounded-xl text-xs font-black shadow-lg shadow-rose-100">Kirim Penolakan</button>
                </div>
            </form>
        </div>
    </div>
</x-layout-admin>
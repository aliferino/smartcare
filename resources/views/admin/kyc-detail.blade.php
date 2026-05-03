<x-layout-admin>
    <x-slot:title>Review KYC: {{ $citizen->full_name }}</x-slot:title>

    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.users.kyc.verif') }}" class="p-2 bg-white border border-gray-100 rounded-xl hover:bg-gray-900 transition-all text-gray-400 hover:text-white">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <h1 class="text-xl font-black text-gray-900 tracking-tight">Review Verifikasi</h1>
        </div>
        <span class="px-3 py-1 bg-amber-50 text-amber-600 rounded-lg border border-amber-100 text-[10px] font-black uppercase tracking-widest">
            Pending Review
        </span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        <div class="lg:col-span-4 space-y-4">
            @php $docs = [
                ['label' => 'KTP Resmi', 'path' => $citizen->id_card_path],
                ['label' => 'Selfie + KTP', 'path' => $citizen->selfie_path]
            ]; @endphp

            @foreach($docs as $doc)
            <div class="group bg-white p-2 rounded-[2rem] border border-gray-100 shadow-sm transition-all hover:shadow-md">
                <div class="relative overflow-hidden rounded-[1.5rem] bg-gray-50 h-48"> 
                    <img src="{{ asset('storage/' . $doc['path']) }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                    
                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                        <a href="{{ asset('storage/' . $doc['path']) }}" download class="p-2.5 bg-white rounded-xl text-gray-900 hover:bg-rose-500 hover:text-white transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        </a>
                        <button onclick="window.open('{{ asset('storage/' . $doc['path']) }}')" class="p-2.5 bg-white rounded-xl text-gray-900 hover:bg-gray-900 hover:text-white transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>
                        </button>
                    </div>
                </div>
                <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mt-2 ml-2">{{ $doc['label'] }}</p>
            </div>
            @endforeach
        </div>

        <div class="lg:col-span-8">
            <div class="bg-white p-8 rounded-[2.5rem] border border-gray-100 shadow-sm">
                <div class="grid grid-cols-2 gap-x-8 gap-y-6">
                    <div class="col-span-2">
                        <p class="text-[9px] font-black text-gray-300 uppercase tracking-widest mb-1">Nama Lengkap</p>
                        <p class="text-base font-black text-gray-900 uppercase tracking-tight">{{ $citizen->full_name }}</p>
                    </div>

                    <div>
                        <p class="text-[9px] font-black text-gray-300 uppercase tracking-widest mb-1">Nomor NIK</p>
                        <p class="text-sm font-bold text-gray-700 tracking-wider">{{ $citizen->id_number }}</p>
                    </div>

                    <div>
                        <p class="text-[9px] font-black text-gray-300 uppercase tracking-widest mb-1">Nomor Telepon</p>
                        <p class="text-sm font-bold text-gray-700">{{ $citizen->phone_number }}</p>
                    </div>

                    <div>
                        <p class="text-[9px] font-black text-gray-300 uppercase tracking-widest mb-1">Gender</p>
                        <span class="text-[10px] font-black text-rose-500 uppercase px-2 py-0.5 bg-rose-50 rounded-md border border-rose-100 italic">
                            {{ $citizen->gender == 'male' ? 'Laki-laki' : 'Perempuan' }}
                        </span>
                    </div>

                    <div>
                        <p class="text-[9px] font-black text-gray-300 uppercase tracking-widest mb-1">Tanggal Lahir</p>
                        <p class="text-sm font-bold text-gray-700">{{ \Carbon\Carbon::parse($citizen->birth_date)->format('d M Y') }}</p>
                    </div>

                    <div class="col-span-2 p-4 bg-gray-50 rounded-2xl border border-gray-100">
                        <p class="text-[9px] font-black text-gray-300 uppercase tracking-widest mb-1">Domisili Sesuai KTP</p>
                        <p class="text-xs font-bold text-gray-600 leading-relaxed italic">"{{ $citizen->address }}"</p>
                    </div>
                </div>

                @if($citizen->status == 'pending')
                <div class="flex gap-3 mt-8 pt-6 border-t border-gray-50">
                    <button onclick="document.getElementById('modal-reject').classList.remove('hidden')" 
                            class="flex-1 py-3 border-2 border-rose-100 text-rose-500 rounded-xl text-[9px] font-black uppercase tracking-widest hover:bg-rose-500 hover:text-white transition-all">
                        Reject
                    </button>
                    
                    <form action="{{ route('admin.users.kyc.approve', $citizen->id) }}" method="POST" class="flex-[2]">
                        @csrf @method('PATCH')
                        <button type="submit" class="w-full py-3 bg-gray-900 text-white rounded-xl text-[9px] font-black uppercase tracking-widest hover:bg-emerald-500 shadow-md transition-all">
                            Approve Identity
                        </button>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div id="modal-reject" class="hidden fixed inset-0 bg-gray-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-6">
        <div class="bg-white w-full max-w-md rounded-[2.5rem] p-8 shadow-2xl">
            <h3 class="text-lg font-black text-gray-900 mb-2">Alasan Penolakan</h3>
            <p class="text-[10px] text-gray-400 font-bold mb-6 uppercase tracking-wider">Beri tahu user kenapa dokumennya ditolak.</p>
            
            <form action="{{ route('admin.users.kyc.reject', $citizen->id) }}" method="POST">
                @csrf @method('PATCH')
                <textarea name="reason" required rows="4" 
                    class="w-full p-4 bg-gray-50 border border-gray-100 rounded-2xl text-xs font-bold outline-none focus:ring-4 focus:ring-rose-500/10 mb-6" 
                    placeholder="Contoh: Foto KTP tidak terbaca atau NIK tidak sesuai..."></textarea>
                
                <div class="flex gap-3">
                    <button type="button" onclick="document.getElementById('modal-reject').classList.add('hidden')" 
                        class="flex-1 text-[10px] font-black uppercase text-gray-400 tracking-widest">Batal</button>
                    <button type="submit" class="flex-[2] py-3 bg-rose-500 text-white rounded-xl text-[10px] font-black uppercase tracking-widest">Kirim Penolakan</button>
                </div>
            </form>
        </div>
    </div>
</x-layout-admin>
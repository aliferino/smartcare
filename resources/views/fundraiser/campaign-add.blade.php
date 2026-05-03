<x-layout-fundraiser>
    <x-slot:title>Buat Campaign Baru</x-slot:title>

    <div class="max-w-4xl mx-auto">
        <div class="mb-10 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-extrabold text-[#0c4a6e] tracking-tight">Buat Campaign</h1>
                <p class="text-sky-600/70 font-medium mt-1">Sampaikan cerita kebaikan Anda kepada dunia.</p>
            </div>
            <a href="{{ route('fundraiser.campaigns.index') }}" class="px-5 py-2.5 bg-white border border-sky-100 text-[#0c4a6e] rounded-xl text-xs font-bold uppercase tracking-widest hover:bg-sky-50 transition-all">
                Kembali
            </a>
        </div>

        <form action="{{ route('fundraiser.campaigns.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf

            <div class="bg-white p-10 rounded-[2.5rem] border border-sky-100 shadow-xl shadow-sky-900/5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    
                    {{-- Upload Banner Campaign --}}
                    <div class="md:col-span-2">
                        <label class="text-[11px] font-extrabold text-[#0c4a6e]/50 uppercase tracking-[0.2em] ml-2 block mb-3">Banner Campaign</label>
                        <div class="relative group h-64 w-full rounded-[2rem] border-2 border-dashed border-sky-100 hover:border-sky-400 hover:bg-sky-50 transition-all overflow-hidden flex items-center justify-center">
                            <input type="file" name="image" required accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer z-10" onchange="previewBanner(this)">
                            <img id="banner-preview" class="hidden absolute inset-0 w-full h-full object-cover">
                            <div id="banner-placeholder" class="text-center">
                                <svg class="w-12 h-12 text-sky-200 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <p class="text-[10px] font-black text-sky-400 uppercase tracking-widest">Klik untuk upload foto utama</p>
                            </div>
                        </div>
                    </div>

                    {{-- Pilih Lembaga (Entity) --}}
                    <div class="md:col-span-1">
                        <label class="text-[11px] font-extrabold text-[#0c4a6e]/50 uppercase tracking-[0.2em] ml-2">Pilih Lembaga Penanggung Jawab</label>
                        <select name="entity_id" required class="w-full mt-2 px-6 py-4 rounded-2xl bg-slate-50 border border-transparent focus:bg-white focus:border-sky-300 focus:ring-4 focus:ring-sky-100 outline-none transition-all font-bold text-[#0c4a6e] appearance-none cursor-pointer">
                            <option value="" disabled selected>Pilih Lembaga</option>
                            @foreach($entities as $entity)
                                <option value="{{ $entity->id }}" {{ old('entity_id') == $entity->id ? 'selected' : '' }}>{{ $entity->name }}</option>
                            @endforeach
                        </select>
                        <p class="text-[9px] mt-2 ml-2 text-slate-400 font-bold uppercase italic">* Lembaga harus berstatus Terverifikasi</p>
                    </div>

                    {{-- Kategori --}}
                    <div class="md:col-span-1">
                        <label class="text-[11px] font-extrabold text-[#0c4a6e]/50 uppercase tracking-[0.2em] ml-2">Kategori Kebaikan</label>
                        <select name="category" required class="w-full mt-2 px-6 py-4 rounded-2xl bg-slate-50 border border-transparent focus:bg-white focus:border-sky-300 focus:ring-4 focus:ring-sky-100 outline-none transition-all font-bold text-[#0c4a6e] appearance-none cursor-pointer">
                            <option value="health">Kesehatan</option>
                            <option value="education">Pendidikan</option>
                            <option value="disaster">Bencana Alam</option>
                            <option value="social">Sosial & Kemanusiaan</option>
                            <option value="environment">Lingkungan</option>
                        </select>
                    </div>

                    {{-- Judul --}}
                    <div class="md:col-span-2">
                        <label class="text-[11px] font-extrabold text-[#0c4a6e]/50 uppercase tracking-[0.2em] ml-2">Judul Campaign</label>
                        <input type="text" name="title" value="{{ old('title') }}" required placeholder="Contoh: Bantu Renovasi Sekolah Pelosok"
                               class="w-full mt-2 px-6 py-4 rounded-2xl bg-slate-50 border border-transparent focus:bg-white focus:border-sky-300 focus:ring-4 focus:ring-sky-100 outline-none transition-all font-bold text-[#0c4a6e]">
                    </div>

                    {{-- Target Dana --}}
                    <div>
                        <label class="text-[11px] font-extrabold text-[#0c4a6e]/50 uppercase tracking-[0.2em] ml-2">Target Dana (Rp)</label>
                        <input type="number" name="goal_amount" value="{{ old('goal_amount') }}" required placeholder="0"
                               class="w-full mt-2 px-6 py-4 rounded-2xl bg-slate-50 border border-transparent focus:bg-white focus:border-sky-300 focus:ring-4 focus:ring-sky-100 outline-none transition-all font-bold text-[#0c4a6e]">
                    </div>

                    {{-- Tanggal Berakhir --}}
                    <div>
                        <label class="text-[11px] font-extrabold text-[#0c4a6e]/50 uppercase tracking-[0.2em] ml-2">Batas Penggalangan Dana</label>
                        <input type="date" name="end_at" value="{{ old('end_at') }}" required 
                               class="w-full mt-2 px-6 py-4 rounded-2xl bg-slate-50 border border-transparent focus:bg-white focus:border-sky-300 focus:ring-4 focus:ring-sky-100 outline-none transition-all font-bold text-[#0c4a6e]">
                    </div>

                    {{-- Deskripsi --}}
                    <div class="md:col-span-2">
                        <label class="text-[11px] font-extrabold text-[#0c4a6e]/50 uppercase tracking-[0.2em] ml-2">Cerita Lengkap</label>
                        <textarea name="description" rows="6" required placeholder="Tuliskan Deskripsi Campaign Anda Dengan Lengkap Disini..."
                                  class="w-full mt-2 px-6 py-4 rounded-2xl bg-slate-50 border border-transparent focus:bg-white focus:border-sky-300 focus:ring-4 focus:ring-sky-100 outline-none transition-all font-bold text-[#0c4a6e]">{{ old('description') }}</textarea>
                    </div>

                    {{-- Urgency Toggle --}}
                    <div class="md:col-span-2 flex items-center gap-4 p-6 bg-rose-50 rounded-3xl border border-rose-100">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_urgent" value="1" class="sr-only peer">
                            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-rose-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-rose-500"></div>
                        </label>
                        <div>
                            <p class="text-xs font-black text-rose-600 uppercase tracking-widest">Tandai Sebagai Campaign Mendesak</p>
                            <p class="text-[10px] text-rose-400 font-bold uppercase italic">Aktifkan jika membutuhkan penanganan dalam waktu sangat singkat.</p>
                        </div>
                    </div>
                </div>

                <div class="mt-10">
                    <button type="submit" class="w-full bg-gradient-to-r from-[#0c4a6e] to-sky-500 text-white py-5 rounded-[2rem] font-extrabold text-sm uppercase tracking-[0.3em] shadow-xl shadow-sky-500/20 hover:shadow-sky-500/40 transition-all duration-300">
                        Ajukan Campaign Sekarang
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        function previewBanner(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('banner-preview');
                    const placeholder = document.getElementById('banner-placeholder');
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</x-layout-fundraiser>
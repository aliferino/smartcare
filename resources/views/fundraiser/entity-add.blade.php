<x-layout-fundraiser>
    <x-slot:title>Daftarkan Lembaga</x-slot:title>

    <div class="max-w-4xl mx-auto">
        {{-- Header --}}
        <div class="mb-10 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-extrabold text-[#0c4a6e] tracking-tight">Daftarkan Lembaga</h1>
                <p class="text-sky-600/70 font-medium mt-1">Lembaga diperlukan sebagai wadah resmi kampanye Anda.</p>
            </div>
            <a href="{{ route('fundraiser.entities.index') }}" class="px-5 py-2.5 bg-white border border-sky-100 text-[#0c4a6e] rounded-xl text-xs font-bold uppercase tracking-widest hover:bg-sky-50 transition-all flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali
            </a>
        </div>

        <form action="{{ route('fundraiser.entities.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                {{-- Kolom Kiri: Upload Logo --}}
                <div class="lg:col-span-4">
                    <div class="bg-white p-8 rounded-[2.5rem] border border-sky-100 shadow-xl shadow-sky-900/5 text-center">
                        <label class="text-[11px] font-black text-[#0c4a6e]/50 uppercase tracking-[0.2em] block mb-6">Logo Lembaga</label>
                        
                        <div class="relative group mx-auto w-40 h-40">
                            <div class="absolute -inset-2 bg-gradient-to-tr from-sky-400 to-cyan-300 rounded-[3rem] blur opacity-20 group-hover:opacity-40 transition duration-500"></div>
                            <div class="relative w-40 h-40 bg-slate-50 rounded-[2.5rem] border-2 border-dashed border-sky-200 flex items-center justify-center overflow-hidden group-hover:border-sky-400 transition-colors">
                                <img id="logo-preview" class="hidden w-full h-full object-cover">
                                <div id="placeholder-icon" class="text-sky-300 group-hover:text-sky-400 transition-colors text-center p-4">
                                    <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <p class="text-[9px] font-bold uppercase tracking-tighter">Pilih Logo</p>
                                </div>
                                <input type="file" name="logo" class="absolute inset-0 opacity-0 cursor-pointer" accept="image/*" onchange="previewImage(this, 'logo-preview', 'placeholder-icon')" required>
                            </div>
                        </div>
                        @error('logo') <p class="text-red-500 text-[10px] mt-4 font-bold uppercase">{{ $message }}</p> @enderror
                        <p class="mt-6 text-[10px] text-slate-400 font-medium leading-relaxed">Gunakan format JPG/PNG berkualitas tinggi. Maks 1MB.</p>
                    </div>
                </div>

                {{-- Kolom Kanan: Form Detail --}}
                <div class="lg:col-span-8 space-y-6">
                    <div class="bg-white p-10 rounded-[2.5rem] border border-sky-100 shadow-xl shadow-sky-900/5">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            {{-- Nama Lembaga --}}
                            <div class="md:col-span-2">
                                <label class="text-[11px] font-extrabold text-[#0c4a6e]/50 uppercase tracking-[0.2em] ml-2">Nama Resmi Lembaga</label>
                                <input type="text" name="name" value="{{ old('name') }}" placeholder="Contoh: Yayasan Berbagi Kebaikan" required
                                    class="w-full mt-2 px-6 py-4 rounded-2xl bg-slate-50 border border-transparent focus:bg-white focus:border-sky-300 focus:ring-4 focus:ring-sky-100 outline-none transition-all font-bold text-[#0c4a6e] @error('name') border-red-300 @enderror">
                                @error('name') <p class="text-red-500 text-xs mt-1 ml-2 font-bold">{{ $message }}</p> @enderror
                            </div>

                            {{-- Kategori --}}
                            <div class="md:col-span-1">
                                <label class="text-[11px] font-extrabold text-[#0c4a6e]/50 uppercase tracking-[0.2em] ml-2">Kategori</label>
                                <select name="entity_category_id" required
                                    class="w-full mt-2 px-6 py-4 rounded-2xl bg-slate-50 border border-transparent focus:bg-white focus:border-sky-300 focus:ring-4 focus:ring-sky-100 outline-none transition-all font-bold text-[#0c4a6e] appearance-none cursor-pointer">
                                    <option value="" disabled selected>Pilih Kategori</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('entity_category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Email Lembaga --}}
                            <div class="md:col-span-1">
                                <label class="text-[11px] font-extrabold text-[#0c4a6e]/50 uppercase tracking-[0.2em] ml-2">Email Lembaga</label>
                                <input type="email" name="email" value="{{ old('email') }}" placeholder="lembaga@email.com" required
                                    class="w-full mt-2 px-6 py-4 rounded-2xl bg-slate-50 border border-transparent focus:bg-white focus:border-sky-300 focus:ring-4 focus:ring-sky-100 outline-none transition-all font-bold text-[#0c4a6e]">
                            </div>

                            {{-- Alamat --}}
                            <div class="md:col-span-2">
                                <label class="text-[11px] font-extrabold text-[#0c4a6e]/50 uppercase tracking-[0.2em] ml-2">Alamat Kantor</label>
                                <textarea name="address" rows="3" placeholder="Jl. Raya Kebaikan No. 123..." required
                                    class="w-full mt-2 px-6 py-4 rounded-2xl bg-slate-50 border border-transparent focus:bg-white focus:border-sky-300 focus:ring-4 focus:ring-sky-100 outline-none transition-all font-bold text-[#0c4a6e]">{{ old('address') }}</textarea>
                            </div>

                            {{-- Dokumen Legal --}}
                            <div class="md:col-span-2">
                                <div class="p-6 bg-amber-50 rounded-3xl border border-amber-100">
                                    <label class="text-[11px] font-extrabold text-amber-700 uppercase tracking-[0.2em] block mb-3">Dokumen Legalitas (PDF/JPG)</label>
                                    <div class="flex items-center gap-4">
                                        <div class="flex-1 relative">
                                            <input type="file" name="legal_document" id="legal_document" class="hidden" accept=".pdf,image/*" required onchange="updateFileName(this)">
                                            <label for="legal_document" class="flex items-center justify-between px-6 py-4 bg-white rounded-2xl border-2 border-dashed border-amber-200 cursor-pointer hover:border-amber-400 transition-all">
                                                <span id="file-name" class="text-sm font-bold text-amber-600/50 italic">Upload Akta/SK Kemenkumham...</span>
                                                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                            </label>
                                        </div>
                                    </div>
                                    <p class="mt-3 text-[10px] text-amber-600/70 font-medium leading-relaxed">Penting: Dokumen ini digunakan tim Admin untuk proses verifikasi keabsahan lembaga Anda.</p>
                                    @error('legal_document') <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mt-10">
                            <button type="submit" class="w-full bg-gradient-to-r from-[#075985] to-[#0ea5e9] text-white py-5 rounded-[2rem] font-extrabold text-sm uppercase tracking-[0.3em] shadow-xl shadow-sky-500/20 hover:shadow-sky-500/40 hover:-translate-y-1 transition-all duration-300 flex items-center justify-center gap-3">
                                <span>Daftarkan Lembaga Sekarang</span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        function previewImage(input, previewId, iconId) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById(previewId);
                    const icon = document.getElementById(iconId);
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    icon.classList.add('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function updateFileName(input) {
            const fileName = input.files[0].name;
            document.getElementById('file-name').innerText = fileName;
            document.getElementById('file-name').classList.remove('text-amber-600/50');
            document.getElementById('file-name').classList.add('text-amber-700');
        }
    </script>
</x-layout-fundraiser>
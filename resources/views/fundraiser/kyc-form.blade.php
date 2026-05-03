<x-layout-fundraiser>
    <x-slot:title>Identity Verification</x-slot:title>

    <div class="mb-10">
        <h1 class="text-3xl font-black text-gray-900 tracking-tight">Verifikasi Identitas</h1>
        <p class="text-sm text-gray-400 mt-2 font-medium">Pastikan dokumen foto terlihat jelas dan tidak blur agar proses verifikasi lancar.</p>
    </div>

    <form action="{{ route('fundraiser.kyc.submit') }}" method="POST" enctype="multipart/form-data" class="max-w-4xl">
        @csrf
        <div class="bg-white p-10 rounded-[3rem] border border-gray-100 shadow-sm space-y-8">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Nama Lengkap (Sesuai KTP)</label>
                    <input type="text" name="full_name" value="{{ old('full_name') }}" required oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '');"
                           class="w-full mt-2 px-6 py-4 rounded-2xl bg-gray-50 border border-gray-100 focus:bg-white focus:ring-4 focus:ring-sky-500/10 focus:border-sky-500 outline-none transition-all text-sm font-bold text-gray-700">
                </div>
                
                <div>
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">NIK (16 Digit)</label>
                    <input type="text" name="id_number" value="{{ old('id_number') }}" required 
                           maxlength="16" 
                           oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                           class="w-full mt-2 px-6 py-4 rounded-2xl bg-gray-50 border border-gray-100 focus:bg-white focus:ring-4 focus:ring-sky-500/10 focus:border-sky-500 outline-none transition-all text-sm font-bold text-gray-700">
                </div>

                <div>
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Nomor Telepon</label>
                    <input type="text" name="phone_number" value="{{ old('phone_number') }}" required oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                           class="w-full mt-2 px-6 py-4 rounded-2xl bg-gray-50 border border-gray-100 focus:bg-white focus:ring-4 focus:ring-sky-500/10 focus:border-sky-500 outline-none transition-all text-sm font-bold text-gray-700">
                </div>

                <div>
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Tanggal Lahir</label>
                    <input type="date" name="birth_date" value="{{ old('birth_date') }}" required 
                           class="w-full mt-2 px-6 py-4 rounded-2xl bg-gray-50 border border-gray-100 focus:bg-white focus:ring-4 focus:ring-sky-500/10 focus:border-sky-500 outline-none transition-all text-sm font-bold text-gray-700">
                </div>

                <div>
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Jenis Kelamin</label>
                    <select name="gender" required 
                            class="w-full mt-2 px-6 py-4 rounded-2xl bg-gray-50 border border-gray-100 focus:bg-white focus:ring-4 focus:ring-sky-500/10 focus:border-sky-500 outline-none transition-all text-sm font-bold text-gray-700 appearance-none">
                        <option value="male">Laki-laki</option>
                        <option value="female">Perempuan</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Alamat Lengkap Sesuai KTP</label>
                <textarea name="address" required rows="3" 
                          class="w-full mt-2 px-6 py-4 rounded-2xl bg-gray-50 border border-gray-100 focus:bg-white focus:ring-4 focus:ring-sky-500/10 focus:border-sky-500 outline-none transition-all text-sm font-bold text-gray-700">{{ old('address') }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-4">
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Foto KTP</label>
                    <div class="relative group h-56 rounded-[2.5rem] border-2 border-dashed border-gray-200 hover:border-sky-400 hover:bg-sky-50/30 transition-all flex flex-col items-center justify-center overflow-hidden">
                        <input type="file" name="id_card_path" required 
                               accept="image/*"
                               onchange="previewImage(this, 'preview-ktp', 'placeholder-ktp')" 
                               class="absolute inset-0 opacity-0 cursor-pointer z-10">
                        <img id="preview-ktp" class="hidden absolute inset-0 w-full h-full object-cover">
                        <div id="placeholder-ktp" class="text-center">
                            <div class="w-12 h-12 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-3 group-hover:bg-sky-100 group-hover:text-sky-600 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-tighter">Klik untuk Upload KTP</p>
                        </div>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Foto Selfie + KTP</label>
                    <div class="relative group h-56 rounded-[2.5rem] border-2 border-dashed border-gray-200 hover:border-rose-400 hover:bg-rose-50/30 transition-all flex flex-col items-center justify-center overflow-hidden">
                        <input type="file" name="selfie_path" required 
                               accept="image/*"
                               onchange="previewImage(this, 'preview-selfie', 'placeholder-selfie')" 
                               class="absolute inset-0 opacity-0 cursor-pointer z-10">
                        <img id="preview-selfie" class="hidden absolute inset-0 w-full h-full object-cover">
                        <div id="placeholder-selfie" class="text-center">
                            <div class="w-12 h-12 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-3 group-hover:bg-rose-100 group-hover:text-rose-600 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-tighter">Klik untuk Upload Selfie</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="w-full mt-8 bg-gray-900 text-white py-5 rounded-[2rem] font-black text-xs uppercase tracking-[0.2em] shadow-xl hover:bg-sky-600 hover:scale-[1.01] transition-all duration-300">
            Kirim Data Verifikasi
        </button>
    </form>

    <x-slot:scripts>
        <script>
            function previewImage(input, previewId, placeholderId) {
                const preview = document.getElementById(previewId);
                const placeholder = document.getElementById(placeholderId);
                const file = input.files[0];

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.classList.remove('hidden');
                        if (placeholder) placeholder.classList.add('hidden');
                    }
                    reader.readAsDataURL(file);
                } else {
                    preview.src = "";
                    preview.classList.add('hidden');
                    if (placeholder) placeholder.classList.remove('hidden');
                }
            }
        </script>
    </x-slot:scripts>
</x-layout-fundraiser>
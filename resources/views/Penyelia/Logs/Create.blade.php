@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Rekod Log Baru') }}
    </h2>
@endsection

@section('content')
<div class="py-6 px-4 max-w-lg mx-auto pb-24">

    {{-- Info Card --}}
    <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 mb-6 flex gap-3 items-start">
        <svg class="w-5 h-5 text-blue-800 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <div>
            <p class="text-sm text-blue-900 font-medium">Pastikan butiran tepat.</p>
            <p class="text-xs text-blue-700 mt-1">Log aktiviti perlu disahkan oleh pegawai penyelia yang dipilih.</p>
        </div>
    </div>

    {{-- IMPORTANT: Added enctype="multipart/form-data" for file upload support --}}
    <form action="#" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf

        {{-- 1. BALAI BERTUGAS (Read Only) --}}
        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                Balai Tempat Bertugas
            </label>
            <div class="relative">
                <input type="text" 
                       value="{{ Auth::user()->balai ?? 'Balai Polis Pekan' }}" 
                       disabled
                       class="block w-full px-4 py-3 bg-gray-100 border border-gray-200 rounded-xl text-gray-500 text-sm font-medium select-none cursor-not-allowed">
                
                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                    <a href="{{ route('profile.show') }}" class="text-xs text-blue-600 font-bold hover:underline">
                        Tukar?
                    </a>
                </div>
            </div>
            <p class="text-[10px] text-gray-400 mt-1"> *Tetapan ini hanya boleh ditukar di Profil.</p>
        </div>

        {{-- 2. KAWASAN BERTUGAS --}}
        <div>
            <label for="area" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                Kawasan Penugasan
            </label>
            <div class="relative">
                <select id="area" name="area" class="block w-full pl-4 pr-10 py-3 bg-white border border-gray-200 rounded-xl focus:ring-blue-900 focus:border-blue-900 text-sm appearance-none">
                    <option value="" disabled selected>Sila Pilih Kawasan</option>
                    <option value="Pos Pengawal">Pos Pengawal</option>
                    <option value="Kaunter Pertanyaan">Kaunter Pertanyaan / Kaunter Aduan</option>
                    <option value="Bilik penjara">Bilik penjara</option>
                    <option value="Bilik siasatan">Bilik siasatan</option>
                    <option value="Bilik Operasi">Bilik kawalan / bilik operasi</option>
                    <option value="Pejabat">Pejabat pentadbiran</option>
                    <option value="Lain-lain">Lain-lain</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </div>
        </div>

        {{-- 3. JENIS PENUGASAN --}}
        <div>
            <label for="type" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                Jenis Penugasan
            </label>
            <div class="relative">
                <select id="type" name="type" class="block w-full pl-4 pr-10 py-3 bg-white border border-gray-200 rounded-xl focus:ring-blue-900 focus:border-blue-900 text-sm appearance-none">
                    <option value="" disabled selected>Pilih Jenis Tugas</option>
                    <option value="Rondaan MPV">Rondaan MPV</option>
                    <option value="Rondaan URB">Rondaan URB</option>
                    <option value="Bit/Pondok">Bit / Pondok Polis</option>
                    <option value="Tugas Pejabat">Tugas Pejabat</option>
                    <option value="Operasi Khas">Operasi Khas</option>
                    <option value="Latihan">Latihan / Kursus</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </div>
        </div>

        {{-- 4. TARIKH & MASA --}}
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="date" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Tarikh</label>
                <input type="date" id="date" name="date" value="{{ date('Y-m-d') }}"
                       class="block w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-blue-900 focus:border-blue-900 text-sm">
            </div>
            <div>
                <label for="time" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Masa Mula</label>
                <input type="time" id="time" name="time" value="{{ date('H:i') }}"
                       class="block w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-blue-900 focus:border-blue-900 text-sm">
            </div>
        </div>

        {{-- 5. PEGAWAI PENYELIA --}}
        <div>
            <label for="officer_id" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                Pegawai Penyelia (Pengesah)
            </label>
            <div class="relative">
                <select id="officer_id" name="officer_id" class="block w-full pl-4 pr-10 py-3 bg-white border border-gray-200 rounded-xl focus:ring-blue-900 focus:border-blue-900 text-sm appearance-none">
                    <option value="" disabled selected>Pilih Pegawai</option>
                    <option value="1">Insp. Razak (Ketua Balai)</option>
                    <option value="2">Sjn. Mejar Halim (Kenyalang)</option>
                    <option value="3">Asp. Tiong (Pegawai Turus)</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
            </div>
        </div>

        {{-- 6. CATATAN / REMARKS --}}
        <div>
            <label for="remarks" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                Catatan Aktiviti
            </label>
            <textarea id="remarks" name="remarks" rows="4" required
                      placeholder="Masukkan butiran lanjut aktiviti di sini..."
                      class="block w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-blue-900 focus:border-blue-900 text-sm"></textarea>
        </div>

        {{-- 7. GAMBAR SOKONGAN (NEW SECTION) --}}
        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                Gambar Sokongan (Optional)
            </label>
            
            {{-- Dropzone / Input Area --}}
            <div class="w-full">
                <label for="image_upload" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-xl cursor-pointer bg-gray-50 hover:bg-gray-100 transition relative overflow-hidden group">
                    
                    {{-- Default State: Icon & Text --}}
                    <div id="upload-placeholder" class="flex flex-col items-center justify-center pt-5 pb-6">
                        <svg class="w-8 h-8 mb-2 text-gray-400 group-hover:text-blue-900 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <p class="mb-1 text-xs text-gray-500 font-medium">Klik untuk ambil/muat naik gambar</p>
                        <p class="text-[10px] text-gray-400">JPG, PNG (Max 5MB)</p>
                    </div>

                    {{-- Image Preview Container (Hidden initially) --}}
                    <img id="image-preview" class="hidden absolute inset-0 w-full h-full object-cover opacity-90" />
                    
                    {{-- Hidden File Input --}}
                    <input id="image_upload" name="image" type="file" class="hidden" accept="image/*" onchange="previewImage(event)" />
                </label>

                {{-- Remove Button (Visible only when image selected) --}}
                <div id="remove-btn-container" class="hidden mt-2 text-right">
                    <button type="button" onclick="removeImage()" class="text-xs text-red-600 font-bold hover:underline flex items-center justify-end gap-1 ml-auto">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        Padam Gambar
                    </button>
                </div>
            </div>
        </div>

        {{-- SUBMIT BUTTON --}}
        <div class="pt-4">
            <button type="submit" class="w-full flex items-center justify-center gap-2 py-4 px-4 border border-transparent rounded-xl shadow-lg shadow-blue-900/20 text-sm font-bold text-white bg-[#00205B] hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-900 transition-all transform active:scale-[0.98]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Hantar Laporan
            </button>
        </div>

    </form>
</div>

{{-- JAVASCRIPT FOR IMAGE PREVIEW --}}
<script>
    function previewImage(event) {
        const input = event.target;
        const reader = new FileReader();
        
        reader.onload = function(){
            const dataURL = reader.result;
            const preview = document.getElementById('image-preview');
            const placeholder = document.getElementById('upload-placeholder');
            const removeBtn = document.getElementById('remove-btn-container');

            preview.src = dataURL;
            preview.classList.remove('hidden');
            placeholder.classList.add('hidden'); // Hide the icon text
            removeBtn.classList.remove('hidden'); // Show delete button
        };
        
        if (input.files && input.files[0]) {
            reader.readAsDataURL(input.files[0]);
        }
    }

    function removeImage() {
        const input = document.getElementById('image_upload');
        const preview = document.getElementById('image-preview');
        const placeholder = document.getElementById('upload-placeholder');
        const removeBtn = document.getElementById('remove-btn-container');

        input.value = ""; // Clear file input
        preview.src = "";
        preview.classList.add('hidden');
        placeholder.classList.remove('hidden'); // Show icon text again
        removeBtn.classList.add('hidden');
    }
</script>
@endsection
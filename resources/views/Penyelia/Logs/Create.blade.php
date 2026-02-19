@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Rekod Log Baru') }}
    </h2>
@endsection

@section('content')
<div class="py-6 px-4 max-w-lg mx-auto pb-24">

{{-- ERROR ALERT BLOCK --}}
    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-600 rounded-xl p-4 mb-6 text-sm">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Info Card --}}
    <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 mb-6 flex gap-3 items-start">
        <svg class="w-5 h-5 text-blue-800 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <div>
            <p class="text-sm text-blue-900 font-medium">Pastikan butiran tepat.</p>
            <p class="text-xs text-blue-700 mt-1">Sila isi semua maklumat yang diperlukan di bawah.</p>
        </div>
    </div>

    <form action="{{ route('logs.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf

        {{-- 2. KAWASAN BERTUGAS --}}
        <div>
            <label for="area" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                Kawasan Penugasan
            </label>
            <div class="relative">
                <select id="area" name="area" onchange="filterTasks()" class="block w-full pl-4 pr-10 py-3 bg-white border border-gray-200 rounded-xl focus:ring-blue-900 focus:border-blue-900 text-sm appearance-none">
                    <option value="" disabled selected>Sila Pilih Kawasan</option>
                    <option value="Kawasan Luar">Kawasan Luar</option>
                    <option value="Kawasan Dalam">Kawasan Dalam</option>
                    
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
                    @foreach($penugasans as $tugas)
                        <option value="{{ $tugas->name }}" data-category="{{ $tugas->category }}">
                            {{ $tugas->name }}</option>
                    @endforeach
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </div>
        </div>

        {{-- 4. TARIKH & MASA --}}
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="date" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Tarikh Mula</label>
                <input type="date" id="date" name="date" value="{{ date('Y-m-d') }}"
                       class="block w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-blue-900 focus:border-blue-900 text-sm">
            </div>
            <div>
                <label for="time" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Masa Mula</label>
                <input type="time" id="time" name="time" value="{{ date('H:i') }}"
                       class="block w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-blue-900 focus:border-blue-900 text-sm">
            </div>
        </div>

        {{-- 5. STATUS TUGAS (OFF DUTY CHECKBOX) --}}
        {{-- UPDATED: Replaced Officer Select with Checkbox --}}
        <div class="relative flex items-start py-4 px-4 bg-gray-50 border border-gray-200 rounded-xl">
            <div class="flex items-center h-5">
                <input id="is_off_duty" name="is_off_duty" type="checkbox" value="1" class="focus:ring-blue-900 h-4 w-4 text-blue-900 border-gray-300 rounded cursor-pointer">
            </div>
            <div class="ml-3 text-sm">
                <label for="is_off_duty" class="font-bold text-gray-700 select-none cursor-pointer">
                    Tugas Luar Waktu (Off Duty)
                </label>
                <p class="text-gray-500 text-xs mt-0.5">
                    Tandakan jika aktiviti ini dilakukan di luar waktu bertugas rasmi.
                </p>
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

        {{-- 7. GAMBAR SOKONGAN --}}
        <div>
            <div class="flex justify-between items-center mb-2">
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                    Gambar Sokongan (Optional)
                </label>
                <span id="image-count" class="text-[10px] font-bold text-gray-400">0/8 Gambar</span>
            </div>
            
            <div class="w-full space-y-3">
                {{-- Upload Box --}}
                <label for="image_upload" id="dropzone" class="flex flex-col items-center justify-center w-full h-24 border-2 border-gray-300 border-dashed rounded-xl cursor-pointer bg-gray-50 hover:bg-gray-100 transition relative overflow-hidden group">
                    
                    <div class="flex flex-col items-center justify-center pt-2 pb-3">
                        <svg class="w-6 h-6 mb-1 text-gray-400 group-hover:text-blue-900 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <p class="text-xs text-gray-500 font-medium">Tambah Gambar</p>
                        <p class="text-[9px] text-gray-400">Max 8 gambar (JPG/PNG)</p>
                    </div>

                    {{-- Input: Note the 'multiple' and name='images[]' --}}
                    <input id="image_upload" name="images[]" type="file" class="hidden" accept="image/*" multiple onchange="handleFiles(this.files)" />
                </label>

                {{-- Preview Grid --}}
                <div id="preview-container" class="grid grid-cols-4 gap-2">
                    {{-- Thumbnails will be injected here by JS --}}
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

{{-- JAVASCRIPT FOR HANDLING MULTIPLE IMAGES --}}
{{-- JAVASCRIPT FOR HANDLING MULTIPLE IMAGES & DROPDOWNS --}}
<script>
    // --- 1. IMAGE UPLOAD LOGIC ---
    // Store files in a DataTransfer object to manipulate them (add/remove)
    const dt = new DataTransfer();
    const maxImages = 8;

    function handleFiles(files) {
        const input = document.getElementById('image_upload');
        
        // Add new files to our DataTransfer object
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            
            // Check limit
            if (dt.items.length >= maxImages) {
                alert("Maksimum 8 gambar sahaja dibenarkan.");
                break;
            }

            // Check if file is image
            if (file.type.match('image.*')) {
                dt.items.add(file);
            }
        }

        // Update the actual input file list so it submits correctly to backend
        input.files = dt.files;

        // Update UI
        updateImagePreviews();
    }

    function updateImagePreviews() {
        const container = document.getElementById('preview-container');
        const countLabel = document.getElementById('image-count');
        const dropzone = document.getElementById('dropzone');

        // Clear current previews
        container.innerHTML = '';

        // Update count text
        countLabel.innerText = `${dt.items.length}/${maxImages} Gambar`;

        // Loop through files and create thumbnails
        for (let i = 0; i < dt.files.length; i++) {
            const file = dt.files[i];
            const reader = new FileReader();

            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'relative w-full h-20 rounded-lg overflow-hidden group border border-gray-200 shadow-sm';
                
                div.innerHTML = `
                    <img src="${e.target.result}" class="w-full h-full object-cover">
                    <button type="button" onclick="removeImage(${i})" class="absolute top-1 right-1 bg-red-500 text-white rounded-full p-0.5 shadow-md hover:bg-red-600 transition">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                `;
                container.appendChild(div);
            }
            reader.readAsDataURL(file);
        }

        // Hide dropzone if max reached
        if (dt.items.length >= maxImages) {
            dropzone.classList.add('opacity-50', 'pointer-events-none');
        } else {
            dropzone.classList.remove('opacity-50', 'pointer-events-none');
        }
    }

    function removeImage(index) {
        const input = document.getElementById('image_upload');
        
        // Remove file at index
        dt.items.remove(index);
        
        // Update input files
        input.files = dt.files;
        
        // Refresh UI
        updateImagePreviews();
    }

    // --- 2. DROPDOWN FILTER LOGIC (iOS FIX) ---
    // Store the original options here so we don't lose them when we empty the select box
    let originalTaskOptions = [];

    function filterTasks() {
        const areaSelect = document.getElementById('area');
        const typeSelect = document.getElementById('type');
        const selectedArea = areaSelect.value;

        // Clear all current options out of the dropdown
        typeSelect.innerHTML = '';

        // Add the disabled placeholder back first
        const placeholder = document.createElement('option');
        placeholder.value = "";
        placeholder.disabled = true;
        placeholder.selected = true;
        placeholder.text = "Sila Pilih Tugas";
        typeSelect.appendChild(placeholder);

        // Loop through our saved original options
        originalTaskOptions.forEach(option => {
            // Skip the placeholder from the original list
            if (option.disabled) return;

            const category = option.getAttribute('data-category');

            // If the category matches, append a clone of the option back into the dropdown
            if (category === selectedArea) {
                typeSelect.appendChild(option.cloneNode(true));
            }
        });
    }

    // Run once on load
    document.addEventListener("DOMContentLoaded", function() {
        const typeSelect = document.getElementById('type');
        
        // Save a copy of all the `<option>` tags generated by Laravel into our array
        originalTaskOptions = Array.from(typeSelect.options).map(opt => opt.cloneNode(true));

        // If an area is already selected (e.g., after validation fails and page reloads), filter the tasks
        if(document.getElementById('area').value !== "") {
            filterTasks();
        }
    });
</script>
@endsection
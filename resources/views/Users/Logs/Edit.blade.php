@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Kemaskini Laporan') }}
    </h2>
@endsection

@section('content')
<div class="py-6 px-4 max-w-lg mx-auto pb-24">

    {{-- Error Display --}}
    @if ($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4">
            <div class="flex items-center gap-3 mb-2">
                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <h3 class="font-bold text-red-800 text-sm">Terdapat Ralat:</h3>
            </div>
            <ul class="list-disc list-inside text-xs text-red-700 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Info Card --}}
    <div class="bg-yellow-50 border border-yellow-100 rounded-xl p-4 mb-6 flex gap-3 items-start">
        <svg class="w-5 h-5 text-yellow-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
        <div>
            <p class="text-sm text-yellow-800 font-medium">Mod Suntingan</p>
            <p class="text-xs text-yellow-700 mt-1">Anda sedang mengemaskini laporan bertarikh {{ \Carbon\Carbon::parse($log->date)->format('d M Y') }}.</p>
        </div>
    </div>

    {{-- MAIN FORM STARTS --}}
    <form action="{{ route('logs.update', $log->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5" id="main-update-form">
        @csrf
        @method('PUT')

        {{-- 1. KAWASAN PENUGASAN --}}
        <div>
            <label for="area" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                Kawasan Penugasan
            </label>
            <div class="relative">
                {{-- Remove filterTasks() from onchange here, we handle it in JS listener --}}
                <select id="area" name="area" class="block w-full pl-4 pr-10 py-3 bg-white border border-gray-200 rounded-xl focus:ring-blue-900 focus:border-blue-900 text-sm appearance-none">
                    <option value="Kawasan Luar" {{ $log->area == 'Kawasan Luar' ? 'selected' : '' }}>Kawasan Luar</option>
                    <option value="Kawasan Dalam" {{ $log->area == 'Kawasan Dalam' ? 'selected' : '' }}>Kawasan Dalam</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </div>
        </div>

        {{-- 2. JENIS PENUGASAN --}}
        <div>
            <label for="type" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                Jenis Penugasan
            </label>
            <div class="relative">
                <select id="type" name="type" class="block w-full pl-4 pr-10 py-3 bg-white border border-gray-200 rounded-xl focus:ring-blue-900 focus:border-blue-900 text-sm appearance-none">
                    @foreach($penugasans as $tugas)
                        <option value="{{ $tugas->name }}" 
                                data-category="{{ $tugas->category }}"
                                {{ $log->type == $tugas->name ? 'selected' : '' }}>
                            {{ $tugas->name }}
                        </option>
                    @endforeach
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </div>
        </div>

        {{-- 3. TARIKH & MASA --}}
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="date" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Tarikh</label>
                <input type="date" id="date" name="date" value="{{ $log->date }}"
                       class="block w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-blue-900 focus:border-blue-900 text-sm">
            </div>
            <div>
                <label for="time" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Masa Mula</label>
                <input type="text" id="time" name="time" value="{{ \Carbon\Carbon::parse($log->time)->format('H:i') }}"
                       class="timepicker block w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-blue-900 focus:border-blue-900 text-sm">
            </div>
        </div>

        {{-- 4. OFF DUTY CHECKBOX --}}
        <div class="relative flex items-start py-4 px-4 bg-gray-50 border border-gray-200 rounded-xl">
            <div class="flex items-center h-5">
                <input id="is_off_duty" name="is_off_duty" type="checkbox" value="1" {{ $log->is_off_duty ? 'checked' : '' }} class="focus:ring-blue-900 h-4 w-4 text-blue-900 border-gray-300 rounded cursor-pointer">
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

        {{-- 5. CATATAN --}}
        <div>
            <label for="remarks" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                Catatan Aktiviti
            </label>
            <textarea id="remarks" name="remarks" rows="4" required
                      class="block w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-blue-900 focus:border-blue-900 text-sm">{{ $log->remarks }}</textarea>
        </div>

        {{-- 6. GAMBAR --}}
        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Gambar Sedia Ada</label>
            
            @if($log->images && count($log->images) > 0)
                <div class="grid grid-cols-4 gap-2 mb-4">
                    @foreach($log->images as $index => $img)
                        <div class="relative w-full h-20 rounded-lg overflow-hidden border border-gray-200 group">
                            <img src="{{ asset('storage/'.$img) }}" class="w-full h-full object-cover">
                            
                            {{-- 
                               FIX: Button points to EXTERNAL form using form="id" attribute 
                               This prevents nested form issues
                            --}}
                            <button type="submit" form="delete-img-form-{{ $index }}" 
                                    class="absolute top-1 right-1 bg-red-500 text-white rounded-full p-0.5 shadow hover:bg-red-600"
                                    onclick="return confirm('Padam gambar ini?')">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-xs text-gray-400 italic mb-4">Tiada gambar.</p>
            @endif

            <label for="image_upload" class="flex flex-col items-center justify-center w-full h-24 border-2 border-gray-300 border-dashed rounded-xl cursor-pointer bg-gray-50 hover:bg-gray-100 transition">
                <div class="flex flex-col items-center justify-center pt-2 pb-3">
                    <svg class="w-6 h-6 mb-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    <p class="text-xs text-gray-500 font-medium">Tambah Gambar Baru</p>
                </div>
                <input id="image_upload" name="images[]" type="file" class="hidden" accept="image/*" multiple />
            </label>
        </div>

        {{-- SUBMIT --}}
        <div class="pt-4 flex gap-3">
            <a href="{{ route('logs.history') }}" class="flex-1 py-4 text-center border border-gray-300 rounded-xl text-sm font-bold text-gray-700 hover:bg-gray-50">
                Batal
            </a>
            <button type="submit" class="flex-[2] py-4 bg-[#00205B] text-white rounded-xl text-sm font-bold hover:bg-blue-900 shadow-lg shadow-blue-900/20">
                Simpan Perubahan
            </button>
        </div>

    </form> {{-- MAIN FORM ENDS HERE --}}

    {{-- 
       FIX: EXTERNAL DELETE FORMS 
       These are placed OUTSIDE the main form to prevent conflicts.
    --}}
    @if($log->images)
        @foreach($log->images as $index => $img)
            <form id="delete-img-form-{{ $index }}" action="{{ route('logs.delete_image', $log->id) }}" method="POST" class="hidden">
                @csrf
                @method('DELETE')
                <input type="hidden" name="image_path" value="{{ $img }}">
            </form>
        @endforeach
    @endif

</div>

{{-- REQUIRED SCRIPTS --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // 1. Initialize Flatpickr (Time Picker)
        flatpickr(".timepicker", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true
        });

        // 2. Initialize Filter Logic
        const areaSelect = document.getElementById('area');
        areaSelect.addEventListener('change', filterTasks);
        
        filterTasks(false); 
    });

    function filterTasks(resetValue = true) {
        const areaSelect = document.getElementById('area');
        const typeSelect = document.getElementById('type');
        const selectedArea = areaSelect.value;
        const options = typeSelect.querySelectorAll('option');

        if(resetValue) {
            typeSelect.value = "";
        }

        options.forEach(option => {
            if (option.disabled) return; // Skip placeholder

            const category = option.getAttribute('data-category');
            if (category === selectedArea) {
                option.style.display = "block"; 
            } else {
                option.style.display = "none"; 
            }
        });
    }
</script>
@endsection
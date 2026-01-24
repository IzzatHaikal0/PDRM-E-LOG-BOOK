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

    <form action="#" method="POST" class="space-y-5">
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
                
                {{-- Link to Profile to change this --}}
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

                    {{-- EXAMPLE DATA LOOP --}}
                    {{-- @foreach($activityAreas as $activityAreas) --}}
                    {{-- <option value="{{ $activityAreas->id }}">{{ $activityAreas->name }}</option> --}}
                    {{-- @endforeach --}}


                    <option value="Pos Pengawal">Pos Pengawal</option>
                    <option value="Kaunter Pertanyaan">Kaunter Pertanyaan / Kaunter Aduan</option>
                    <option value="Bilik penjara">Bilik penjara</option>
                    <option value="Bilik siasatan">Bilik siasatan</option>
                    <option value="Bilik pegawai bertugas">Bilik pegawai bertugas</option>
                    <option value="Bilik laporan polis">Bilik laporan polis</option>
                    <option value="Bilik soal siasat">Bilik soal siasat</option>
                    <option value="Bilik Operasi">Bilik kawalan / bilik operasi</option>
                    <option value="Bilik mesyuarat">Bilik mesyuarat</option>
                    <option value="Pejabat">Pejabat pentadbiran</option>
                    <option value="Bilik fail">Bilik fail / rekod</option>
                    <option value="Bilik senjata">Bilik senjata</option>
                    <option value="Bilik CCTV">Bilik CCTV / pemantauan</option>
                    <option value="Bilik rehat anggota">Bilik rehat anggota</option>
                    <option value="Surau">Surau</option>
                    <option value="Tandas">Tandas</option>
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

                    {{-- EXAMPLE DATA LOOP --}}
                    {{-- @foreach($activityTypes as $activityTypes) --}}
                    {{-- <option value="{{ $activityTypes->id }}">{{ $activityTypes->name }}</option> --}}
                    {{-- @endforeach --}}

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

        {{-- 4. TARIKH & MASA (Manual Input) --}}
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

        {{-- 5. PEGAWAI PENYELIA (Dropdown from DB) --}}
        <div>
            <label for="officer_id" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                Pegawai Penyelia (Pengesah)
            </label>
            <div class="relative">
                <select id="officer_id" name="officer_id" class="block w-full pl-4 pr-10 py-3 bg-white border border-gray-200 rounded-xl focus:ring-blue-900 focus:border-blue-900 text-sm appearance-none">
                    <option value="" disabled selected>Pilih Pegawai</option>
                    
                    {{-- EXAMPLE DATA LOOP --}}
                    {{-- @foreach($officers as $officer) --}}
                    {{-- <option value="{{ $officer->id }}">{{ $officer->name }} ({{ $officer->rank }})</option> --}}
                    {{-- @endforeach --}}

                    {{-- Dummy Data for UI Testing --}}
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

        {{-- SUBMIT BUTTON --}}
        <div class="pt-4">
            <button type="submit" class="w-full flex items-center justify-center gap-2 py-4 px-4 border border-transparent rounded-xl shadow-lg shadow-blue-900/20 text-sm font-bold text-white bg-[#00205B] hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-900 transition-all transform active:scale-[0.98]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Hantar Laporan
            </button>
        </div>

    </form>
</div>
@endsection
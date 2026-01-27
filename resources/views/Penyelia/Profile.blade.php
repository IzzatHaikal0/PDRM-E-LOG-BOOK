@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Profil Pegawai') }}
    </h2>
@endsection

@section('content')
<div class="py-6 px-4 max-w-lg mx-auto pb-24">

    {{-- 1. PROFILE HEADER CARD (PENYELIA) --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 mb-6 text-center relative overflow-hidden">
        {{-- Background Decoration --}}
        <div class="absolute top-0 left-0 w-full h-24 bg-gradient-to-b from-[#00205B] to-blue-900"></div>
        
        <div class="relative z-10 mt-8">
            <div class="w-24 h-24 bg-white p-1 rounded-full mx-auto shadow-lg relative">
                <div class="w-full h-full bg-gray-200 rounded-full flex items-center justify-center text-gray-500 font-bold text-2xl overflow-hidden">
                    {{-- Avatar --}}
                    @if(Auth::user() && Auth::user()->profile_photo_url)
                        <img src="{{ Auth::user()->profile_photo_url }}" class="w-full h-full object-cover">
                    @else
                        {{ substr(Auth::user()->name ?? 'Razak', 0, 2) }}
                    @endif
                </div>
                
                {{-- SUPERVISOR BADGE (Gold Star) --}}
                <div class="absolute bottom-0 right-0 bg-yellow-400 border-4 border-white rounded-full p-1.5 text-white shadow-sm" title="Akaun Penyelia">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                </div>
            </div>
            
            <h3 class="mt-3 text-xl font-bold text-gray-900 flex items-center justify-center gap-2">
                {{ Auth::user()->name ?? 'Insp. Razak Bin Karim' }}
            </h3>
            
            {{-- Rank & Badge Number --}}
            <p class="text-sm text-gray-500 font-medium mb-2">
                {{ Auth::user()->rank ?? 'Inspektor' }} • {{ Auth::user()->badge_number ?? 'G/12999' }}
            </p>

            {{-- Role Badge --}}
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800 tracking-wide">
                PEGAWAI PENYELIA
            </span>
        </div>
    </div>

    {{-- 2. TETAPAN PENYELIAAN (Supervisor Specific) --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-6 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-50 bg-gray-50/50 flex items-center gap-2">
            {{-- Shield Icon for Supervision --}}
            <svg class="w-5 h-5 text-[#00205B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
            <h4 class="font-bold text-gray-800 text-sm uppercase tracking-wide">Tetapan Penyeliaan</h4>
        </div>
        
        <div class="p-5">
            <form action="#" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-5">
                    
                    {{-- Jurisdiction Selection --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Zon Jagaan Semasa</label>
                        <select name="zone" class="block w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-blue-900 focus:border-blue-900 text-sm">
                            <option value="all" selected>Semua Sektor (IPD Muar)</option>
                            <option value="sector_a">Sektor A (Bandar)</option>
                            <option value="sector_b">Sektor B (Parit Jawa)</option>
                            <option value="mpv_unit">Unit MPV Sahaja</option>
                        </select>
                        <p class="text-[10px] text-gray-400 mt-1">Log aktiviti dari zon ini akan dihantar kepada anda untuk pengesahan.</p>
                    </div>

                    {{-- Notification Toggle --}}
                    <div class="flex items-center justify-between py-1">
                        <div>
                            <label class="block text-sm font-bold text-gray-700">Notifikasi Log Baru</label>
                            <p class="text-[11px] text-gray-400">Terima emel apabila anggota hantar log.</p>
                        </div>
                        
                        {{-- Styled Toggle Switch --}}
                        <label for="toggle" class="flex items-center cursor-pointer relative">
                            <input type="checkbox" id="toggle" class="sr-only">
                            <div class="toggle-bg bg-gray-200 border-2 border-gray-200 h-6 w-11 rounded-full"></div>
                            <span class="toggle-circle absolute left-0.5 top-0.5 bg-white w-5 h-5 rounded-full transition shadow-sm"></span>
                        </label>
                    </div>

                </div>

                <div class="mt-6 flex justify-end">
                    <button type="button" onclick="alert('Tetapan penyeliaan dikemaskini!')" class="px-4 py-2 bg-blue-50 text-blue-700 rounded-lg text-xs font-bold uppercase tracking-wider hover:bg-blue-100 transition">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- 3. MAKLUMAT PERIBADI (Read Only with Link to Edit) --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-6 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-50 bg-gray-50/50 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                <h4 class="font-bold text-gray-800 text-sm uppercase tracking-wide">Maklumat Peribadi</h4>
            </div>

            {{-- LINK TO EDIT PAGE --}}
            <a href="{{ route('Penyelia.EditProfile') }}" class="text-blue-600 hover:text-blue-800 hover:bg-blue-50 p-1.5 rounded-lg transition flex items-center gap-1 text-xs font-bold">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                Ubah
            </a>
        </div>
        
        <div class="p-5 space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">No. Kad Pengenalan</label>
                    <p class="text-sm font-semibold text-gray-800">820505-01-9999</p>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">No. Telefon</label>
                    <p class="text-sm font-semibold text-gray-800">019-9988776</p>
                </div>
            </div>
            
            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">Jawatan Rasmi</label>
                <p class="text-sm font-semibold text-gray-800">Ketua Polis Balai (KPB) - IPD Muar</p>
            </div>

            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">Emel Rasmi</label>
                <p class="text-sm font-semibold text-gray-800">razak.karim@pdrm.gov.my</p>
            </div>
        </div>
    </div>

    {{-- 4. LOGOUT BUTTON --}}
    <form method="POST" action="#">
        @csrf
        <button type="submit" class="w-full flex items-center justify-center gap-2 p-4 bg-white border border-red-100 rounded-2xl shadow-sm hover:bg-red-50 transition group">
            <svg class="w-5 h-5 text-red-500 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
            <span class="text-red-600 font-bold text-sm">Log Keluar Akaun</span>
        </button>
    </form>
    
    <div class="text-center mt-6 mb-2">
        <p class="text-[10px] text-gray-300">PDRM EP5 System v1.0 (Supervisor Access)</p>
    </div>

</div>

{{-- CSS for Custom Toggle --}}
<style>
    #toggle:checked + .toggle-bg {
        background-color: #00205B; /* PDRM Blue */
        border-color: #00205B;
    }
    #toggle:checked + .toggle-bg + .toggle-circle {
        transform: translateX(100%);
        border-color: white;
    }
</style>
@endsection
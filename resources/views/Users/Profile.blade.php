@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Profil Saya') }}
    </h2>
@endsection

@section('content')
<div class="py-6 px-4 max-w-lg mx-auto pb-24 relative">

    {{-- 1. PROFILE HEADER CARD --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 mb-6 text-center relative overflow-hidden">
        {{-- Background Gradient --}}
        <div class="absolute top-0 left-0 w-full h-24 bg-gradient-to-b from-[#00205B] to-blue-900"></div>
        
        <div class="relative z-10 mt-8">
            <div class="w-24 h-24 bg-white p-1 rounded-full mx-auto shadow-lg">
                <div class="w-full h-full bg-gray-200 rounded-full flex items-center justify-center text-gray-500 font-bold text-2xl overflow-hidden">
                    @if(Auth::user() && Auth::user()->profile_photo_url)
                        <img src="{{ Auth::user()->profile_photo_url }}" class="w-full h-full object-cover">
                    @else
                        {{ substr(Auth::user()->name ?? 'Ahmad', 0, 2) }}
                    @endif
                </div>
            </div>
            
            <h3 class="mt-3 text-xl font-bold text-gray-900">
                {{ Auth::user()->name ?? 'Kpl. Ahmad Albab' }}
            </h3>
            <p class="text-sm text-gray-500 font-medium">
                {{ Auth::user()->rank ?? 'Koperal' }} • {{ Auth::user()->badge_number ?? 'RF12345' }}
            </p>
        </div>
    </div>


    {{-- 3. MAKLUMAT PERIBADI (Read Only with Edit Link) --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-6 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-50 bg-gray-50/50 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                <h4 class="font-bold text-gray-800 text-sm uppercase tracking-wide">Maklumat Peribadi</h4>
            </div>
            
            {{-- ADDED: Edit Link Button --}}
            <a href="{{ route('Users.EditProfile') }}" class="text-blue-600 hover:text-blue-800 hover:bg-blue-50 p-1.5 rounded-lg transition flex items-center gap-1 text-xs font-bold">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                Ubah
            </a>
        </div>
        
        <div class="p-5 space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">No. Kad Pengenalan</label>
                    <p class="text-sm font-semibold text-gray-800">880101-01-5555</p>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">No. Telefon</label>
                    <p class="text-sm font-semibold text-gray-800">012-3456789</p>
                </div>
            </div>
            
            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">Emel Rasmi</label>
                <p class="text-sm font-semibold text-gray-800">ahmad.albab@pdrm.gov.my</p>
            </div>

            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">Alamat Tetap</label>
                <p class="text-sm font-semibold text-gray-800 leading-relaxed">
                    No. 12, Jalan Bunga Raya 4, Taman Cempaka, 84000 Muar, Johor.
                </p>
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
        <p class="text-[10px] text-gray-300">PDRM EP5 System v1.0</p>
    </div>

</div>
@endsection
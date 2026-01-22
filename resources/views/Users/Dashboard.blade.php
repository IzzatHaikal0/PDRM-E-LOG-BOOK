@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Dashboard Anggota') }}
    </h2>
@endsection

@section('content')
<div class="py-6 px-4 sm:px-6 lg:px-8 max-w-lg mx-auto pb-24">
    
    {{-- 1. WELCOME SECTION --}}
    <div class="mb-6 flex flex-col gap-1">
        <h1 class="text-2xl font-bold text-[#00205B]">Selamat Bertugas,</h1>
        <div class="flex items-center justify-between">
            <p class="text-lg font-semibold text-gray-700">Kpl. Ahmad Albab</p> {{-- Dummy Name --}}
            <div class="text-xs font-medium text-blue-800 bg-blue-50 px-3 py-1 rounded-full">
                {{ \Carbon\Carbon::now()->translatedFormat('l, d M') }}
            </div>
        </div>
        <p class="text-xs text-gray-400">ID: RF12345 • IPD Muar</p>
    </div>

    {{-- 2. PERSONAL STATS GRID (2 Columns for Mobile) --}}
    <div class="grid grid-cols-2 gap-3 mb-6">
        
        {{-- Card 1: Status Bertugas --}}
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-16 h-16 bg-green-50 rounded-bl-full -mr-2 -mt-2 transition group-hover:bg-green-100"></div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider relative z-10">Status</p>
                <h3 class="text-lg font-bold text-green-600 mt-1 relative z-10">Aktif</h3>
            </div>
            <div class="mt-3 flex items-center gap-1 text-[10px] text-gray-400">
                <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                Masuk: 08:00 PG
            </div>
        </div>

        {{-- Card 2: Jumlah Log --}}
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-16 h-16 bg-blue-50 rounded-bl-full -mr-2 -mt-2 transition group-hover:bg-blue-100"></div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider relative z-10">Log Hari Ini</p>
                <h3 class="text-2xl font-bold text-[#00205B] mt-1 relative z-10">3</h3>
            </div>
             <div class="mt-3 text-[10px] text-blue-400">
                +1 dari semalam
            </div>
        </div>

        {{-- Card 3: Jam Bertugas --}}
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between relative overflow-hidden group">
             <div class="absolute right-0 top-0 w-16 h-16 bg-indigo-50 rounded-bl-full -mr-2 -mt-2 transition group-hover:bg-indigo-100"></div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider relative z-10">Jam Bertugas</p>
                <h3 class="text-xl font-bold text-gray-800 mt-1 relative z-10">4.5 <span class="text-xs font-normal text-gray-400">Jam</span></h3>
            </div>
             <div class="mt-3 text-[10px] text-gray-400">
                Sif A (08-16)
            </div>
        </div>

        {{-- Card 4: Cuti / Off --}}
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between relative overflow-hidden group">
             <div class="absolute right-0 top-0 w-16 h-16 bg-orange-50 rounded-bl-full -mr-2 -mt-2 transition group-hover:bg-orange-100"></div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider relative z-10">Baki Cuti</p>
                <h3 class="text-xl font-bold text-gray-800 mt-1 relative z-10">12 <span class="text-xs font-normal text-gray-400">Hari</span></h3>
            </div>
             <div class="mt-3 text-[10px] text-orange-400">
                Mohon Cuti >
            </div>
        </div>
    </div>

    {{-- 3. RECENT LOGS LIST --}}
    <div class="space-y-4 mb-6">
        <div class="flex items-center justify-between px-1">
            <h3 class="text-base font-bold text-gray-800">Log Terkini Saya</h3>
            <a href="{{ route('logs.history') }}" class="text-xs font-bold text-blue-800 hover:text-blue-600 uppercase tracking-wide">Lihat Semua</a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="divide-y divide-gray-100">
                
                {{-- Log Item 1 --}}
                <div class="p-4 flex gap-4 hover:bg-gray-50 transition">
                    <div class="flex flex-col items-center gap-1 shrink-0 w-12">
                        <span class="text-xs font-bold text-gray-800">10:30</span>
                        <span class="text-[10px] text-gray-400 uppercase">Pagi</span>
                        <div class="h-full w-px bg-gray-200 my-1"></div>
                    </div>
                    <div class="flex-1 pb-2">
                        <div class="flex items-start justify-between">
                            <h4 class="text-sm font-bold text-[#00205B]">Rondaan Berkala</h4>
                            <span class="px-2 py-0.5 rounded text-[10px] font-medium bg-green-100 text-green-700">Selesai</span>
                        </div>
                        <p class="text-xs text-gray-500 mt-1 line-clamp-2">Membuat rondaan di kawasan Taman Tun Dr Ismail sektor A dan B.</p>
                        <div class="flex items-center gap-2 mt-2">
                            <span class="text-[10px] bg-gray-100 text-gray-500 px-1.5 py-0.5 rounded">Taman Tun</span>
                            <span class="text-[10px] bg-gray-100 text-gray-500 px-1.5 py-0.5 rounded">Berkereta</span>
                        </div>
                    </div>
                </div>

                {{-- Log Item 2 --}}
                <div class="p-4 flex gap-4 hover:bg-gray-50 transition">
                    <div class="flex flex-col items-center gap-1 shrink-0 w-12">
                        <span class="text-xs font-bold text-gray-800">08:15</span>
                        <span class="text-[10px] text-gray-400 uppercase">Pagi</span>
                        <div class="h-full w-px bg-gray-200 my-1"></div>
                    </div>
                    <div class="flex-1 pb-2">
                         <div class="flex items-start justify-between">
                            <h4 class="text-sm font-bold text-[#00205B]">Lapor Masuk Tugas</h4>
                            <span class="px-2 py-0.5 rounded text-[10px] font-medium bg-blue-100 text-blue-700">Sistem</span>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Daftar masuk tugas di Balai Polis Muar.</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- 4. BOTTOM NAVIGATION BAR (Anggota Specific) --}}
<nav class="fixed bottom-0 left-0 z-50 w-full h-16 bg-white border-t border-gray-200 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)]">
    <div class="grid h-full max-w-lg grid-cols-5 mx-auto font-medium">
        
        @php
            $baseClass = "inline-flex flex-col items-center justify-center px-5 group transition-all duration-200";
            $activeClass = "text-[#00205B]"; 
            $inactiveClass = "text-gray-400 hover:bg-gray-50 hover:text-gray-600";
        @endphp

        {{-- 1. UTAMA (Dashboard) --}}
        <a href="{{ route('dashboard') }}" 
           class="{{ $baseClass }} {{ request()->routeIs('dashboard') ? $activeClass : $inactiveClass }}">
            <svg class="w-6 h-6 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span class="text-[10px] uppercase tracking-wide font-semibold">Utama</span>
        </a>

        {{-- 2. CONTACTS (Hubungi) --}}
        <a href="{{ route('contacts') }}" 
           class="{{ $baseClass }} {{ request()->routeIs('contacts') ? $activeClass : $inactiveClass }}">
            <svg class="w-6 h-6 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <span class="text-[10px] uppercase tracking-wide font-semibold">Hubungi</span>
        </a>

        {{-- 3. CREATE (Rekod) - CENTER HIGHLIGHT --}}
        <a href="{{ route('logs.create') }}" 
           class="{{ $baseClass }} {{ request()->routeIs('logs.create') ? $activeClass : $inactiveClass }}">
            <div class="p-1.5 bg-[#00205B] rounded-xl text-white shadow-lg shadow-blue-900/40 transform transition hover:scale-105 active:scale-95 mb-1">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
            </div>
            <span class="text-[10px] uppercase tracking-wide font-semibold text-[#00205B]">Rekod</span>
        </a>

        {{-- 4. HISTORY (Sejarah) --}}
        <a href="{{ route('logs.history') }}" 
           class="{{ $baseClass }} {{ request()->routeIs('logs.history') ? $activeClass : $inactiveClass }}">
            <svg class="w-6 h-6 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="text-[10px] uppercase tracking-wide font-semibold">Sejarah</span>
        </a>

        {{-- 5. PROFILE (Profil) --}}
        <a href="{{ route('profile.show') }}" 
           class="{{ $baseClass }} {{ request()->routeIs('profile.*') ? $activeClass : $inactiveClass }}">
            <svg class="w-6 h-6 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <span class="text-[10px] uppercase tracking-wide font-semibold">Profil</span>
        </a>

    </div>
</nav>
@endsection
@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Admin Dashboard') }}
    </h2>
@endsection

@section('content')
<div class="py-6 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    
    {{-- 1. WELCOME SECTION --}}
    {{-- Desktop: Flex row (Name left, Date right). Mobile: Stacked. --}}
    <div class="mb-6 flex flex-col sm:flex-row sm:items-end sm:justify-between gap-2">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-[#00205B]">Selamat Datang, Tuan.</h1>
            <p class="text-sm text-gray-500 mt-1">Paparan Admin Sistem PDRM EP5</p>
        </div>
        <div class="text-sm font-medium text-blue-800 bg-blue-50 px-3 py-1 rounded-lg self-start sm:self-auto">
            {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
        </div>
    </div>

    {{-- 2. STATS GRID --}}
    {{-- Mobile: 2 Columns. Desktop: 4 Columns. --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between hover:shadow-md transition">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Pegawai</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-1">12</h3>
                </div>
                <div class="p-2 bg-blue-50 rounded-lg text-blue-900">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
            </div>
            <div class="mt-2 flex items-center text-xs text-green-600">
                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                <span>2 Aktif</span>
            </div>
        </div>

        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between hover:shadow-md transition">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Anggota</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-1">48</h3>
                </div>
                <div class="p-2 bg-indigo-50 rounded-lg text-indigo-900">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
            </div>
             <div class="mt-2 flex items-center text-xs text-green-600">
                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                <span>12 Bertugas</span>
            </div>
        </div>

        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between hover:shadow-md transition">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Balai</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-1">4</h3>
                </div>
                <div class="p-2 bg-emerald-50 rounded-lg text-emerald-900">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
            </div>
            <div class="mt-2 text-xs text-gray-400">IPD Muar</div>
        </div>

        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between hover:shadow-md transition">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Laporan</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-1">156</h3>
                </div>
                <div class="p-2 bg-red-50 rounded-lg text-red-900">
                   <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
            </div>
            <div class="mt-2 text-xs text-gray-400">Bulan Ini</div>
        </div>
    </div>

    {{-- 3. MAIN CONTENT SPLIT --}}
    {{-- Mobile: Single Column. Desktop: Grid with Side-by-Side panels. --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- LEFT COLUMN: Recent Logs (Takes up 2/3 width on Desktop) --}}
        <div class="lg:col-span-2 space-y-4">
            <div class="flex items-center justify-between px-1">
                <h3 class="text-base font-bold text-gray-800">Log Terkini</h3>
                <a href="#" class="text-sm font-semibold text-blue-800 hover:text-blue-600">Lihat Semua</a>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="divide-y divide-gray-100">
                    <div class="p-4 flex items-center gap-4 hover:bg-gray-50 transition">
                        <div class="w-10 h-10 rounded-full bg-gray-200 flex-shrink-0">
                             <img src="https://ui-avatars.com/api/?name=Ali+Abu&background=0D8ABC&color=fff" class="w-full h-full rounded-full" alt="">
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold text-gray-900 truncate">Kpl. Ali bin Abu</p>
                            <p class="text-xs text-gray-500 truncate">Rondaan Sektor A - Selesai</p>
                        </div>
                        <span class="text-xs font-medium text-gray-400 bg-gray-100 px-2 py-1 rounded-full">10 min</span>
                    </div>

                    <div class="p-4 flex items-center gap-4 hover:bg-gray-50 transition">
                         <div class="w-10 h-10 rounded-full bg-gray-200 flex-shrink-0">
                             <img src="https://ui-avatars.com/api/?name=Siti+Aminah&background=6366f1&color=fff" class="w-full h-full rounded-full" alt="">
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold text-gray-900 truncate">L/Kpl Siti Aminah</p>
                            <p class="text-xs text-gray-500 truncate">Laporan Kehilangan IC - Diterima</p>
                        </div>
                        <span class="text-xs font-medium text-gray-400 bg-gray-100 px-2 py-1 rounded-full">32 min</span>
                    </div>

                    <div class="hidden sm:flex p-4 items-center gap-4 hover:bg-gray-50 transition">
                         <div class="w-10 h-10 rounded-full bg-gray-200 flex-shrink-0">
                             <img src="https://ui-avatars.com/api/?name=Raju+Man&background=ef4444&color=fff" class="w-full h-full rounded-full" alt="">
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold text-gray-900 truncate">Insp. Raju</p>
                            <p class="text-xs text-gray-500 truncate">Log Masuk Sistem</p>
                        </div>
                        <span class="text-xs font-medium text-gray-400 bg-gray-100 px-2 py-1 rounded-full">1 jam</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT COLUMN: Quick Actions (Takes up 1/3 width on Desktop) --}}
        <div class="lg:col-span-1">
            <h3 class="text-base font-bold text-gray-800 mb-4 px-1">Tindakan Pantas</h3>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 divide-y divide-gray-100 overflow-hidden">
                
                <a href="#" class="flex items-center justify-between p-4 hover:bg-gray-50 transition group">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center text-blue-900 group-hover:bg-blue-900 group-hover:text-white transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                        </div>
                        <div>
                            <span class="block text-sm font-bold text-gray-700">Daftar Pengguna</span>
                            <span class="text-xs text-gray-400">Cipta akaun pegawai baru</span>
                        </div>
                    </div>
                    <svg class="w-4 h-4 text-gray-300 group-hover:text-blue-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>

                <a href="#" class="flex items-center justify-between p-4 hover:bg-gray-50 transition group">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-indigo-100 flex items-center justify-center text-indigo-900 group-hover:bg-indigo-900 group-hover:text-white transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <div>
                            <span class="block text-sm font-bold text-gray-700">Jana Laporan</span>
                            <span class="text-xs text-gray-400">Muat turun PDF/Excel</span>
                        </div>
                    </div>
                    <svg class="w-4 h-4 text-gray-300 group-hover:text-indigo-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
                
                 <a href="#" class="flex items-center justify-between p-4 hover:bg-gray-50 transition group">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center text-emerald-900 group-hover:bg-emerald-900 group-hover:text-white transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <div>
                            <span class="block text-sm font-bold text-gray-700">Tetapan Sistem</span>
                            <span class="text-xs text-gray-400">Konfigurasi Modul</span>
                        </div>
                    </div>
                    <svg class="w-4 h-4 text-gray-300 group-hover:text-emerald-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>

            </div>
        </div>
    </div>
</div>
@endsection
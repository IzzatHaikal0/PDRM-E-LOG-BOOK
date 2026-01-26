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
            {{-- Dynamic Name from Database --}}
            <p class="text-lg font-semibold text-gray-700">{{ Auth::user()->name ?? 'Kpl. Ahmad Albab' }}</p>
            <div class="text-xs font-medium text-blue-800 bg-blue-50 px-3 py-1 rounded-full border border-blue-100">
                {{ \Carbon\Carbon::now()->translatedFormat('l, d M') }}
            </div>
        </div>
        {{-- Dynamic ID and Station (Optional) --}}
        <p class="text-xs text-gray-400">ID: {{ Auth::user()->badge_number ?? 'RF12345' }} • {{ Auth::user()->station ?? 'IPD Muar' }}</p>
    </div>

    {{-- 2. CALENDAR CARD (WEEKLY ATTENDANCE) --}}
    <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 mb-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-base font-bold text-gray-800 flex items-center gap-2">
                {{-- Calendar Icon --}}
                <svg class="w-5 h-5 text-[#00205B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                Rekod Kehadiran Saya
            </h3>
            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Minggu Ini</span>
        </div>

        {{-- Calendar Grid --}}
        <div class="grid grid-cols-7 gap-2 text-center">
            @php
                // Mock Logic for Display
                $days = [
                    ['day' => 'Isnin', 'date' => '20', 'status' => 'green'],
                    ['day' => 'Selasa', 'date' => '21', 'status' => 'green'],
                    ['day' => 'Rabu', 'date' => '22', 'status' => 'red'], // Absent/No Log
                    ['day' => 'Khamis', 'date' => '23', 'status' => 'green'],
                    ['day' => 'Jumaat', 'date' => '24', 'status' => 'green'],
                    ['day' => 'Sabtu', 'date' => '25', 'status' => 'green'],
                    ['day' => 'Ahad', 'date' => '26', 'status' => 'today'], // Today
                ];
            @endphp

            @foreach($days as $day)
                <div class="flex flex-col items-center gap-1">
                    <span class="text-[10px] text-gray-400 font-medium">{{ substr($day['day'], 0, 3) }}</span>
                    
                    @if($day['status'] == 'green')
                        <div class="w-8 h-8 rounded-full bg-green-100 border border-green-200 flex items-center justify-center text-xs font-bold text-green-700 shadow-sm">
                            {{ $day['date'] }}
                        </div>
                    @elseif($day['status'] == 'red')
                        <div class="w-8 h-8 rounded-full bg-red-100 border border-red-200 flex items-center justify-center text-xs font-bold text-red-700 shadow-sm relative group">
                            {{ $day['date'] }}
                        </div>
                    @elseif($day['status'] == 'today')
                        {{-- Active Today State --}}
                        <div class="w-8 h-8 rounded-full bg-[#00205B] border border-[#00205B] flex items-center justify-center text-xs font-bold text-white shadow-lg ring-2 ring-blue-100 transform scale-110">
                            {{ $day['date'] }}
                        </div>
                    @else
                        {{-- Future Dates --}}
                        <div class="w-8 h-8 rounded-full bg-gray-50 border border-gray-100 flex items-center justify-center text-xs font-medium text-gray-400">
                            {{ $day['date'] }}
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
        
        {{-- Legend --}}
        <div class="flex items-center justify-center gap-4 mt-4 pt-3 border-t border-gray-50">
            <div class="flex items-center gap-1.5">
                <div class="w-2 h-2 rounded-full bg-green-500"></div>
                <span class="text-[10px] text-gray-500">Hadir / Ada Log</span>
            </div>
            <div class="flex items-center gap-1.5">
                <div class="w-2 h-2 rounded-full bg-red-500"></div>
                <span class="text-[10px] text-gray-500">Tiada Rekod</span>
            </div>
        </div>
    </div>

    {{-- 3. PERSONAL STATS GRID --}}
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

    {{-- 4. RECENT LOGS LIST --}}
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
@endsection
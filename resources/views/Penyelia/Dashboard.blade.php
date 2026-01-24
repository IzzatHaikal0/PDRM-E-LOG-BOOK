@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Dashboard Penyelia') }}
    </h2>
@endsection

@section('content')
<div class="py-6 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto pb-24">
    
    {{-- 1. WELCOME HEADER --}}
    <div class="mb-6 flex flex-col gap-1">
        <h1 class="text-2xl font-bold text-[#00205B]">Selamat Datang, Tuan.</h1>
        <div class="flex items-center justify-between">
            <div>
                {{-- Dynamic Name (Fallback to Dummy) --}}
                <p class="text-sm font-semibold text-gray-700">{{ Auth::user()->name ?? 'Sjn. Mejar Halim' }}</p> 
                <p class="text-xs text-gray-400">Penyelia Bertugas • Balai Polis Muar</p>
            </div>
            <div class="text-xs font-medium text-blue-800 bg-blue-50 px-3 py-1 rounded-full border border-blue-100">
                {{ \Carbon\Carbon::now()->translatedFormat('l, d M') }}
            </div>
        </div>
    </div>

    {{-- 2. ACTIONABLE STATS GRID --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
        
        {{-- Card 1: Pending Verification (High Priority) --}}
        {{-- Links to verification route --}}
        <a href="{{ route('Penyelia.VerifyList') }}" class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between relative overflow-hidden group hover:shadow-md transition cursor-pointer">
            <div class="absolute right-0 top-0 w-16 h-16 bg-red-50 rounded-bl-full -mr-2 -mt-2 transition group-hover:bg-red-100"></div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider relative z-10">Perlu Disahkan</p>
                <h3 class="text-2xl font-bold text-red-600 mt-1 relative z-10">5</h3>
            </div>
            <div class="mt-3 flex items-center gap-1 text-[10px] text-red-400 font-medium">
                <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
                Tindakan Segera >
            </div>
        </a>

        {{-- Card 2: Active Staff --}}
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-16 h-16 bg-green-50 rounded-bl-full -mr-2 -mt-2 transition group-hover:bg-green-100"></div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider relative z-10">Anggota Bertugas</p>
                <h3 class="text-2xl font-bold text-green-700 mt-1 relative z-10">12</h3>
            </div>
            <div class="mt-3 text-[10px] text-green-500">
                Sif Semasa (08:00 - 16:00)
            </div>
        </div>

        {{-- Card 3: Today's Total Logs --}}
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between relative overflow-hidden group">
             <div class="absolute right-0 top-0 w-16 h-16 bg-blue-50 rounded-bl-full -mr-2 -mt-2 transition group-hover:bg-blue-100"></div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider relative z-10">Jumlah Log</p>
                <h3 class="text-2xl font-bold text-blue-900 mt-1 relative z-10">42</h3>
            </div>
             <div class="mt-3 text-[10px] text-blue-400">
                Hari Ini
            </div>
        </div>

        {{-- Card 4: Attendance Rate --}}
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between relative overflow-hidden group">
             <div class="absolute right-0 top-0 w-16 h-16 bg-indigo-50 rounded-bl-full -mr-2 -mt-2 transition group-hover:bg-indigo-100"></div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider relative z-10">Kehadiran</p>
                <h3 class="text-2xl font-bold text-indigo-900 mt-1 relative z-10">100%</h3>
            </div>
             <div class="mt-3 text-[10px] text-indigo-400">
                Tiada MC / Cuti Kecemasan
            </div>
        </div>
    </div>

    {{-- 3. QUICK VERIFICATION LIST (Pending Items) --}}
    <div class="space-y-4 mb-8">
        <div class="flex items-center justify-between px-1">
            <h3 class="text-base font-bold text-gray-800 flex items-center gap-2">
                Tugasan Menunggu Pengesahan
                <span class="bg-red-100 text-red-600 text-[10px] font-bold px-2 py-0.5 rounded-full">5</span>
            </h3>
            <a href="#" class="text-xs font-bold text-blue-800 hover:text-blue-600 uppercase tracking-wide">Lihat Semua</a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden divide-y divide-gray-100">
            
            {{-- Item 1 --}}
            <div class="p-4 hover:bg-gray-50 transition">
                <div class="flex justify-between items-start mb-2">
                    <div class="flex items-center gap-3">
                        {{-- Avatar Initials --}}
                        <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-xs font-bold text-gray-600">KA</div>
                        <div>
                            <h4 class="text-sm font-bold text-gray-900">Kpl. Abu Bakar</h4>
                            <p class="text-[10px] text-gray-500">Rondaan MPV • Sektor A</p>
                        </div>
                    </div>
                    <span class="text-[10px] text-gray-400 font-medium">10 min lepas</span>
                </div>
                <div class="pl-13 ml-13">
                    <p class="text-sm text-gray-600 mb-3 bg-gray-50 p-3 rounded-lg border border-gray-100 italic">
                        "Membuat rondaan di kawasan perumahan Taman Bahagia. Keadaan terkawal dan tiada aktiviti mencurigakan."
                    </p>
                    <div class="flex gap-2">
                        <button class="flex-1 bg-[#00205B] text-white text-xs font-bold py-2 rounded-lg hover:bg-blue-900 transition shadow-sm">
                            Sahkan
                        </button>
                        <button class="px-4 bg-white border border-gray-200 text-gray-600 text-xs font-bold py-2 rounded-lg hover:bg-gray-50 transition">
                            Butiran
                        </button>
                    </div>
                </div>
            </div>

            {{-- Item 2 --}}
            <div class="p-4 hover:bg-gray-50 transition">
                <div class="flex justify-between items-start mb-2">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-xs font-bold text-blue-700">SA</div>
                        <div>
                            <h4 class="text-sm font-bold text-gray-900">L/Kpl Siti Aminah</h4>
                            <p class="text-[10px] text-gray-500">Kaunter Aduan • Balai</p>
                        </div>
                    </div>
                    <span class="text-[10px] text-gray-400 font-medium">32 min lepas</span>
                </div>
                <div class="pl-13 ml-13">
                    <p class="text-sm text-gray-600 mb-3 bg-gray-50 p-3 rounded-lg border border-gray-100 italic">
                        "Menerima laporan kehilangan kad pengenalan daripada orang awam. No Repot: MR/123/2026."
                    </p>
                    <div class="flex gap-2">
                        <button class="flex-1 bg-[#00205B] text-white text-xs font-bold py-2 rounded-lg hover:bg-blue-900 transition shadow-sm">
                            Sahkan
                        </button>
                        <button class="px-4 bg-white border border-gray-200 text-gray-600 text-xs font-bold py-2 rounded-lg hover:bg-gray-50 transition">
                            Butiran
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- 4. TEAM OVERVIEW TABLE (Desktop Only) --}}
    <div class="hidden md:block">
        <h3 class="text-base font-bold text-gray-800 mb-4">Senarai Anggota Bawah Seliaan</h3>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tugasan Terkini</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Masa Log</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Kpl. Abu Bakar</td>
                        <td class="px-6 py-4 whitespace-nowrap"><span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Bertugas</span></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rondaan MPV</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">10:30 AM</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">L/Kpl Siti Aminah</td>
                        <td class="px-6 py-4 whitespace-nowrap"><span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Bertugas</span></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Kaunter Aduan</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">10:15 AM</td>
                    </tr>
                     <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Kons. Raju</td>
                        <td class="px-6 py-4 whitespace-nowrap"><span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Cuti Rehat</span></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">-</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">-</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
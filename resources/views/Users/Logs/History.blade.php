@extends('layouts.app')

@section('header')
    <div class="flex items-center justify-between">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Sejarah Aktiviti') }}
        </h2>
        {{-- Filter Icon (Visual Only) --}}
        <button class="p-2 text-gray-400 hover:text-[#00205B]">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
        </button>
    </div>
@endsection

@section('content')
<div class="py-4 px-4 max-w-lg mx-auto pb-24">

    {{-- 1. MONTH SELECTOR (Sticky Top) --}}
    <div class="sticky top-20 z-10 mb-6">
        <div class="bg-white/80 backdrop-blur-md border border-gray-200 shadow-sm rounded-xl p-2 flex items-center justify-between">
            <button class="p-2 text-gray-400 hover:text-[#00205B]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </button>
            <span class="font-bold text-[#00205B] text-sm uppercase tracking-wide">Januari 2026</span>
            <button class="p-2 text-gray-400 hover:text-[#00205B]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </button>
        </div>
    </div>

    {{-- 2. HISTORY LIST --}}
    <div class="space-y-6">

        {{-- GROUP: TODAY --}}
        <div>
            <div class="flex items-center gap-2 mb-3 px-1">
                <span class="w-2 h-2 rounded-full bg-[#00205B]"></span>
                <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider">Hari Ini</h3>
            </div>
            
            <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
                <div class="divide-y divide-gray-100">
                    
                    {{-- Item 1: Pending --}}
                    <div class="p-4 flex gap-4 hover:bg-gray-50 transition relative overflow-hidden">
                        {{-- Status Stripe --}}
                        <div class="absolute left-0 top-0 bottom-0 w-1 bg-yellow-400"></div>
                        
                        {{-- Time --}}
                        <div class="flex flex-col items-center gap-1 shrink-0 w-12 pt-1">
                            <span class="text-sm font-bold text-gray-900">14:30</span>
                            <span class="text-[10px] text-gray-400">PTG</span>
                        </div>

                        {{-- Details --}}
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-start mb-1">
                                <h4 class="text-sm font-bold text-gray-900 truncate">Tugas Pejabat</h4>
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-yellow-100 text-yellow-800">
                                    Dalam Proses
                                </span>
                            </div>
                            <p class="text-xs text-gray-500 line-clamp-2">Mengemaskini fail siasatan kes jenayah komersial di pejabat pertanyaan.</p>
                            <div class="mt-2 flex items-center gap-2">
                                <div class="flex items-center text-[10px] text-gray-400 bg-gray-50 px-2 py-1 rounded">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    Insp. Razak
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Item 2: Approved --}}
                    <div class="p-4 flex gap-4 hover:bg-gray-50 transition relative overflow-hidden">
                        <div class="absolute left-0 top-0 bottom-0 w-1 bg-green-500"></div>
                        
                        <div class="flex flex-col items-center gap-1 shrink-0 w-12 pt-1">
                            <span class="text-sm font-bold text-gray-900">08:00</span>
                            <span class="text-[10px] text-gray-400">PAGI</span>
                        </div>

                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-start mb-1">
                                <h4 class="text-sm font-bold text-gray-900 truncate">Lapor Masuk</h4>
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-green-100 text-green-800">
                                    Disahkan
                                </span>
                            </div>
                            <p class="text-xs text-gray-500 line-clamp-1">Melapor diri masuk tugas Sif A.</p>
                            <div class="mt-2 text-[10px] text-green-600 flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Disahkan oleh Sistem
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- GROUP: YESTERDAY --}}
        <div>
            <div class="flex items-center gap-2 mb-3 px-1">
                <span class="w-2 h-2 rounded-full bg-gray-300"></span>
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Semalam, 21 Jan</h3>
            </div>
            
            <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
                <div class="divide-y divide-gray-100">
                    
                    {{-- Item 3: Approved --}}
                    <div class="p-4 flex gap-4 hover:bg-gray-50 transition relative overflow-hidden">
                        <div class="absolute left-0 top-0 bottom-0 w-1 bg-green-500"></div>
                        
                        <div class="flex flex-col items-center gap-1 shrink-0 w-12 pt-1">
                            <span class="text-sm font-bold text-gray-900">22:00</span>
                            <span class="text-[10px] text-gray-400">MLM</span>
                        </div>

                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-start mb-1">
                                <h4 class="text-sm font-bold text-gray-900 truncate">Rondaan URB</h4>
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-green-100 text-green-800">
                                    Disahkan
                                </span>
                            </div>
                            <p class="text-xs text-gray-500 line-clamp-2">Rondaan cegah jenayah di kawasan perumahan Taman Bunga Raya.</p>
                             <div class="mt-2 flex items-center gap-2">
                                <div class="flex items-center text-[10px] text-gray-400 bg-gray-50 px-2 py-1 rounded">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    Sjn. Mejar Halim
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Item 4: Rejected --}}
                    <div class="p-4 flex gap-4 hover:bg-gray-50 transition relative overflow-hidden bg-red-50/30">
                        <div class="absolute left-0 top-0 bottom-0 w-1 bg-red-500"></div>
                        
                        <div class="flex flex-col items-center gap-1 shrink-0 w-12 pt-1">
                            <span class="text-sm font-bold text-gray-900">10:00</span>
                            <span class="text-[10px] text-gray-400">PAGI</span>
                        </div>

                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-start mb-1">
                                <h4 class="text-sm font-bold text-gray-900 truncate">Latihan Menembak</h4>
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-red-100 text-red-800">
                                    Ditolak
                                </span>
                            </div>
                            <p class="text-xs text-gray-500 line-clamp-2">Latihan tahunan di Lapang Sasar IPD.</p>
                            <div class="mt-2 flex items-start gap-1 p-2 bg-red-50 rounded border border-red-100">
                                <svg class="w-3 h-3 text-red-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span class="text-[10px] text-red-700 leading-tight">Sila lampirkan gambar kehadiran. Sila buat semula.</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>

    {{-- Empty State (Hidden by default, show if count is 0) --}}
    {{-- 
    <div class="flex flex-col items-center justify-center py-12">
        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <p class="text-gray-500 font-medium text-sm">Tiada rekod dijumpai.</p>
    </div> 
    --}}

</div>
@endsection
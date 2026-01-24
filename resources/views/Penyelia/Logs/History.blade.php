@extends('layouts.app')

@section('header')
    <div class="flex items-center justify-between">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Sejarah Aktiviti') }}
        </h2>
        {{-- Filter Button --}}
        <button class="p-2 text-gray-400 hover:text-[#00205B]">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
        </button>
    </div>
@endsection

@section('content')
<div class="py-4 px-4 max-w-lg mx-auto pb-24">

    {{-- 1. MONTH SELECTOR (Static for now, can be made dynamic later) --}}
    <div class="sticky top-20 z-10 mb-6">
        <div class="bg-white/80 backdrop-blur-md border border-gray-200 shadow-sm rounded-xl p-2 flex items-center justify-between">
            <button class="p-2 text-gray-400 hover:text-[#00205B]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </button>
            <span class="font-bold text-[#00205B] text-sm uppercase tracking-wide">{{ now()->translatedFormat('F Y') }}</span>
            <button class="p-2 text-gray-400 hover:text-[#00205B]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </button>
        </div>
    </div>

    {{-- 2. HISTORY LIST --}}
    <div class="space-y-6">

        @forelse($logs as $date => $dailyLogs)
            {{-- GROUP HEADER --}}
            <div>
                <div class="flex items-center gap-2 mb-3 px-1">
                    <span class="w-2 h-2 rounded-full bg-[#00205B]"></span>
                    <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider">
                        @if($date == now()->format('Y-m-d'))
                            Hari Ini
                        @elseif($date == now()->subDay()->format('Y-m-d'))
                            Semalam
                        @else
                            {{ \Carbon\Carbon::parse($date)->translatedFormat('d M Y, l') }}
                        @endif
                    </h3>
                </div>
                
                <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
                    <div class="divide-y divide-gray-100">
                        
                        @foreach($dailyLogs as $log)
                            {{-- LOG ITEM --}}
                            <div class="p-4 flex gap-4 hover:bg-gray-50 transition relative overflow-hidden {{ $log->status == 'rejected' ? 'bg-red-50/30' : '' }}">
                                
                                {{-- Status Stripe Color Logic --}}
                                @php
                                    $stripeColor = 'bg-yellow-400'; // Default Pending
                                    $badgeClass = 'bg-yellow-100 text-yellow-800';
                                    $statusText = 'Dalam Proses';

                                    if($log->status == 'approved') {
                                        $stripeColor = 'bg-green-500';
                                        $badgeClass = 'bg-green-100 text-green-800';
                                        $statusText = 'Disahkan';
                                    } elseif($log->status == 'rejected') {
                                        $stripeColor = 'bg-red-500';
                                        $badgeClass = 'bg-red-100 text-red-800';
                                        $statusText = 'Ditolak';
                                    }
                                @endphp

                                <div class="absolute left-0 top-0 bottom-0 w-1 {{ $stripeColor }}"></div>
                                
                                {{-- Time --}}
                                <div class="flex flex-col items-center gap-1 shrink-0 w-12 pt-1">
                                    <span class="text-sm font-bold text-gray-900">{{ \Carbon\Carbon::parse($log->time)->format('H:i') }}</span>
                                    <span class="text-[10px] text-gray-400">JAM</span>
                                </div>

                                {{-- Details --}}
                                <div class="flex-1 min-w-0">
                                    <div class="flex justify-between items-start mb-1">
                                        <h4 class="text-sm font-bold text-gray-900 truncate">{{ $log->type }}</h4>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium {{ $badgeClass }}">
                                            {{ $statusText }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-gray-500 line-clamp-2">{{ $log->remarks }}</p>
                                    
                                    {{-- Officer or Rejection Reason --}}
                                    <div class="mt-2">
                                        @if($log->status == 'rejected')
                                            <div class="flex items-start gap-1 p-2 bg-red-50 rounded border border-red-100">
                                                <svg class="w-3 h-3 text-red-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                <span class="text-[10px] text-red-700 leading-tight">{{ $log->rejection_reason ?? 'Tiada sebab dinyatakan.' }}</span>
                                            </div>
                                        @else
                                            <div class="flex items-center gap-2">
                                                <div class="flex items-center text-[10px] text-gray-400 bg-gray-50 px-2 py-1 rounded">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                                    {{ $log->officer->name ?? 'Pegawai' }}
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        @empty
            {{-- Empty State --}}
            <div class="flex flex-col items-center justify-center py-12">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <p class="text-gray-500 font-medium text-sm">Tiada rekod aktiviti dijumpai.</p>
                <a href="{{ route('logs.create') }}" class="mt-4 px-4 py-2 bg-blue-50 text-blue-700 rounded-lg text-xs font-bold uppercase tracking-wider hover:bg-blue-100">
                    + Rekod Baru
                </a>
            </div>
        @endforelse

    </div>
</div>
@endsection
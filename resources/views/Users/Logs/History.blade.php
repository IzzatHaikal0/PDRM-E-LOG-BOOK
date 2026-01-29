@extends('layouts.app')

@section('content')
<div class="py-6 px-4 max-w-lg mx-auto pb-24">

    {{-- 1. HEADER & ACTIONS --}}
    <div class="mb-6">
        <div class="flex items-center justify-between mb-4">
            {{-- Left Side: Title & Date --}}
            <div>
                <h2 class="font-bold text-xl text-[#00205B]">Sejarah Aktiviti</h2>
                <div class="text-xs text-gray-400">
                    {{ now()->translatedFormat('F Y') }}
                </div>
            </div>

            {{-- CHANGED: Redirects to Report Page --}}
            <a href="{{ route('Users.Logs.Report') }}" class="flex items-center gap-2 px-4 py-2 bg-white border border-blue-200 text-blue-700 text-xs font-bold rounded-xl hover:bg-blue-50 transition shadow-sm active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Laporan & Statistik
            </a>
        </div>

        {{-- Search Input Area --}}
        <div class="relative">
            <input type="text" id="searchInput" onkeyup="filterLogs()" placeholder="Cari aktiviti (cth: Cuti, Rondaan)..." 
                   class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 bg-white text-sm focus:ring-2 focus:ring-[#00205B] focus:border-[#00205B] placeholder-gray-400 shadow-sm transition">
            
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
        </div>
    </div>

    {{-- 2. TAB BUTTONS --}}
    <div class="flex p-1 mb-6 bg-gray-100 rounded-xl border border-gray-200">
        <button onclick="switchTab('pending')" id="tab-pending" 
                class="flex-1 py-2.5 text-xs font-bold rounded-lg shadow-sm bg-white text-[#00205B] border border-gray-100 transition-all duration-200">
            Tugasan Semasa
        </button>
        <button onclick="switchTab('verified')" id="tab-verified" 
                class="flex-1 py-2.5 text-xs font-medium rounded-lg text-gray-500 hover:text-gray-900 transition-all duration-200">
            Selesai / Sejarah
        </button>
    </div>

    {{-- 3. CONTENT AREA --}}
    
    {{-- === VIEW A: PENDING / ONGOING === --}}
    <div id="view-pending" class="space-y-6 animate-fade-in">
        @php $hasPending = false; @endphp

        @foreach($logs as $date => $dailyLogs)
            @php
                $activeItems = $dailyLogs->filter(fn($log) => !in_array($log->status, ['approved', 'rejected']));
            @endphp

            @if($activeItems->isNotEmpty())
                @php $hasPending = true; @endphp
                <div class="log-group">
                    <div class="flex items-center gap-2 mb-3 px-1">
                        <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                        <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider">
                            {{ \Carbon\Carbon::parse($date)->translatedFormat('d M Y, l') }}
                        </h3>
                    </div>

                    <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden divide-y divide-gray-100">
                        @foreach($activeItems as $log)
                            @php
                                $isOffDuty = in_array($log->type, ['Cuti Sakit', 'Cuti Rehat', 'Kecemasan', 'Off Day']);
                                $isOngoing = $log->status === 'ongoing'; 
                                $stripeColor = 'bg-yellow-400';
                                if ($isOngoing) $stripeColor = 'bg-blue-500';
                                if ($isOffDuty) $stripeColor = 'bg-red-500';
                            @endphp

                            <div class="log-card-item p-4 flex gap-4 hover:bg-gray-50 transition relative overflow-hidden {{ $isOffDuty ? 'bg-red-50/30' : '' }}">
                                <div class="absolute left-0 top-0 bottom-0 w-1 {{ $stripeColor }}"></div>

                                <div class="flex flex-col items-center gap-1 shrink-0 w-12 pt-1">
                                    <span class="text-sm font-bold {{ $isOffDuty ? 'text-red-600' : 'text-gray-900' }}">
                                        {{ \Carbon\Carbon::parse($log->time)->format('H:i') }}
                                    </span>
                                    <span class="text-[10px] text-gray-400">MULA</span>
                                </div>

                                <div class="flex-1 min-w-0">
                                    <div class="flex justify-between items-start mb-1">
                                        <div class="flex flex-col">
                                            <h4 class="text-sm font-bold {{ $isOffDuty ? 'text-red-600' : 'text-gray-900' }} truncate">
                                                {{ $log->type }}
                                            </h4>
                                            @if($isOffDuty)
                                                <span class="w-fit mt-0.5 px-1.5 py-0.5 rounded text-[9px] font-bold bg-red-100 text-red-600 border border-red-200 uppercase tracking-wide">OFF DUTY</span>
                                            @endif
                                        </div>
                                        
                                        @if($isOngoing)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-blue-100 text-blue-800 animate-pulse">
                                                Sedang Berjalan
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-yellow-100 text-yellow-800">
                                                Dalam Proses
                                            </span>
                                        @endif
                                    </div>

                                    <p class="text-xs {{ $isOffDuty ? 'text-red-400' : 'text-gray-500' }} line-clamp-2 mt-1">
                                        {{ $log->remarks }}
                                    </p>
                                    
                                    <div class="mt-3">
                                        @if($isOngoing)
                                            <form action="{{ route('logs.end_task', $log->id) }}" method="POST" class="bg-blue-50 p-3 rounded-lg border border-blue-100 mt-2">
                                                @csrf
                                                @method('PATCH')
                                                <div class="flex flex-col gap-2">
                                                    <label class="text-[10px] font-bold text-blue-800 uppercase">Masukkan Masa Tamat:</label>
                                                    <div class="flex gap-2">
                                                        <input type="time" name="end_time" required 
                                                               value="{{ now()->format('H:i') }}"
                                                               class="block w-full px-2 py-1.5 bg-white border border-blue-200 rounded-lg text-sm focus:ring-blue-900 focus:border-blue-900 shadow-sm">
                                                        
                                                        <button type="submit" class="px-3 py-1.5 bg-[#00205B] text-white text-xs font-bold rounded-lg hover:bg-blue-900 shadow-sm transition transform active:scale-95">
                                                            Hantar
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        @else
                                            <div class="flex items-center gap-4">
                                                @if($log->end_time)
                                                    <div class="flex items-center gap-1 text-[10px] text-gray-500 bg-gray-50 px-2 py-1 rounded border border-gray-100">
                                                        <span class="font-bold">Tamat:</span> {{ \Carbon\Carbon::parse($log->end_time)->format('H:i') }}
                                                    </div>
                                                @endif
                                                
                                                <a href="{{ route('logs.create') }}" class="ml-auto flex items-center gap-1 px-3 py-1.5 bg-white hover:bg-gray-50 text-gray-700 rounded-lg border border-gray-200 text-xs font-bold transition shadow-sm">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                                    Ubah
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach

        @if(!$hasPending)
            <div class="flex flex-col items-center justify-center py-12 text-center">
                <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mb-3">
                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <p class="text-gray-500 text-xs">Tiada tugasan semasa.</p>
                <a href="{{ route('logs.create') }}" class="mt-4 text-xs font-bold text-blue-600 hover:underline">
                    + Tambah Rekod Baru
                </a>
            </div>
        @endif
    </div>

    {{-- === VIEW B: VERIFIED (Selesai/Sejarah) === --}}
    <div id="view-verified" class="space-y-6 hidden animate-fade-in">
        @php $hasVerified = false; @endphp

        @foreach($logs as $date => $dailyLogs)
            @php
                $verifiedItems = $dailyLogs->filter(fn($log) => $log->status === 'approved' || $log->status === 'rejected');
            @endphp

            @if($verifiedItems->isNotEmpty())
                @php $hasVerified = true; @endphp
                <div class="log-group">
                    <div class="flex items-center gap-2 mb-3 px-1">
                        <span class="w-2 h-2 rounded-full bg-[#00205B]"></span>
                        <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider">
                            {{ \Carbon\Carbon::parse($date)->translatedFormat('d M Y, l') }}
                        </h3>
                    </div>

                    <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden divide-y divide-gray-100">
                        @foreach($verifiedItems as $log)
                            @php
                                $isOffDuty = in_array($log->type, ['Cuti Sakit', 'Cuti Rehat', 'Kecemasan', 'Off Day']);
                                $statusBadgeClass = $log->status == 'approved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800';
                                $statusText = $log->status == 'approved' ? 'Disahkan' : 'Ditolak';
                                $stripeColor = $log->status == 'approved' ? 'bg-green-500' : 'bg-red-500';
                                if($isOffDuty) $stripeColor = 'bg-red-500';
                            @endphp

                            <div class="log-card-item p-4 flex gap-4 hover:bg-gray-50 transition relative overflow-hidden {{ $isOffDuty ? 'bg-red-50/20' : '' }}">
                                <div class="absolute left-0 top-0 bottom-0 w-1 {{ $stripeColor }}"></div>

                                <div class="flex flex-col items-center gap-1 shrink-0 w-12 pt-1">
                                    <span class="text-sm font-bold {{ $isOffDuty ? 'text-red-600' : 'text-gray-900' }}">
                                        {{ \Carbon\Carbon::parse($log->time)->format('H:i') }}
                                    </span>
                                    <span class="text-[10px] text-gray-400">MULA</span>
                                </div>

                                <div class="flex-1 min-w-0">
                                    <div class="flex justify-between items-start mb-1">
                                        <h4 class="text-sm font-bold {{ $isOffDuty ? 'text-red-600' : 'text-gray-900' }} truncate">
                                            {{ $log->type }}
                                        </h4>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium {{ $statusBadgeClass }}">
                                            {{ $statusText }}
                                        </span>
                                    </div>
                                    <p class="text-xs {{ $isOffDuty ? 'text-red-400' : 'text-gray-500' }} line-clamp-2 mt-1">
                                        {{ $log->remarks }}
                                    </p>

                                    @if($log->end_time)
                                    <div class="mt-2 text-[10px] text-gray-500 flex items-center gap-2">
                                        <span class="font-bold">Tamat: {{ \Carbon\Carbon::parse($log->end_time)->format('H:i') }}</span>
                                    </div>
                                    @endif

                                    <div class="mt-2 text-[10px] text-gray-400 flex items-center gap-1">
                                        @if($log->status == 'approved')
                                            <svg class="w-3 h-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            {{ $log->officer->name ?? 'Disahkan oleh Penyelia' }}
                                        @elseif($log->status == 'rejected')
                                            <svg class="w-3 h-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            {{ $log->rejection_reason ?? 'Ditolak' }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach

        @if(!$hasVerified)
            <div class="flex flex-col items-center justify-center py-12 text-center">
                <p class="text-gray-500 text-xs">Tiada sejarah tugasan terdahulu.</p>
            </div>
        @endif
    </div>

</div>

{{-- SCRIPT: TAB SWITCHING, SEARCH & MOCK DOWNLOAD --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // --- 1. MOCK DOWNLOAD FUNCTION (UI Only) ---
    function mockDownloadPDF() {
        Swal.fire({
            title: 'Menjana PDF...',
            text: 'Sila tunggu sebentar sementara dokumen anda disediakan.',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        setTimeout(() => {
            Swal.fire({
                icon: 'success',
                title: 'Berjaya!',
                text: 'Laporan aktiviti anda telah dimuat turun.',
                timer: 2000,
                showConfirmButton: false
            });
        }, 2000);
    }

    // --- 2. TAB SWITCHING ---
    function switchTab(tab) {
        const viewPending = document.getElementById('view-pending');
        const viewVerified = document.getElementById('view-verified');
        const tabPending = document.getElementById('tab-pending');
        const tabVerified = document.getElementById('tab-verified');

        const activeClasses = ['bg-white', 'text-[#00205B]', 'shadow-sm', 'font-bold', 'border-gray-100'];
        const inactiveClasses = ['text-gray-500', 'font-medium', 'bg-transparent', 'shadow-none', 'border-transparent'];

        if (tab === 'pending') {
            viewPending.classList.remove('hidden');
            viewVerified.classList.add('hidden');
            
            tabPending.classList.add(...activeClasses);
            tabPending.classList.remove(...inactiveClasses);
            
            tabVerified.classList.remove(...activeClasses);
            tabVerified.classList.add(...inactiveClasses);
        } else {
            viewVerified.classList.remove('hidden');
            viewPending.classList.add('hidden');

            tabVerified.classList.add(...activeClasses);
            tabVerified.classList.remove(...inactiveClasses);
            
            tabPending.classList.remove(...activeClasses);
            tabPending.classList.add(...inactiveClasses);
        }
    }

    // --- 3. FILTER LOGS ---
    function filterLogs() {
        const input = document.getElementById('searchInput').value.toLowerCase();
        const activeViewId = document.getElementById('view-pending').classList.contains('hidden') ? 'view-verified' : 'view-pending';
        const container = document.getElementById(activeViewId);
        const cards = container.querySelectorAll('.log-card-item');

        cards.forEach(card => {
            const text = card.innerText.toLowerCase();
            if (text.includes(input)) {
                card.style.display = "";
            } else {
                card.style.display = "none";
            }
        });
    }
</script>

<style>
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(5px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fade-in 0.2s ease-out forwards;
    }
</style>
@endsection
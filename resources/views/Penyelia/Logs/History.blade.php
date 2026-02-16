@extends('layouts.app')

@section('content')
<div class="py-6 px-4 max-w-lg mx-auto pb-24">

    {{-- 1. HEADER & ACTIONS --}}
    <div class="mb-6">
        <div class="flex items-end justify-between mb-4">
            <div>
                <h2 class="font-bold text-xl text-[#00205B]">Sejarah Aktiviti</h2>
                <div class="text-xs text-gray-400">
                    {{-- Optional description --}}
                </div>
                
                {{-- DATE & MONTH PICKER WITH CLEAR BUTTON --}}
                <form action="{{ route('logs.history') }}" method="GET" class="mt-1 flex flex-col sm:flex-row sm:items-center gap-2">
                    
                    {{-- 1. MONTH PICKER --}}
                    <div class="relative max-w-[150px]" title="Tapis ikut Bulan">
                        <div class="absolute inset-y-0 left-0 pl-2 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <input type="month" 
                            name="filter_month" 
                            id="monthInput"
                            value="{{ $filterMonth }}" 
                            {{-- FIX: Added check to ensure dateInput exists before clearing --}}
                            onchange="document.getElementById('dateInput').value = ''; this.form.submit()" 
                            class="block w-full pl-8 pr-2 py-1 text-xs font-bold text-gray-600 bg-gray-100 border-none rounded-lg focus:ring-0 cursor-pointer hover:bg-gray-200 transition">
                    </div>

                    {{-- 2. DATE PICKER --}}
                    <div class="relative max-w-[150px]">
                        <div class="absolute inset-y-0 left-0 pl-2 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        
                        {{-- FIX: Added id="dateInput" here --}}
                        <input type="date" 
                            name="filter_date" 
                            id="dateInput"
                            value="{{ $filterDate }}" 
                            onchange="document.getElementById('monthInput').value = ''; this.form.submit()" 
                            class="block w-full pl-8 pr-2 py-1 text-xs font-bold text-gray-600 bg-gray-100 border-none rounded-lg focus:ring-0 cursor-pointer hover:bg-gray-200 transition">
                    </div>

                    {{-- Clear Button --}}

                        <a href="{{ route('logs.history') }}" 
                        class="p-1.5 rounded-full bg-gray-200 hover:bg-red-100 text-gray-500 hover:text-red-600 transition shadow-sm self-start sm:self-center" 
                        title="Reset ke Bulan Semasa">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </a>

                </form>
            </div>

            <a href="{{ route('Penyelia.Logs.Report') }}" class="flex items-center gap-2 px-4 py-2 bg-white border border-blue-200 text-blue-700 text-xs font-bold rounded-xl hover:bg-blue-50 transition shadow-sm active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Laporan
            </a>
        </div>

        {{-- Search Bar --}}
        <div class="relative">
            <input type="text" id="searchInput" onkeyup="filterLogs()" placeholder="Cari aktiviti..." 
                   class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 bg-white text-sm focus:ring-2 focus:ring-[#00205B] focus:border-[#00205B] placeholder-gray-400 shadow-sm transition">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
        </div>
    </div>

    {{-- 2. TAB BUTTONS --}}
    <div class="flex p-1 mb-6 bg-gray-100 rounded-xl border border-gray-200 gap-1">
        <button onclick="switchTab('draft')" id="tab-draft" 
                class="flex-1 py-2.5 text-[10px] sm:text-xs font-bold rounded-lg shadow-sm bg-white text-[#00205B] border border-gray-100 transition-all">
            Draf (Disimpan)
        </button>
        <button onclick="switchTab('sent')" id="tab-sent" 
                class="flex-1 py-2.5 text-[10px] sm:text-xs font-medium rounded-lg text-gray-500 hover:text-gray-900 transition-all">
            Dihantar
        </button>
        <button onclick="switchTab('history')" id="tab-history" 
                class="flex-1 py-2.5 text-[10px] sm:text-xs font-medium rounded-lg text-gray-500 hover:text-gray-900 transition-all">
            Sejarah
        </button>
    </div>

    {{-- 3. CONTENT AREAS --}}
    
    {{-- === VIEW A: DRAFTS (Disimpan) === --}}
    <div id="view-draft" class="space-y-6 animate-fade-in">
        
        {{-- Flatten logs to check total drafts --}}
        @php
            $allDrafts = $logs->flatten()->filter(fn($log) => $log->status === 'draft');
        @endphp

        {{-- GLOBAL ACTION BAR --}}
        @if($allDrafts->isNotEmpty())
            <div class="bg-blue-50 border border-blue-100 rounded-2xl p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-sm">
                <div>
                    <h3 class="text-sm font-bold text-blue-900">Tugasan Belum Dihantar</h3>
                    <p class="text-xs text-blue-600 mt-0.5">
                        Terdapat <span class="font-bold">{{ $allDrafts->count() }}</span> tugasan draf
                        {{-- Conditional Text for Month Filter --}}
                        @if($filterMonth)
                            pada bulan <span class="font-bold uppercase">{{ \Carbon\Carbon::parse($filterMonth)->translatedFormat('F') }}</span>
                        @endif

                        {{-- Optional: Handle Date Filter too if you want --}}
                        @if($filterDate)
                            pada <span class="font-bold">{{ \Carbon\Carbon::parse($filterDate)->translatedFormat('d M') }}</span>
                        @endif
                        .
                    </p>
                </div>

                <form action="{{ route('logs.batch_submit') }}" method="POST" class="w-full sm:w-auto">
                    @csrf
                    @method('PATCH')
                    @foreach($allDrafts as $draft)
                        <input type="hidden" name="log_ids[]" value="{{ $draft->id }}">
                    @endforeach

                    <button type="submit" class="w-full sm:w-auto flex justify-center items-center gap-2 px-5 py-2.5 bg-[#00205B] text-white text-xs font-bold rounded-xl hover:bg-blue-900 shadow-md transition transform active:scale-95">
                        <span>Hantar Semua</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                    </button>
                </form>
            </div>
        @endif

        {{-- DAILY LISTING --}}
        @foreach($logs as $date => $dailyLogs)
            @php $draftItems = $dailyLogs->filter(fn($log) => $log->status === 'draft'); @endphp

            @if($draftItems->isNotEmpty())
                <div class="log-group">
                    <div class="flex items-center gap-2 mb-3 px-1">
                        <span class="w-2 h-2 rounded-full bg-gray-400"></span>
                        <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider">
                            {{ \Carbon\Carbon::parse($date)->translatedFormat('d M Y, l') }}
                        </h3>
                    </div>

                    <div class="bg-white border border-gray-200 border-dashed rounded-2xl shadow-sm overflow-hidden divide-y divide-gray-100">
                        @foreach($draftItems as $log)
                            <div class="log-card-item p-4 flex gap-4 hover:bg-gray-50 transition relative overflow-hidden bg-gray-50/50">
                                
                                {{-- Visual Indicator --}}
                               <div class="absolute left-0 top-0 bottom-0 w-1 {{ $log->is_off_duty ? 'bg-red-500' : 'bg-gray-300' }}"></div>

                                {{-- Time Display --}}
                                <div class="flex flex-col items-center gap-1 shrink-0 w-12 pt-1">
                                    <span class="text-sm font-bold text-gray-600">
                                        {{ \Carbon\Carbon::parse($log->time)->format('H:i') }}
                                    </span>
                                    <span class="text-[10px] text-gray-400">MULA</span>
                                </div>

                                {{-- Content Area --}}
                                <div class="flex-1 min-w-0">
                                    <div class="flex justify-between items-start mb-1">
                                        <div class="flex items-center gap-2 overflow-hidden">
                                        {{-- Red Text if Off Duty --}}
                                        <h4 class="text-sm font-bold truncate {{ $log->is_off_duty ? 'text-red-600' : 'text-gray-800' }}">
                                            {{ $log->type }}
                                        </h4>

                                        {{-- Off Duty Badge --}}
                                        @if($log->is_off_duty)
                                            <span class="shrink-0 inline-flex items-center px-1.5 py-0.5 rounded text-[9px] font-bold bg-red-100 text-red-600 border border-red-200">
                                                OFF DUTY
                                            </span>
                                        @endif

                                        </div>


                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-gray-200 text-gray-600">Draf</span>
                                    </div>
                                    <p class="text-xs line-clamp-2 mt-1 {{ $log->is_off_duty ? 'text-red-600 font-medium' : 'text-gray-500' }}">
                                        {{ $log->remarks }}
                                    </p>
                                    
                                    {{-- [RESTORED] END TIME INPUTS --}}
                                    <div class="mt-4 pt-3 border-t border-gray-200/60">
                                        {{-- Form to Update End Time & Send --}}
                                        <form action="{{ route('logs.end_task', $log->id) }}" method="POST" class="flex flex-col gap-3">
                                            @csrf
                                            @method('PATCH')
                                            
                                            <div class="grid grid-cols-2 gap-2">
                                                <div class="flex flex-col gap-1">
                                                    <label class="text-[10px] font-bold text-gray-500 uppercase">Tarikh Tamat</label>
                                                    <input type="date" name="end_date" value="{{ $log->date }}" class="block w-full px-2 py-2 bg-white border border-gray-300 rounded-lg text-xs shadow-sm focus:ring-[#00205B] focus:border-[#00205B]">
                                                </div>
                                                <div class="flex flex-col gap-1">
                                                    <label class="text-[10px] font-bold text-gray-500 uppercase">Masa Tamat</label>
                                                    <input type="time" name="end_time" value="{{ now()->format('H:i') }}" class="block w-full px-2 py-2 bg-white border border-gray-300 rounded-lg text-xs shadow-sm focus:ring-[#00205B] focus:border-[#00205B]">
                                                </div>
                                            </div>

                                            <div class="flex gap-2">
                                                <a href="{{ route('logs.edit', $log->id) }}" class="flex-1 px-3 py-2 bg-white border border-gray-300 text-gray-700 text-xs font-bold rounded-lg hover:bg-gray-50 text-center">
                                                    Ubah
                                                </a>
                                                <button type="submit" class="flex-[2] px-3 py-2 bg-[#00205B] text-white text-xs font-bold rounded-lg hover:bg-blue-900 shadow-sm flex justify-center items-center gap-2">
                                                    <span>Hantar</span>
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                    {{-- END RESTORED SECTION --}}

                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach

        @if($allDrafts->isEmpty())
            <div class="flex flex-col items-center justify-center py-12 text-center">
                <p class="text-gray-500 text-xs">Tiada draf untuk bulan ini.</p>
                <a href="{{ route('logs.create') }}" class="mt-4 text-xs font-bold text-blue-600 hover:underline">+ Cipta Tugasan Baru</a>
            </div>
        @endif
    </div>

    {{-- === VIEW B: SENT / PENDING (Dihantar ke Penyelia LAIN) === --}}
    <div id="view-sent" class="space-y-6 hidden animate-fade-in">
        @php $hasSent = false; @endphp

        @foreach($logs as $date => $dailyLogs)
            @php $sentItems = $dailyLogs->filter(fn($log) => $log->status === 'pending'); @endphp

            @if($sentItems->isNotEmpty())
                @php $hasSent = true; @endphp
                <div class="log-group">
                    <div class="flex items-center gap-2 mb-3 px-1">
                        <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                        <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider">
                            {{ \Carbon\Carbon::parse($date)->translatedFormat('d M Y, l') }}
                        </h3>
                    </div>

                    <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden divide-y divide-gray-100">
                        @foreach($sentItems as $log)
                            <div class="log-card-item p-4 flex gap-4 hover:bg-gray-50 transition relative overflow-hidden">
                                <div class="absolute left-0 top-0 bottom-0 w-1 {{ $log->is_off_duty ? 'bg-red-500' : 'bg-yellow-400' }}"></div>

                                <div class="flex flex-col items-center gap-1 shrink-0 w-12 pt-1">
                                    <span class="text-sm font-bold text-gray-900">{{ \Carbon\Carbon::parse($log->time)->format('H:i') }}</span>
                                </div>

                                <div class="flex-1 min-w-0">
                                    <div class="flex justify-between items-start mb-1">
                                        <div class="flex items-center gap-2 overflow-hidden">
                                            {{-- [UPDATED] Red Text --}}
                                            <h4 class="text-sm font-bold truncate {{ $log->is_off_duty ? 'text-red-600' : 'text-gray-900' }}">
                                                {{ $log->type }}
                                            </h4>

                                            {{-- [NEW] Badge --}}
                                            @if($log->is_off_duty)
                                                <span class="shrink-0 inline-flex items-center px-1.5 py-0.5 rounded text-[9px] font-bold bg-red-100 text-red-600 border border-red-200">
                                                    OFF DUTY
                                                </span>
                                            @endif
                                        </div>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-yellow-100 text-yellow-800">
                                            Menunggu Pengesahan
                                        </span>
                                    </div>
                                    <p class="text-xs line-clamp-2 mt-1 {{ $log->is_off_duty ? 'text-red-600 font-medium' : 'text-gray-500' }}">
                                        {{ $log->remarks }}
                                    </p>

                                    <div class="mt-3 flex justify-end">
                                        <a href="{{ route('logs.edit', $log->id) }}" class="flex items-center gap-1 px-3 py-1.5 bg-white hover:bg-gray-50 text-gray-700 rounded-lg border border-gray-200 text-xs font-bold transition shadow-sm">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                            Ubah
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach

        @if(!$hasSent)
            <div class="flex flex-col items-center justify-center py-12 text-center">
                <p class="text-gray-500 text-xs">Tiada tugasan yang sedang menunggu pengesahan.</p>
            </div>
        @endif
    </div>

    {{-- === VIEW C: HISTORY (Approved/Rejected) === --}}
    <div id="view-history" class="space-y-6 hidden animate-fade-in">
        @php $hasHistory = false; @endphp

        @foreach($logs as $date => $dailyLogs)
            @php $historyItems = $dailyLogs->filter(fn($log) => in_array($log->status, ['approved', 'rejected'])); @endphp

            @if($historyItems->isNotEmpty())
                @php $hasHistory = true; @endphp
                <div class="log-group">
                    <div class="flex items-center gap-2 mb-3 px-1">
                        <span class="w-2 h-2 rounded-full bg-[#00205B]"></span>
                        <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider">
                            {{ \Carbon\Carbon::parse($date)->translatedFormat('d M Y, l') }}
                        </h3>
                    </div>

                    <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden divide-y divide-gray-100">
                        @foreach($historyItems as $log)
                            @php
                                $isApproved = $log->status === 'approved';
                                $stripeColor = $isApproved ? 'bg-green-500' : 'bg-red-500';
                                $badgeClass = $isApproved ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800';
                                $badgeText = $isApproved ? 'Disahkan' : 'Ditolak';
                            @endphp

                            <div class="log-card-item p-4 flex gap-4 hover:bg-gray-50 transition relative overflow-hidden">
                                <div class="absolute left-0 top-0 bottom-0 w-1 {{ $stripeColor }}"></div>
                                <div class="flex flex-col items-center gap-1 shrink-0 w-12 pt-1">
                                    <span class="text-sm font-bold text-gray-900">{{ \Carbon\Carbon::parse($log->time)->format('H:i') }}</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex justify-between items-start mb-1">
                                        <div class="flex items-center gap-2 overflow-hidden">
                                            {{-- [UPDATED] Red Text --}}
                                            <h4 class="text-sm font-bold truncate {{ $log->is_off_duty ? 'text-red-600' : 'text-gray-900' }}">
                                                {{ $log->type }}
                                            </h4>

                                            {{-- [NEW] Badge --}}
                                            @if($log->is_off_duty)
                                                <span class="shrink-0 inline-flex items-center px-1.5 py-0.5 rounded text-[9px] font-bold bg-red-100 text-red-600 border border-red-200">
                                                    OFF DUTY
                                                </span>
                                            @endif
                                        </div>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium {{ $badgeClass }}">
                                            {{ $badgeText }}
                                        </span>
                                    </div>
                                    
                                    <p class="text-xs line-clamp-2 mt-1 {{ $log->is_off_duty ? 'text-red-600 font-medium' : 'text-gray-500' }}">
                                        {{ $log->remarks }}
                                    </p>
                                    <p class="text-xs line-clamp-2 mt-1 {{ $log->is_off_duty ? 'text-red-600 font-medium' : 'text-gray-500' }}">
                                        <b>ULASAN: </b>
                                        {{ $log->rejection_reason ?? 'Tiada ulasan penyelia.' }}
                                    </p>
                                    
                                    <div class="mt-2 text-[10px] text-gray-400 flex items-center gap-1">
                                        @if($isApproved)
                                            <svg class="w-3 h-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            {{ optional($log->officer)->name ?? 'Penyelia Lain' }}
                                        @else
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

        @if(!$hasHistory)
            <div class="flex flex-col items-center justify-center py-12 text-center">
                <p class="text-gray-500 text-xs">Tiada sejarah tugasan.</p>
            </div>
        @endif
    </div>
</div>

{{-- JAVASCRIPT & STYLES (Keep existing code) --}}
<script>
    function switchTab(tabName) {
        document.getElementById('view-draft').classList.add('hidden');
        document.getElementById('view-sent').classList.add('hidden');
        document.getElementById('view-history').classList.add('hidden');

        const tabs = ['draft', 'sent', 'history'];
        const activeClass = ['bg-white', 'text-[#00205B]', 'shadow-sm', 'font-bold', 'border-gray-100'];
        const inactiveClass = ['text-gray-500', 'font-medium', 'bg-transparent', 'shadow-none', 'border-transparent'];

        tabs.forEach(t => {
            const btn = document.getElementById('tab-' + t);
            btn.classList.remove(...activeClass);
            btn.classList.add(...inactiveClass);
        });

        document.getElementById('view-' + tabName).classList.remove('hidden');
        
        const activeBtn = document.getElementById('tab-' + tabName);
        activeBtn.classList.remove(...inactiveClass);
        activeBtn.classList.add(...activeClass);
    }

    function filterLogs() {
        const input = document.getElementById('searchInput').value.toLowerCase();
        
        let activeContainer;
        if (!document.getElementById('view-draft').classList.contains('hidden')) activeContainer = document.getElementById('view-draft');
        else if (!document.getElementById('view-sent').classList.contains('hidden')) activeContainer = document.getElementById('view-sent');
        else activeContainer = document.getElementById('view-history');

        const cards = activeContainer.querySelectorAll('.log-card-item');

        cards.forEach(card => {
            const text = card.innerText.toLowerCase();
            card.style.display = text.includes(input) ? "" : "none";
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

{{-- SWEETALERT 2 SCRIPT --}}
{{-- Place this at the bottom of History.blade.php --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. SUCCESS ALERT (Triggered by 'with(success)' in Controller)
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berjaya',
                text: '{{ session('success') }}', // Uses the message from your Controller
                timer: 1500,
                showConfirmButton: false,
                background: '#fff',
                iconColor: '#00205B', // Matches your theme color
                customClass: {
                    title: 'text-[#00205B] font-bold text-lg',
                    popup: 'rounded-xl shadow-2xl border border-gray-100'
                }
            });
        @endif

        // 2. ERROR ALERT (Triggered by validation errors or manual error session)
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Ralat',
                text: '{{ session('error') }}',
                confirmButtonColor: '#d33',
                confirmButtonText: 'Tutup'
            });
        @endif
    });
</script>
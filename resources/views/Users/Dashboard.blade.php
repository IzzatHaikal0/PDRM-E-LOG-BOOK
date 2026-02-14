@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Dashboard Anggota') }}
    </h2>
@endsection

@section('content')
<div class="py-6 px-4 sm:px-6 lg:px-8 max-w-lg mx-auto pb-24">

    {{-- 1. WELCOME HEADER --}}
    <div class="mb-6 flex flex-col gap-1">
        <h1 class="text-2xl font-bold text-[#00205B]">Selamat Datang,</h1>
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-gray-700">{{ Auth::user()->name ?? 'Sjn. Mejar Halim' }}</p> 
                <p class="text-xs text-gray-400">Anggota Bertugas • Ibu Pejabat Polis Pekan</p>
            </div>
            <div class="text-xs font-medium text-blue-800 bg-blue-50 px-3 py-1 rounded-full border border-blue-100">
                {{ \Carbon\Carbon::now()->translatedFormat('l, d M') }}
            </div>
        </div>
    </div>

    {{-- 2. INTERACTIVE CALENDAR CARD --}}
    <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 mb-6 relative overflow-hidden">
        
        {{-- Header with Navigation --}}
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-base font-bold text-gray-800 flex items-center gap-2">
                <svg class="w-5 h-5 text-[#00205B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                Rekod Tugasan
            </h3>
            
            {{-- Week Navigation Controls --}}
            <div class="flex items-center gap-1 bg-gray-50 rounded-lg p-0.5 border border-gray-100">
                <button onclick="changeWeek(-1)" class="p-1 text-gray-400 hover:text-[#00205B] hover:bg-white rounded transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </button>
                <span class="text-[10px] font-bold text-gray-600 px-2 uppercase tracking-wide w-24 text-center" id="currentWeekLabel">
                    Minggu Ini
                </span>
                <button onclick="changeWeek(1)" class="p-1 text-gray-400 hover:text-[#00205B] hover:bg-white rounded transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </button>
            </div>
        </div>

        {{-- Calendar Grid (Empty container, filled by JS) --}}
        <div class="grid grid-cols-7 gap-2 text-center transition-all duration-300" id="calendarGrid">
        </div>
        
        {{-- Legend --}}
        <div class="flex items-center justify-center gap-4 mt-4 pt-3 border-t border-gray-50">
            <div class="flex items-center gap-1.5">
                <div class="w-2 h-2 rounded-full bg-green-500"></div>
                <span class="text-[10px] text-gray-500">Hadir</span>
            </div>
            <div class="flex items-center gap-1.5">
                <div class="w-2 h-2 rounded-full bg-red-500"></div>
                <span class="text-[10px] text-gray-500">Tiada Rekod</span>
            </div>
        </div>
    </div>

    {{-- 3. PERSONAL STATS GRID --}}
    <div class="grid grid-cols-2 gap-3 mb-6">
  
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between relative overflow-hidden group">
             <div class="absolute right-0 top-0 w-16 h-16 bg-blue-50 rounded-bl-full -mr-2 -mt-2 transition group-hover:bg-blue-100"></div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider relative z-10">Log Saya</p>
                <h3 class="text-2xl font-bold text-blue-900 mt-1 relative z-10">{{ $my_logs ?? 0 }}</h3>
            </div>
             <div class="mt-3 text-[10px] text-blue-400">
                Hari Ini
            </div>
        </div>
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-16 h-16 bg-indigo-50 rounded-bl-full -mr-2 -mt-2 transition group-hover:bg-indigo-100"></div>
                <div>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider relative z-10">Jawatan Saya</p>
                    <h3 class="text-l font-bold text-indigo-900 mt-1 relative z-10">{{ Auth::user()->role ?? 'N/A' }}</h3>
                </div>
            <div class="mt-3 text-[10px] text-indigo-400">
                {{ $pangkat_name ?? 'N/A' }}
            </div>
        </div>
    </div>

    {{-- 4. RECENT LOGS LIST --}}
    <div class="space-y-4 mb-6">
        <div class="flex items-center justify-between px-1">
            <h3 class="text-base font-bold text-gray-800">Log Terkini Saya</h3>
            <a href="{{route('logs.history')}}" class="text-xs font-bold text-blue-800 hover:text-blue-600 uppercase tracking-wide">Lihat Semua</a>
        </div>
        
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="divide-y divide-gray-100">
                @forelse($recent_logs ?? [] as $log)
                    <div class="p-4 flex gap-4 hover:bg-gray-50 transition">
                        <div class="flex flex-col items-center gap-1 shrink-0 w-12">
                            <span class="text-xs font-bold text-gray-800">{{ $log->created_at->format('h:i') }}</span>
                            <span class="text-[10px] text-gray-400 uppercase">{{ $log->created_at->format('A') }}</span>
                            @if(!$loop->last)
                                <div class="h-full w-px bg-gray-200 my-1"></div>
                            @endif
                        </div>
                        <div class="flex-1 pb-2">
                            <div class="flex items-start justify-between">
                                <h4 class="text-sm font-bold text-[#00205B]">{{ $log->aktiviti ?? $log->type ?? 'Log Rekod' }}</h4>
                                @if(!isset($log->status) || $log->status === 'draft')
                                    <span class="px-2 py-0.5 rounded text-[10px] font-medium bg-gray-100 text-gray-600">Draf</span>
                                @elseif($log->status === 'pending')
                                    <span class="px-2 py-0.5 rounded text-[10px] font-medium bg-yellow-100 text-yellow-700">Menunggu</span>
                                @elseif($log->status === 'approved')
                                    <span class="px-2 py-0.5 rounded text-[10px] font-medium bg-green-100 text-green-700">Disahkan</span>
                                @elseif($log->status === 'rejected')
                                    <span class="px-2 py-0.5 rounded text-[10px] font-medium bg-red-100 text-red-700">Ditolak</span>
                                @endif
                            </div>
                            <p class="text-xs text-gray-500 mt-1 line-clamp-2">{{ $log->keterangan ?? $log->remarks ?? 'Tiada butiran tambahan.' }}</p>
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-center text-sm text-gray-500">
                        Anda belum merekodkan sebarang log aktiviti.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

{{-- DAY DETAILS MODAL (Pop-up) --}}
<div id="dayModal" class="hidden fixed inset-0 z-[100] w-screen h-screen overflow-hidden" role="dialog" aria-modal="true">
    <div class="absolute inset-0 flex items-center justify-center p-4">
        {{-- Backdrop --}}
        <div class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" onclick="closeDayModal()"></div>

        {{-- Panel --}}
        <div class="relative z-10 w-full max-w-sm bg-white rounded-xl shadow-2xl overflow-hidden flex flex-col max-h-[80vh]">
            <div class="bg-[#00205B] px-5 py-4 flex items-center justify-between shrink-0">
                <div>
                    <p class="text-xs text-blue-200 font-medium uppercase tracking-wider" id="modal-day">ISNIN</p>
                    <h3 class="text-lg font-bold text-white flex items-center gap-2">
                        <span id="modal-date">20</span> <span id="modal-month">Januari 2026</span>
                    </h3>
                </div>
                <button onclick="closeDayModal()" class="text-white/70 hover:text-white transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div class="p-5 overflow-y-auto" id="modal-task-list"></div>
            <div class="bg-gray-50 px-5 py-3 border-t border-gray-100 shrink-0">
                <button onclick="closeDayModal()" class="w-full bg-white border border-gray-300 text-gray-700 text-sm font-bold py-2.5 rounded-lg hover:bg-gray-100 transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>


{{-- JAVASCRIPT ENGINE --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // 1. INJECT ALL LOGS FROM LARAVEL
    const allLogs = @json($allLogs ?? []); 

    // 2. SETUP DATES
    let currentStartOfWeek = new Date(); 
    const day = currentStartOfWeek.getDay();
    const diff = currentStartOfWeek.getDate() - day + (day == 0 ? -6 : 1); 
    currentStartOfWeek.setDate(diff);
    currentStartOfWeek.setHours(0,0,0,0); 

    document.addEventListener('DOMContentLoaded', () => {
        renderCalendar();
    });

    // 3. CHANGE WEEK FUNCTION
    function changeWeek(offset) {
        currentStartOfWeek.setDate(currentStartOfWeek.getDate() + (offset * 7));
        renderCalendar();
    }

    // 4. RENDER CALENDAR GRID
    function renderCalendar() {
        const grid = document.getElementById('calendarGrid');
        const label = document.getElementById('currentWeekLabel');
        grid.innerHTML = '';

        const endOfWeek = new Date(currentStartOfWeek);
        endOfWeek.setDate(endOfWeek.getDate() + 6);
        
        const today = new Date();
        const isCurrentWeek = (today >= currentStartOfWeek && today <= endOfWeek);
        
        if(isCurrentWeek) {
            label.innerText = "Minggu Ini";
        } else {
            const options = { day: 'numeric', month: 'short' };
            label.innerText = `${currentStartOfWeek.toLocaleDateString('ms-MY', options)} - ${endOfWeek.toLocaleDateString('ms-MY', options)}`;
        }

        let dateIterator = new Date(currentStartOfWeek);
        
        for (let i = 0; i < 7; i++) {
            const year = dateIterator.getFullYear();
            const month = String(dateIterator.getMonth() + 1).padStart(2, '0');
            const dt = String(dateIterator.getDate()).padStart(2, '0');
            const fullDate = `${year}-${month}-${dt}`;
            
            let status = 'gray';
            const isToday = (dateIterator.toDateString() === new Date().toDateString());
            const isFuture = (dateIterator > new Date());
            const hasLog = allLogs[fullDate] ? true : false;

            if (isToday) status = 'today';
            else if (isFuture) status = 'gray';
            else status = hasLog ? 'green' : 'red';

            const dayName = dateIterator.toLocaleDateString('ms-MY', { weekday: 'long' });
            const dayShort = dayName.substring(0, 3);
            const dateNum = dateIterator.getDate();
            const monthYear = dateIterator.toLocaleDateString('ms-MY', { month: 'long', year: 'numeric' });

            let bubbleHtml = '';
            if(status === 'green') {
                bubbleHtml = `<div class="w-8 h-8 rounded-full bg-green-100 border border-green-200 flex items-center justify-center text-xs font-bold text-green-700 shadow-sm group-hover:bg-green-200">${dateNum}</div>`;
            } else if(status === 'red') {
                bubbleHtml = `<div class="w-8 h-8 rounded-full bg-red-100 border border-red-200 flex items-center justify-center text-xs font-bold text-red-700 shadow-sm group-hover:bg-red-200">${dateNum}</div>`;
            } else if(status === 'today') {
                bubbleHtml = `<div class="w-8 h-8 rounded-full bg-[#00205B] border border-[#00205B] flex items-center justify-center text-xs font-bold text-white shadow-lg ring-2 ring-blue-100 transform scale-110">${dateNum}</div>`;
            } else {
                bubbleHtml = `<div class="w-8 h-8 rounded-full bg-gray-50 border border-gray-100 flex items-center justify-center text-xs font-medium text-gray-400">${dateNum}</div>`;
            }

            const cell = document.createElement('div');
            cell.className = "calendar-cell flex flex-col items-center gap-1 cursor-pointer group transition transform hover:scale-105 active:scale-95";
            cell.onclick = () => openDayModal(fullDate, status, dayName, monthYear);
            cell.innerHTML = `
                <span class="text-[10px] text-gray-400 font-medium group-hover:text-[#00205B]">${dayShort}</span>
                ${bubbleHtml}
            `;
            grid.appendChild(cell);

            dateIterator.setDate(dateIterator.getDate() + 1);
        }
    }

    // 5. MODAL LOGIC
    function openDayModal(fullDate, status, dayName, monthYear) {
        if (status === 'red') {
            Swal.fire({ icon: 'info', title: 'Tiada Rekod', text: `Tiada tugasan pada ${dayName}, ${fullDate}.`, confirmButtonColor: '#00205B' });
            return;
        }
        if (status === 'gray') {
             Swal.fire({ icon: 'info', title: 'Akan Datang', text: 'Tarikh ini belum tiba.', confirmButtonColor: '#00205B' });
            return;
        }

        const tasks = allLogs[fullDate] || [];

        document.getElementById('modal-day').innerText = dayName;
        document.getElementById('modal-date').innerText = new Date(fullDate).getDate();
        document.getElementById('modal-month').innerText = monthYear;
        
        const listContainer = document.getElementById('modal-task-list');
        
        if (tasks.length > 0) {
            let html = '<div class="relative border-l-2 border-gray-100 ml-3 space-y-6">';
            
            tasks.forEach(task => {
                let badgeClass = task.status === 'approved' ? 'bg-green-100 text-green-700' : 
                                (task.status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-600');

                const timeObj = new Date(task.created_at);
                const timeStr = timeObj.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

                html += `
                    <div class="relative pl-6">
                        <span class="absolute -left-[9px] top-1 h-4 w-4 rounded-full border-2 border-white bg-[#00205B] shadow-sm"></span>
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-xs font-bold text-gray-400">${timeStr}</span>
                            <span class="text-[10px] px-2 py-0.5 rounded ${badgeClass} font-bold capitalize">${task.status === 'approved' ? 'Disahkan' : (task.status === 'pending' ? 'Menunggu' : 'Log')}</span>
                        </div>
                        
                        <h4 class="text-sm font-bold text-gray-900">${task.remarks || task.type || 'No description'}</h4>
                        
                        <p class="text-xs text-gray-500 capitalize">${task.type || 'Log Sistem'}</p>
                    </div>`;
            });
            html += '</div>';
            listContainer.innerHTML = html;
        } else {
            listContainer.innerHTML = '<p class="text-center text-gray-500 text-sm py-4">Tiada butiran.</p>';
        }

        document.getElementById('dayModal').classList.remove('hidden');
    }

    function closeDayModal() {
        document.getElementById('dayModal').classList.add('hidden');
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
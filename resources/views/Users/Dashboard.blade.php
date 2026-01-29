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
            <p class="text-lg font-semibold text-gray-700">{{ Auth::user()->name ?? 'Kpl. Ahmad Albab' }}</p>
            <div class="text-xs font-medium text-blue-800 bg-blue-50 px-3 py-1 rounded-full border border-blue-100">
                {{ \Carbon\Carbon::now()->translatedFormat('l, d M') }}
            </div>
        </div>
        <p class="text-xs text-gray-400">ID: {{ Auth::user()->badge_number ?? 'RF12345' }} • {{ Auth::user()->station ?? 'IPD Muar' }}</p>
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
                <button onclick="changeWeek('prev')" class="p-1 text-gray-400 hover:text-[#00205B] hover:bg-white rounded transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </button>
                <span class="text-[10px] font-bold text-gray-600 px-2 uppercase tracking-wide" id="currentWeekLabel">Minggu Ini</span>
                <button onclick="changeWeek('next')" class="p-1 text-gray-400 hover:text-[#00205B] hover:bg-white rounded transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </button>
            </div>
        </div>

        {{-- Calendar Grid --}}
        <div class="grid grid-cols-7 gap-2 text-center transition-all duration-300" id="calendarGrid">
            @php
                // Default view (Current Week)
                $days = [
                    ['day' => 'Isnin', 'date' => '20', 'status' => 'green'],
                    ['day' => 'Selasa', 'date' => '21', 'status' => 'green'],
                    ['day' => 'Rabu', 'date' => '22', 'status' => 'red'], 
                    ['day' => 'Khamis', 'date' => '23', 'status' => 'green'],
                    ['day' => 'Jumaat', 'date' => '24', 'status' => 'green'],
                    ['day' => 'Sabtu', 'date' => '25', 'status' => 'green'],
                    ['day' => 'Ahad', 'date' => '26', 'status' => 'today'], 
                ];
            @endphp

            @foreach($days as $day)
                {{-- CLICKABLE CELL --}}
                <div onclick="openDayModal('{{ $day['date'] }}', '{{ $day['status'] }}', '{{ $day['day'] }}')" 
                     class="calendar-cell flex flex-col items-center gap-1 cursor-pointer group transition transform hover:scale-105 active:scale-95">
                    
                    <span class="text-[10px] text-gray-400 font-medium group-hover:text-[#00205B]">{{ substr($day['day'], 0, 3) }}</span>
                    
                    @if($day['status'] == 'green')
                        <div class="w-8 h-8 rounded-full bg-green-100 border border-green-200 flex items-center justify-center text-xs font-bold text-green-700 shadow-sm group-hover:bg-green-200">
                            {{ $day['date'] }}
                        </div>
                    @elseif($day['status'] == 'red')
                        <div class="w-8 h-8 rounded-full bg-red-100 border border-red-200 flex items-center justify-center text-xs font-bold text-red-700 shadow-sm group-hover:bg-red-200">
                            {{ $day['date'] }}
                        </div>
                    @elseif($day['status'] == 'today')
                        <div class="w-8 h-8 rounded-full bg-[#00205B] border border-[#00205B] flex items-center justify-center text-xs font-bold text-white shadow-lg ring-2 ring-blue-100 transform scale-110">
                            {{ $day['date'] }}
                        </div>
                    @else
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
                <span class="text-[10px] text-gray-500">Hadir</span>
            </div>
            <div class="flex items-center gap-1.5">
                <div class="w-2 h-2 rounded-full bg-red-500"></div>
                <span class="text-[10px] text-gray-500">Tiada Rekod</span>
            </div>
        </div>
    </div>

    {{-- 3. PERSONAL STATS GRID (Unchanged) --}}
    <div class="grid grid-cols-2 gap-3 mb-6">
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between relative overflow-hidden">
            <div class="absolute right-0 top-0 w-16 h-16 bg-green-50 rounded-bl-full -mr-2 -mt-2"></div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider relative z-10">Status</p>
                <h3 class="text-lg font-bold text-green-600 mt-1 relative z-10">Aktif</h3>
            </div>
            <div class="mt-3 flex items-center gap-1 text-[10px] text-gray-400">
                <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                Masuk: 08:00 PG
            </div>
        </div>
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between relative overflow-hidden">
            <div class="absolute right-0 top-0 w-16 h-16 bg-blue-50 rounded-bl-full -mr-2 -mt-2"></div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider relative z-10">Log Hari Ini</p>
                <h3 class="text-2xl font-bold text-[#00205B] mt-1 relative z-10">3</h3>
            </div>
             <div class="mt-3 text-[10px] text-blue-400">
                +1 dari semalam
            </div>
        </div>
    </div>

    {{-- 4. RECENT LOGS LIST (Unchanged) --}}
    <div class="space-y-4 mb-6">
        <div class="flex items-center justify-between px-1">
            <h3 class="text-base font-bold text-gray-800">Log Terkini Saya</h3>
            <a href="{{ route('logs.history') }}" class="text-xs font-bold text-blue-800 hover:text-blue-600 uppercase tracking-wide">Lihat Semua</a>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="divide-y divide-gray-100">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- DAY DETAILS MODAL (Unchanged) --}}
<div id="dayModal" class="hidden fixed inset-0 z-[100] w-screen h-screen overflow-hidden" role="dialog" aria-modal="true">
    <div class="absolute inset-0 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" onclick="closeDayModal()"></div>
        <div class="relative z-10 w-full max-w-sm bg-white rounded-xl shadow-2xl overflow-hidden flex flex-col max-h-[80vh]">
            <div class="bg-[#00205B] px-5 py-4 flex items-center justify-between shrink-0">
                <div>
                    <p class="text-xs text-blue-200 font-medium uppercase tracking-wider" id="modal-day">ISNIN</p>
                    <h3 class="text-lg font-bold text-white flex items-center gap-2">
                        <span id="modal-date">20</span> Januari 2026
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // --- CALENDAR DATA SIMULATION ---
    const calendarWeeks = {
        'prev': [ // Previous Week
            { day: 'Isnin', date: '13', status: 'green' },
            { day: 'Selasa', date: '14', status: 'green' },
            { day: 'Rabu', date: '15', status: 'green' },
            { day: 'Khamis', date: '16', status: 'red' },
            { day: 'Jumaat', date: '17', status: 'green' },
            { day: 'Sabtu', date: '18', status: 'green' },
            { day: 'Ahad', date: '19', status: 'green' }
        ],
        'curr': [ // Current Week (Matched with Blade PHP)
            { day: 'Isnin', date: '20', status: 'green' },
            { day: 'Selasa', date: '21', status: 'green' },
            { day: 'Rabu', date: '22', status: 'red' },
            { day: 'Khamis', date: '23', status: 'green' },
            { day: 'Jumaat', date: '24', status: 'green' },
            { day: 'Sabtu', date: '25', status: 'green' },
            { day: 'Ahad', date: '26', status: 'today' }
        ],
        'next': [ // Next Week
            { day: 'Isnin', date: '27', status: 'gray' }, // Future
            { day: 'Selasa', date: '28', status: 'gray' },
            { day: 'Rabu', date: '29', status: 'gray' },
            { day: 'Khamis', date: '30', status: 'gray' },
            { day: 'Jumaat', date: '31', status: 'gray' },
            { day: 'Sabtu', date: '01', status: 'gray' },
            { day: 'Ahad', date: '02', status: 'gray' }
        ]
    };

    let currentWeekState = 'curr'; // Track position

    // --- CHANGE WEEK FUNCTION ---
    function changeWeek(direction) {
        const label = document.getElementById('currentWeekLabel');
        const grid = document.getElementById('calendarGrid');

        // Simple State Machine for Demo
        if (currentWeekState === 'curr') {
            currentWeekState = direction === 'next' ? 'next' : 'prev';
        } else if (currentWeekState === 'prev' && direction === 'next') {
            currentWeekState = 'curr';
        } else if (currentWeekState === 'next' && direction === 'prev') {
            currentWeekState = 'curr';
        } else {
            return; // Bound limit reached for demo
        }

        // Update Label
        if (currentWeekState === 'curr') label.innerText = 'Minggu Ini';
        else if (currentWeekState === 'prev') label.innerText = 'Minggu Lepas';
        else label.innerText = 'Minggu Depan';

        // Render New Grid
        renderGrid(calendarWeeks[currentWeekState]);
    }

    function renderGrid(days) {
        const grid = document.getElementById('calendarGrid');
        grid.innerHTML = ''; // Clear existing

        days.forEach(day => {
            let bubbleClass = '';
            
            if (day.status === 'green') {
                bubbleClass = 'bg-green-100 border-green-200 text-green-700';
            } else if (day.status === 'red') {
                bubbleClass = 'bg-red-100 border-red-200 text-red-700';
            } else if (day.status === 'today') {
                bubbleClass = 'bg-[#00205B] border-[#00205B] text-white shadow-lg ring-2 ring-blue-100 transform scale-110';
            } else {
                bubbleClass = 'bg-gray-50 border-gray-100 text-gray-400';
            }

            const html = `
                <div onclick="openDayModal('${day.date}', '${day.status}', '${day.day}')" 
                     class="flex flex-col items-center gap-1 cursor-pointer group transition transform hover:scale-105 active:scale-95 animate-fade-in">
                    <span class="text-[10px] text-gray-400 font-medium group-hover:text-[#00205B]">${day.day.substring(0, 3)}</span>
                    <div class="w-8 h-8 rounded-full border flex items-center justify-center text-xs font-bold shadow-sm ${bubbleClass}">
                        ${day.date}
                    </div>
                </div>
            `;
            grid.innerHTML += html;
        });
    }

    // --- MOCK DATA FOR MODAL ---
    const mockDailyTasks = {
        '20': [ { time: '08:00 AM', title: 'Lapor Masuk', type: 'Sistem', status: 'Disahkan' }, { time: '10:30 AM', title: 'Rondaan MPV', type: 'Rondaan', status: 'Disahkan' }, { time: '02:00 PM', title: 'Tugas Pejabat', type: 'Admin', status: 'Disahkan' } ],
        '21': [ { time: '08:15 AM', title: 'Lapor Masuk', type: 'Sistem', status: 'Disahkan' }, { time: '11:00 AM', title: 'Bit / Pondok Polis', type: 'Rondaan', status: 'Disahkan' } ],
        '26': [ { time: '08:00 AM', title: 'Lapor Masuk', type: 'Sistem', status: 'Menunggu' }, { time: '10:30 AM', title: 'Rondaan Berkala', type: 'Rondaan', status: 'Selesai' } ],
        '13': [ { time: '08:00 AM', title: 'Lapor Masuk', type: 'Sistem', status: 'Disahkan' } ], // Prev week data
    };

    function openDayModal(date, status, dayName) {
        if (status === 'red') {
            Swal.fire({ icon: 'info', title: 'Tiada Rekod', text: 'Tiada log aktiviti direkodkan pada tarikh ini.', confirmButtonColor: '#00205B', confirmButtonText: 'Tutup' });
            return;
        }
        if (status === 'gray') {
             Swal.fire({ icon: 'info', title: 'Akan Datang', text: 'Tarikh ini belum tiba.', confirmButtonColor: '#00205B', confirmButtonText: 'Tutup' });
            return;
        }

        const tasks = mockDailyTasks[date];
        document.getElementById('modal-day').innerText = dayName;
        document.getElementById('modal-date').innerText = date;
        const listContainer = document.getElementById('modal-task-list');
        
        if (tasks && tasks.length > 0) {
            let html = '<div class="relative border-l-2 border-gray-100 ml-3 space-y-6">';
            tasks.forEach(task => {
                let badgeClass = task.status === 'Disahkan' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-800';
                html += `<div class="relative pl-6"><span class="absolute -left-[9px] top-1 h-4 w-4 rounded-full border-2 border-white bg-[#00205B] shadow-sm"></span><div class="flex items-center justify-between mb-1"><span class="text-xs font-bold text-gray-400">${task.time}</span><span class="text-[10px] px-2 py-0.5 rounded ${badgeClass} font-bold">${task.status}</span></div><h4 class="text-sm font-bold text-gray-900">${task.title}</h4><p class="text-xs text-gray-500">${task.type}</p></div>`;
            });
            html += '</div>';
            listContainer.innerHTML = html;
        } else {
            listContainer.innerHTML = '<p class="text-center text-gray-500 text-sm py-4">Maklumat tidak ditemui.</p>';
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
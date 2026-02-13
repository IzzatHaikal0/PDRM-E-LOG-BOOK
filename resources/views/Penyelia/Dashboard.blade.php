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
        <h1 class="text-2xl font-bold text-[#00205B]">Selamat Datang,</h1>
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-gray-700">{{ Auth::user()->name ?? 'Sjn. Mejar Halim' }}</p> 
                <p class="text-xs text-gray-400">Penyelia Bertugas • Ibu Pejabat Polis Pekan</p>
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
                {{-- Dynamic Label --}}
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
                <span class="text-[10px] text-gray-500">Ada Rekod</span>
            </div>
            <div class="flex items-center gap-1.5">
                <div class="w-2 h-2 rounded-full bg-red-500"></div>
                <span class="text-[10px] text-gray-500">Tiada Rekod (Lepas)</span>
            </div>
        </div>
    </div>

    {{-- 3. ACTIONABLE STATS GRID --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
        
        {{-- Card 1: Pending Verification --}}
        <a href="{{ route('Penyelia.VerifyList') }}" class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between relative overflow-hidden group hover:shadow-md transition cursor-pointer">
            <div class="absolute right-0 top-0 w-16 h-16 bg-red-50 rounded-bl-full -mr-2 -mt-2 transition group-hover:bg-red-100"></div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider relative z-10">Perlu Disahkan</p>
                <h3 class="text-2xl font-bold text-red-600 mt-1 relative z-10">{{ $count_penugasan_unverified ?? 0 }}</h3>
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
                <h3 class="text-2xl font-bold text-green-700 mt-1 relative z-10">{{ $count_anggota ?? 0 }}</h3>
            </div>
            <div class="mt-3 text-[10px] text-green-500">
                Jumlah Anggota
            </div>
        </div>

        {{-- Card 3: Today's Total Logs --}}
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

        {{-- Card 4: Attendance Rate --}}
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

    {{-- 4. QUICK VERIFICATION LIST (DYNAMIC) --}}
    <div class="space-y-4 mb-8">
        <div class="flex items-center justify-between px-1">
            <h3 class="text-base font-bold text-gray-800 flex items-center gap-2">
                Log Aktiviti Terkini
                <span class="bg-blue-100 text-blue-600 text-[10px] font-bold px-2 py-0.5 rounded-full">
                    {{ isset($recent_logs) ? $recent_logs->count() : 0 }}
                </span>
            </h3>
            <a href="{{ route('Penyelia.VerifyList') }}" class="text-xs font-bold text-blue-800 hover:text-blue-600 uppercase tracking-wide">Lihat Semua</a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden divide-y divide-gray-100">
            
            @forelse($recent_logs ?? [] as $log)
            <div class="p-4 hover:bg-gray-50 transition group">
                <div class="flex justify-between items-start mb-2">
                    <div class="flex items-center gap-3">
                        {{-- Dynamic Avatar --}}
                        <div class="h-10 w-10 rounded-full bg-gray-200 flex-shrink-0 overflow-hidden border border-gray-100">
                            @if(isset($log->user) && $log->user && $log->user->gambar_profile)
                                <img src="{{ asset('storage/' . $log->user->gambar_profile) }}" class="w-full h-full object-cover">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($log->user->name ?? 'User') }}&background=random&color=fff&size=128" class="w-full h-full object-cover">
                            @endif
                        </div>
                        
                        <div>
                            {{-- Name & Rank --}}
                            <h4 class="text-sm font-bold text-gray-900 leading-tight">
                                {{ isset($log->user->pangkat) ? $log->user->pangkat->pangkat_name : '' }} {{ $log->user->name ?? 'Pengguna Tidak Dikenali' }}
                            </h4>
                            {{-- Log Type / Badge No --}}
                            <p class="text-[10px] text-gray-500 mt-0.5">
                                {{ $log->user->no_badan ?? '-' }} • <span class="uppercase tracking-wider font-semibold text-blue-800">{{ $log->type ?? 'Log Sistem' }}</span>
                            </p>
                        </div>
                    </div>
                    {{-- Time Ago --}}
                    <span class="text-[10px] text-gray-400 font-medium whitespace-nowrap">
                        {{ isset($log->created_at) ? $log->created_at->diffForHumans() : '-' }}
                    </span>
                </div>

                <div class="pl-[3.25rem]">
                    {{-- Description Box --}}
                    <div class="text-sm text-gray-600 mb-3 bg-gray-50 p-3 rounded-lg border border-gray-100 italic relative">
                        {{-- Tiny triangle pointer for speech bubble effect --}}
                        <div class="absolute -top-1.5 left-4 w-3 h-3 bg-gray-50 border-t border-l border-gray-100 transform rotate-45"></div>
                        "{{ $log->remarks ?? 'Tiada butiran log.' }}"
                    </div>
                </div>
            </div>
            @empty
            <div class="p-8 text-center">
                <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-gray-100 mb-3">
                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <p class="text-sm text-gray-500 font-medium">Tiada log aktiviti terkini.</p>
            </div>
            @endforelse

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


{{-- JAVASCRIPT --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // 1. INJECT ALL LOGS FROM LARAVEL
    const allLogs = @json($allLogs ?? []); 

    // 2. SETUP DATES
    let currentStartOfWeek = new Date(); // Start with today
    // Adjust to Monday (1) of current week
    const day = currentStartOfWeek.getDay();
    const diff = currentStartOfWeek.getDate() - day + (day == 0 ? -6 : 1); 
    currentStartOfWeek.setDate(diff);
    currentStartOfWeek.setHours(0,0,0,0); // Clear time

    // Initialize
    document.addEventListener('DOMContentLoaded', () => {
        renderCalendar();
    });

    // 3. CHANGE WEEK FUNCTION
    function changeWeek(offset) {
        // Add or subtract 7 days
        currentStartOfWeek.setDate(currentStartOfWeek.getDate() + (offset * 7));
        renderCalendar();
    }

    // 4. RENDER CALENDAR GRID
    function renderCalendar() {
        const grid = document.getElementById('calendarGrid');
        const label = document.getElementById('currentWeekLabel');
        grid.innerHTML = '';

        // Update Label (e.g., "12 Feb - 18 Feb")
        const endOfWeek = new Date(currentStartOfWeek);
        endOfWeek.setDate(endOfWeek.getDate() + 6);
        
        // Check if it's "This Week" for nicer label
        const today = new Date();
        const isCurrentWeek = (today >= currentStartOfWeek && today <= endOfWeek);
        
        if(isCurrentWeek) {
            label.innerText = "Minggu Ini";
        } else {
            // Format: DD MMM
            const options = { day: 'numeric', month: 'short' };
            label.innerText = `${currentStartOfWeek.toLocaleDateString('ms-MY', options)} - ${endOfWeek.toLocaleDateString('ms-MY', options)}`;
        }

        // Loop 7 Days
        let dateIterator = new Date(currentStartOfWeek);
        
        for (let i = 0; i < 7; i++) {
            // Create YYYY-MM-DD string for lookup
            const year = dateIterator.getFullYear();
            const month = String(dateIterator.getMonth() + 1).padStart(2, '0');
            const dt = String(dateIterator.getDate()).padStart(2, '0');
            const fullDate = `${year}-${month}-${dt}`;
            
            // Determine Status
            let status = 'gray';
            const isToday = (dateIterator.toDateString() === new Date().toDateString());
            const isFuture = (dateIterator > new Date());
            const hasLog = allLogs[fullDate] ? true : false;

            if (isToday) status = 'today';
            else if (isFuture) status = 'gray';
            else status = hasLog ? 'green' : 'red';

            // Day Name (Isnin, etc)
            const dayName = dateIterator.toLocaleDateString('ms-MY', { weekday: 'long' });
            const dayShort = dayName.substring(0, 3);
            const dateNum = dateIterator.getDate();
            const monthYear = dateIterator.toLocaleDateString('ms-MY', { month: 'long', year: 'numeric' });

            // HTML Strings for bubbles
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

            // Append to Grid
            const cell = document.createElement('div');
            cell.className = "calendar-cell flex flex-col items-center gap-1 cursor-pointer group transition transform hover:scale-105 active:scale-95";
            cell.onclick = () => openDayModal(fullDate, status, dayName, monthYear);
            cell.innerHTML = `
                <span class="text-[10px] text-gray-400 font-medium group-hover:text-[#00205B]">${dayShort}</span>
                ${bubbleHtml}
            `;
            grid.appendChild(cell);

            // Increment Day
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

        // Fetch logs from JSON
        const tasks = allLogs[fullDate] || [];

        // Update UI
        document.getElementById('modal-day').innerText = dayName;
        document.getElementById('modal-date').innerText = new Date(fullDate).getDate();
        
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
                            <span class="text-[10px] px-2 py-0.5 rounded ${badgeClass} font-bold capitalize">${task.status || 'Log'}</span>
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
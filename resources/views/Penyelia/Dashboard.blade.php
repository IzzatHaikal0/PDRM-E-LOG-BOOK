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
                <p class="text-sm font-semibold text-gray-700">{{ Auth::user()->name ?? 'Sjn. Mejar Halim' }}</p> 
                <p class="text-xs text-gray-400">Penyelia Bertugas • Balai Polis Muar</p>
            </div>
            <div class="text-xs font-medium text-blue-800 bg-blue-50 px-3 py-1 rounded-full border border-blue-100">
                {{ \Carbon\Carbon::now()->translatedFormat('l, d M') }}
            </div>
        </div>
    </div>

    {{-- 2. INTERACTIVE CALENDAR CARD --}}
    <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 mb-6 relative overflow-hidden">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-base font-bold text-gray-800 flex items-center gap-2">
                <svg class="w-5 h-5 text-[#00205B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                Rekod Tugasan Saya
            </h3>
            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Minggu Ini</span>
        </div>

        {{-- Calendar Grid --}}
        <div class="grid grid-cols-7 gap-2 text-center">
            @php
                $days = [
                    ['day' => 'Isnin', 'date' => '20', 'status' => 'green'],
                    ['day' => 'Selasa', 'date' => '21', 'status' => 'green'],
                    ['day' => 'Rabu', 'date' => '22', 'status' => 'red'], // Missed
                    ['day' => 'Khamis', 'date' => '23', 'status' => 'green'],
                    ['day' => 'Jumaat', 'date' => '24', 'status' => 'green'],
                    ['day' => 'Sabtu', 'date' => '25', 'status' => 'green'],
                    ['day' => 'Ahad', 'date' => '26', 'status' => 'today'], // Today
                ];
            @endphp

            @foreach($days as $day)
                {{-- CLICKABLE CELL --}}
                <div onclick="openDayModal('{{ $day['date'] }}', '{{ $day['status'] }}', '{{ $day['day'] }}')" 
                     class="flex flex-col items-center gap-1 cursor-pointer group transition transform hover:scale-105 active:scale-95">
                    
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
                <span class="text-[10px] text-gray-500">Hadir / Ada Log</span>
            </div>
            <div class="flex items-center gap-1.5">
                <div class="w-2 h-2 rounded-full bg-red-500"></div>
                <span class="text-[10px] text-gray-500">Tiada Rekod</span>
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

    {{-- 4. QUICK VERIFICATION LIST --}}
    <div class="space-y-4 mb-8">
        <div class="flex items-center justify-between px-1">
            <h3 class="text-base font-bold text-gray-800 flex items-center gap-2">
                Tugasan Menunggu Pengesahan
                <span class="bg-red-100 text-red-600 text-[10px] font-bold px-2 py-0.5 rounded-full">5</span>
            </h3>
            <a href="{{ route('Penyelia.VerifyList') }}" class="text-xs font-bold text-blue-800 hover:text-blue-600 uppercase tracking-wide">Lihat Semua</a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden divide-y divide-gray-100">
            {{-- Item 1 --}}
            <div class="p-4 hover:bg-gray-50 transition">
                <div class="flex justify-between items-start mb-2">
                    <div class="flex items-center gap-3">
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
        </div>
    </div>

    {{-- 5. TEAM OVERVIEW TABLE --}}
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
                </tbody>
            </table>
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
            
            {{-- Modal Header --}}
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

            {{-- Modal Body (List of Tasks) --}}
            <div class="p-5 overflow-y-auto" id="modal-task-list">
                {{-- Content injected via JS --}}
            </div>

            {{-- Footer --}}
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
    // --- MOCK DATA FOR SUPERVISOR CALENDAR ---
    // Reflects tasks a supervisor would do (Inspections, Meetings, Admin)
    const mockDailyTasks = {
        '20': [ // Green Date
            { time: '08:00 AM', title: 'Lapor Masuk Penyelia', type: 'Sistem', status: 'Disahkan' },
            { time: '09:00 AM', title: 'Semakan Anggota (Roll Call)', type: 'Pentadbiran', status: 'Selesai' },
            { time: '02:00 PM', title: 'Pemantauan Sektor A', type: 'Penyeliaan', status: 'Disahkan' }
        ],
        '21': [ // Green Date
            { time: '08:00 AM', title: 'Lapor Masuk Penyelia', type: 'Sistem', status: 'Disahkan' },
            { time: '11:00 AM', title: 'Mesyuarat Ketua Balai', type: 'Mesyuarat', status: 'Selesai' }
        ],
        '26': [ // Today
            { time: '07:45 AM', title: 'Lapor Masuk Penyelia', type: 'Sistem', status: 'Menunggu' },
            { time: '10:00 AM', title: 'Semakan Buku Log MPV', type: 'Penyeliaan', status: 'Dalam Proses' }
        ]
    };

    // --- CLICK HANDLER ---
    function openDayModal(date, status, dayName) {
        // 1. RED DATE LOGIC (No Record)
        if (status === 'red') {
            Swal.fire({
                icon: 'info',
                title: 'Tiada Rekod',
                text: 'Tiada log tugasan direkodkan pada tarikh ini.',
                confirmButtonColor: '#00205B',
                confirmButtonText: 'Tutup'
            });
            return;
        }

        // 2. GREEN/TODAY DATE LOGIC (Show Modal)
        if (status === 'green' || status === 'today') {
            const tasks = mockDailyTasks[date];
            
            // Set Header Info
            document.getElementById('modal-day').innerText = dayName;
            document.getElementById('modal-date').innerText = date;

            // Generate List HTML
            const listContainer = document.getElementById('modal-task-list');
            
            if (tasks && tasks.length > 0) {
                let html = '<div class="relative border-l-2 border-gray-100 ml-3 space-y-6">';
                
                tasks.forEach(task => {
                    // Status Badge Color
                    let badgeClass = task.status === 'Disahkan' || task.status === 'Selesai' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-800';
                    
                    html += `
                        <div class="relative pl-6">
                            <span class="absolute -left-[9px] top-1 h-4 w-4 rounded-full border-2 border-white bg-[#00205B] shadow-sm"></span>
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-xs font-bold text-gray-400">${task.time}</span>
                                <span class="text-[10px] px-2 py-0.5 rounded ${badgeClass} font-bold">${task.status}</span>
                            </div>
                            <h4 class="text-sm font-bold text-gray-900">${task.title}</h4>
                            <p class="text-xs text-gray-500">${task.type}</p>
                        </div>
                    `;
                });
                
                html += '</div>';
                listContainer.innerHTML = html;
            } else {
                // Fallback
                listContainer.innerHTML = '<p class="text-center text-gray-500 text-sm py-4">Maklumat tidak ditemui.</p>';
            }

            // Show Modal
            document.getElementById('dayModal').classList.remove('hidden');
        }
    }

    function closeDayModal() {
        document.getElementById('dayModal').classList.add('hidden');
    }
</script>
@endsection
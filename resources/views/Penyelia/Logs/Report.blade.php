@extends('layouts.app')

@section('content')
<div class="py-6 px-4 max-w-lg mx-auto pb-24">

    {{-- Header --}}
    <div class="mb-6 flex items-center gap-3">
        <a href="{{ route('Penyelia.VerifyList') ?? '#' }}" class="p-2 bg-white rounded-full border border-gray-200 text-gray-500 hover:bg-gray-50">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </a>
        <div>
            <h2 class="font-bold text-xl text-[#00205B]">Laporan Penyelia</h2>
            <p class="text-xs text-gray-400">Jana PDF untuk anggota seliaan anda.</p>
        </div>
    </div>

    {{-- 1. SELECTION CARD --}}
    <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 mb-6">
        
        <form action="{{ route('Penyelia.Logs.GeneratePDF') }}" method="POST" id="reportForm" class="space-y-5">
            @csrf
            <input type="hidden" name="report_type" id="reportTypeInput" value="monthly">

            {{-- TARGET SELECTION (NEW FOR PENYELIA) --}}
            <div>
                <label class="text-[10px] font-bold text-[#00205B] uppercase mb-1 block">Pilih Anggota</label>
                <div class="relative">
                    <select name="anggota_id" id="anggotaInput" onchange="updateStats()" class="w-full pl-4 pr-10 py-3 bg-blue-50/50 border border-blue-100 rounded-xl text-sm font-bold text-[#00205B] focus:ring-[#00205B] focus:border-[#00205B] appearance-none">
                        <option value="{{ Auth::id() }}">Laporan Saya Sendiri</option>
                        <optgroup label="Anggota Seliaan">
                            @foreach($subordinates as $anggota)
                                <option value="{{ $anggota->id }}">{{ $anggota->no_badan ?? '' }} - {{ $anggota->name }}</option>
                            @endforeach
                        </optgroup>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-blue-800">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
            </div>

            <hr class="border-gray-100">

            {{-- Tabs --}}
            <div class="flex p-1 bg-gray-100 rounded-lg">
                <button type="button" onclick="switchReportType('monthly')" id="tab-monthly" class="flex-1 py-2 text-xs font-bold rounded-md bg-white text-[#00205B] shadow-sm transition-all">
                    Bulanan
                </button>
                <button type="button" onclick="switchReportType('weekly')" id="tab-weekly" class="flex-1 py-2 text-xs font-medium text-gray-500 hover:text-gray-900 transition-all">
                    Mingguan
                </button>
            </div>

            {{-- Monthly Selector --}}
            <div id="selector-monthly">
                <label class="text-[10px] font-bold text-gray-400 uppercase mb-1 block">Pilih Bulan</label>
                <div class="relative">
                    <select name="month_value" id="monthInput" onchange="updateStats()" class="w-full pl-4 pr-10 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-700 focus:ring-blue-900 focus:border-blue-900 appearance-none">
                        @forelse($availableMonths as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @empty
                            <option value="">Tiada rekod sistem dijumpai</option>
                        @endforelse
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-gray-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
            </div>

            {{-- Weekly Selector --}}
            <div id="selector-weekly" class="hidden">
                <label class="text-[10px] font-bold text-gray-400 uppercase mb-1 block">Pilih Minggu</label>
                <div class="relative">
                    <select name="week_value" id="weekInput" onchange="updateStats()" class="w-full pl-4 pr-10 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-700 focus:ring-blue-900 focus:border-blue-900 appearance-none">
                        @forelse($availableWeeks as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @empty
                            <option value="">Tiada rekod sistem dijumpai</option>
                        @endforelse
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-gray-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
            </div>

            {{-- Action Button --}}
            <button type="button" onclick="generateReport()" class="w-full py-3 bg-[#00205B] text-white rounded-xl font-bold text-sm hover:bg-blue-900 shadow-lg shadow-blue-900/20 transition transform active:scale-95 flex justify-center items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Muat Turun PDF Laporan
            </button>
        </form>
    </div>

    {{-- 2. PREVIEW / SUMMARY CARD --}}
    <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
        <h3 class="text-sm font-bold text-gray-800 mb-4">Ringkasan Statistik Anggota</h3>
        
        <div class="grid grid-cols-2 gap-4">
            <div class="p-4 bg-green-50 rounded-xl border border-green-100 transition-all duration-300" id="statCard1">
                <p class="text-xs text-green-600 font-medium mb-1">Disahkan</p>
                <h4 class="text-2xl font-bold text-green-700" id="stat-approved">0</h4>
                <p class="text-[10px] text-green-500">Tugasan Selesai</p>
            </div>
            <div class="p-4 bg-blue-50 rounded-xl border border-blue-100 transition-all duration-300" id="statCard2">
                <p class="text-xs text-blue-600 font-medium mb-1">Jumlah Jam</p>
                <h4 class="text-2xl font-bold text-blue-800" id="stat-hours">0</h4>
                <p class="text-[10px] text-blue-500">Jam Bertugas</p>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let currentType = 'monthly';
    const userStats = @json($userStats); // Data for EVERY user securely injected

    document.addEventListener('DOMContentLoaded', updateStats);

    function switchReportType(type) {
        currentType = type;
        document.getElementById('reportTypeInput').value = type;

        const tabMonthly = document.getElementById('tab-monthly');
        const tabWeekly = document.getElementById('tab-weekly');
        const selMonthly = document.getElementById('selector-monthly');
        const selWeekly = document.getElementById('selector-weekly');

        if(type === 'monthly') {
            tabMonthly.classList.add('bg-white', 'text-[#00205B]', 'shadow-sm', 'font-bold');
            tabMonthly.classList.remove('text-gray-500', 'font-medium');
            tabWeekly.classList.remove('bg-white', 'text-[#00205B]', 'shadow-sm', 'font-bold');
            tabWeekly.classList.add('text-gray-500', 'font-medium');

            selMonthly.classList.remove('hidden');
            selWeekly.classList.add('hidden');
        } else {
            tabWeekly.classList.add('bg-white', 'text-[#00205B]', 'shadow-sm', 'font-bold');
            tabWeekly.classList.remove('text-gray-500', 'font-medium');
            tabMonthly.classList.remove('bg-white', 'text-[#00205B]', 'shadow-sm', 'font-bold');
            tabMonthly.classList.add('text-gray-500', 'font-medium');

            selWeekly.classList.remove('hidden');
            selMonthly.classList.add('hidden');
        }
        updateStats(); 
    }

    function updateStats() {
        let count = 0;
        let hours = 0;

        // 1. Determine WHO is selected
        const selectedUserId = document.getElementById('anggotaInput').value;
        const targetUserData = userStats[selectedUserId];

        // Fade animation
        document.getElementById('statCard1').classList.add('opacity-50');
        document.getElementById('statCard2').classList.add('opacity-50');

        // 2. Fetch their specific numbers based on Month or Week
        if (targetUserData) {
            if (currentType === 'monthly') {
                const selectedMonth = document.getElementById('monthInput').value;
                if (targetUserData.monthly && targetUserData.monthly[selectedMonth]) {
                    count = targetUserData.monthly[selectedMonth].count;
                    hours = targetUserData.monthly[selectedMonth].hours;
                }
            } else {
                const selectedWeek = document.getElementById('weekInput').value;
                if (targetUserData.weekly && targetUserData.weekly[selectedWeek]) {
                    count = targetUserData.weekly[selectedWeek].count;
                    hours = targetUserData.weekly[selectedWeek].hours;
                }
            }
        }

        setTimeout(() => {
            document.getElementById('stat-approved').innerText = count;
            // Round hours to 2 decimal places to match PDF output
            document.getElementById('stat-hours').innerText = Number(hours).toFixed(2).replace(/\.00$/, '');
            
            document.getElementById('statCard1').classList.remove('opacity-50');
            document.getElementById('statCard2').classList.remove('opacity-50');
        }, 150);
    }

    function generateReport() {
        const currentCount = parseInt(document.getElementById('stat-approved').innerText);
        
        if(currentCount === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Tiada Rekod',
                text: 'Anggota ini tiada log yang disahkan untuk tempoh tersebut.',
                confirmButtonColor: '#00205B'
            });
            return;
        }

        Swal.fire({
            title: 'Menjana Laporan...',
            text: 'PDF rasmi sedang disediakan.',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        setTimeout(() => {
            Swal.close();
            // Actually submit the form to the controller
            document.getElementById('reportForm').submit();
        }, 1000);
    }
</script>
@endsection
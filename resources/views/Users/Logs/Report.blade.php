@extends('layouts.app')

@section('content')
<div class="py-6 px-4 max-w-lg mx-auto pb-24">

    {{-- Header --}}
    <div class="mb-6 flex items-center gap-3">
        <a href="{{ route('logs.history') }}" class="p-2 bg-white rounded-full border border-gray-200 text-gray-500 hover:bg-gray-50">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </a>
        <div>
            <h2 class="font-bold text-xl text-[#00205B]">Jana Laporan</h2>
            <p class="text-xs text-gray-400">Muat turun rekod aktiviti anda.</p>
        </div>
    </div>

    {{-- 1. SELECTION CARD --}}
    <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 mb-6">
        
        {{-- Tabs --}}
        <div class="flex p-1 bg-gray-100 rounded-lg mb-6">
            <button onclick="switchReportType('monthly')" id="tab-monthly" class="flex-1 py-2 text-xs font-bold rounded-md bg-white text-[#00205B] shadow-sm transition-all">
                Bulanan
            </button>
            <button onclick="switchReportType('weekly')" id="tab-weekly" class="flex-1 py-2 text-xs font-medium text-gray-500 hover:text-gray-900 transition-all">
                Mingguan
            </button>
        </div>

        {{-- Form Area (Actually submits to your PDF generator) --}}
        <form action="{{ route('Users.Logs.GeneratePDF') }}" method="POST" id="reportForm" class="space-y-4">
            @csrf

            <input type="hidden" name="report_type" id="reportTypeInput" value="monthly">

            {{-- Monthly Selector --}}
            <div id="selector-monthly">
                <label class="text-[10px] font-bold text-gray-400 uppercase mb-1 block">Pilih Bulan</label>
                <div class="relative">
                    <select name="month_value" id="monthInput" onchange="updateStats()" class="w-full pl-4 pr-10 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-700 focus:ring-blue-900 focus:border-blue-900 appearance-none">
                        @forelse($monthlyStats as $key => $stat)
                            <option value="{{ $key }}">{{ $stat['label'] }}</option>
                        @empty
                            <option value="">Tiada rekod bulan ini</option>
                        @endforelse
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-gray-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
            </div>

            {{-- Weekly Selector (Hidden by default) --}}
            <div id="selector-weekly" class="hidden">
                <label class="text-[10px] font-bold text-gray-400 uppercase mb-1 block">Pilih Minggu</label>
                <div class="relative">
                    <select name="week_value" id="weekInput" onchange="updateStats()" class="w-full pl-4 pr-10 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-700 focus:ring-blue-900 focus:border-blue-900 appearance-none">
                        @forelse($weeklyStats as $key => $stat)
                            <option value="{{ $key }}">{{ $stat['label'] }}</option>
                        @empty
                            <option value="">Tiada rekod minggu ini</option>
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
                Muat Turun Laporan PDF
            </button>
        </form>
    </div>

    {{-- 2. PREVIEW / SUMMARY CARD --}}
    <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
        <h3 class="text-sm font-bold text-gray-800 mb-4">Ringkasan Statistik</h3>
        
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

        <div class="mt-4 pt-4 border-t border-gray-100">
            <p class="text-xs text-gray-500 text-center">
                * Laporan ini dijana secara automatik berdasarkan rekod digital yang telah disahkan oleh penyelia anda.
            </p>
        </div>
    </div>
</div>

{{-- SCRIPT --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let currentType = 'monthly';
    
    // Inject the PHP Stats into Javascript securely
    const monthlyData = @json($monthlyStats);
    const weeklyData = @json($weeklyStats);

    // Run this when the page loads to set the initial numbers
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

        updateStats(); // Update the numbers based on the new tab
    }

    function updateStats() {
        let count = 0;
        let hours = 0;

        // Add a tiny animation to the cards to make it feel responsive
        document.getElementById('statCard1').classList.add('opacity-50');
        document.getElementById('statCard2').classList.add('opacity-50');

        if (currentType === 'monthly') {
            const selectedMonth = document.getElementById('monthInput').value;
            if (monthlyData[selectedMonth]) {
                count = monthlyData[selectedMonth].count;
                hours = monthlyData[selectedMonth].hours;
            }
        } else {
            const selectedWeek = document.getElementById('weekInput').value;
            if (weeklyData[selectedWeek]) {
                count = weeklyData[selectedWeek].count;
                hours = weeklyData[selectedWeek].hours;
            }
        }

        setTimeout(() => {
            document.getElementById('stat-approved').innerText = count;
            document.getElementById('stat-hours').innerText = hours;
            document.getElementById('statCard1').classList.remove('opacity-50');
            document.getElementById('statCard2').classList.remove('opacity-50');
        }, 150);
    }

    function generateReport() {
        // Validate if they actually have data to download
        const currentCount = parseInt(document.getElementById('stat-approved').innerText);
        
        if(currentCount === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Tiada Rekod',
                text: 'Tiada log yang disahkan untuk tempoh ini.',
                confirmButtonColor: '#00205B'
            });
            return;
        }

        Swal.fire({
            title: 'Menjana Laporan...',
            text: 'Sila tunggu sebentar sementara PDF disediakan.',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // Submit the form to generate the PDF
        document.getElementById('reportForm').submit();
        
        // Close loading after a short delay
        setTimeout(() => {
            Swal.close();
        }, 1500);
    }
</script>
@endsection
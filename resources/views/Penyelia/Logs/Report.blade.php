@extends('layouts.app')

@section('content')
<div class="py-6 px-4 max-w-lg mx-auto pb-24">

    {{-- Header --}}
    <div class="mb-6 flex items-center gap-3">
        <a href="{{ route('Penyelia.VerifyList') }}" class="p-2 bg-white rounded-full border border-gray-200 text-gray-500 hover:bg-gray-50">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </a>
        <div>
            <h2 class="font-bold text-xl text-[#00205B]">Laporan Penyeliaan</h2>
            <p class="text-xs text-gray-400">Muat turun rekod tugasan anggota seliaan.</p>
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

        {{-- Form Area --}}
        <div class="space-y-4">

            {{-- Monthly Selector --}}
            <div id="selector-monthly">
                <label class="text-[10px] font-bold text-gray-400 uppercase mb-1 block">Pilih Bulan</label>
                <div class="relative">
                    <select id="monthInput" class="w-full pl-4 pr-10 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-700 focus:ring-[#00205B] focus:border-[#00205B] appearance-none">
                        <option value="01">Januari 2026</option>
                        <option value="02">Februari 2026</option>
                        <option value="12">Disember 2025</option>
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
                    <select id="weekInput" class="w-full pl-4 pr-10 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-700 focus:ring-[#00205B] focus:border-[#00205B] appearance-none">
                        <option value="w4">Minggu 4 (20 Jan - 26 Jan)</option>
                        <option value="w3">Minggu 3 (13 Jan - 19 Jan)</option>
                        <option value="w2">Minggu 2 (06 Jan - 12 Jan)</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-gray-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
            </div>

            {{-- Action Button --}}
            <button onclick="generateReport()" class="w-full py-3 bg-[#00205B] text-white rounded-xl font-bold text-sm hover:bg-blue-900 shadow-lg shadow-blue-900/20 transition transform active:scale-95 flex justify-center items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Jana Laporan PDF
            </button>
        </div>
    </div>

    {{-- 2. PREVIEW / SUMMARY CARD --}}
    <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
        <h3 class="text-sm font-bold text-gray-800 mb-4">Statistik Penyeliaan</h3>
        
        <div class="grid grid-cols-2 gap-4">
            {{-- Card 1: Verified Count --}}
            <div class="p-4 bg-green-50 rounded-xl border border-green-100">
                <div class="flex items-center gap-2 mb-1">
                    <div class="w-2 h-2 rounded-full bg-green-500"></div>
                    <p class="text-xs text-green-700 font-bold">Disahkan</p>
                </div>
                <h4 class="text-2xl font-bold text-green-800" id="stat-verified">142</h4>
                <p class="text-[10px] text-green-600">Rekod bulan ini</p>
            </div>

            {{-- Card 2: Rejected/Pending Count --}}
            <div class="p-4 bg-red-50 rounded-xl border border-red-100">
                <div class="flex items-center gap-2 mb-1">
                    <div class="w-2 h-2 rounded-full bg-red-500"></div>
                    <p class="text-xs text-red-700 font-bold">Ditolak / Isu</p>
                </div>
                <h4 class="text-2xl font-bold text-red-800" id="stat-rejected">8</h4>
                <p class="text-[10px] text-red-600">Perlu tindakan</p>
            </div>
        </div>

        <div class="mt-4 pt-4 border-t border-gray-100">
            <div class="flex items-center justify-between text-xs text-gray-500">
                <span>Jumlah Anggota Seliaan:</span>
                <span class="font-bold text-gray-800">12 Orang</span>
            </div>
        </div>
    </div>

</div>

{{-- SCRIPT --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let currentType = 'monthly';

    function switchReportType(type) {
        currentType = type;
        const tabMonthly = document.getElementById('tab-monthly');
        const tabWeekly = document.getElementById('tab-weekly');
        const selMonthly = document.getElementById('selector-monthly');
        const selWeekly = document.getElementById('selector-weekly');

        // Update Tabs UI
        if(type === 'monthly') {
            tabMonthly.classList.add('bg-white', 'text-[#00205B]', 'shadow-sm', 'font-bold');
            tabMonthly.classList.remove('text-gray-500', 'font-medium');
            
            tabWeekly.classList.remove('bg-white', 'text-[#00205B]', 'shadow-sm', 'font-bold');
            tabWeekly.classList.add('text-gray-500', 'font-medium');

            selMonthly.classList.remove('hidden');
            selWeekly.classList.add('hidden');

            // Mock Update Stats for Month
            document.getElementById('stat-verified').innerText = '142';
            document.getElementById('stat-rejected').innerText = '8';
        } else {
            tabWeekly.classList.add('bg-white', 'text-[#00205B]', 'shadow-sm', 'font-bold');
            tabWeekly.classList.remove('text-gray-500', 'font-medium');
            
            tabMonthly.classList.remove('bg-white', 'text-[#00205B]', 'shadow-sm', 'font-bold');
            tabMonthly.classList.add('text-gray-500', 'font-medium');

            selWeekly.classList.remove('hidden');
            selMonthly.classList.add('hidden');

            // Mock Update Stats for Week
            document.getElementById('stat-verified').innerText = '35';
            document.getElementById('stat-rejected').innerText = '2';
        }
    }

    function generateReport() {
        // Safe check for JQuery usage or native JS
        let label = "Laporan";
        const selMonth = document.getElementById('monthInput');
        const selWeek = document.getElementById('weekInput');

        if(currentType === 'monthly') {
            label = selMonth.options[selMonth.selectedIndex].text;
        } else {
            label = selWeek.options[selWeek.selectedIndex].text;
        }

        Swal.fire({
            title: 'Menjana Laporan...',
            text: 'Sedang mengumpul data anggota untuk ' + label,
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        setTimeout(() => {
            Swal.fire({
                icon: 'success',
                title: 'Selesai!',
                text: 'Laporan penyeliaan berjaya dimuat turun.',
                confirmButtonColor: '#00205B'
            });
        }, 1500);
    }
</script>
@endsection
@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Pengesahan Tugasan') }}
    </h2>
@endsection

@section('content')
<div class="py-6 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto pb-24">
    
    {{-- 1. SEARCH BAR --}}
    <div class="mb-6">
        <div class="relative">
            <input type="text" id="searchInput" onkeyup="filterTasks()" placeholder="Cari nama anggota atau ID..." 
                   class="w-full pl-10 pr-4 py-3 rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition text-sm">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
        </div>
    </div>

    {{-- 2. TABS NAVIGATION --}}
    <div class="flex p-1 mb-6 bg-gray-100 rounded-xl">
        <button onclick="switchTab('pending')" id="tab-pending" 
                class="flex-1 py-2 text-sm font-bold rounded-lg shadow-sm bg-white text-gray-900 transition-all duration-200">
            Belum Disahkan
            <span class="ml-1 px-1.5 py-0.5 rounded-full bg-red-100 text-red-600 text-[10px]" id="pendingCount">2</span>
        </button>
        <button onclick="switchTab('verified')" id="tab-verified" 
                class="flex-1 py-2 text-sm font-medium rounded-lg text-gray-500 hover:text-gray-900 transition-all duration-200">
            Telah Disahkan
        </button>
    </div>

    {{-- 3. CONTENT SECTIONS --}}

    {{-- SECTION A: PENDING (Belum Disahkan) --}}
    <div id="content-pending" class="space-y-4 block">
        
        {{-- ITEM 1 --}}
        <div id="task-1" class="task-card bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden p-4 relative">
            <div id="stripe-1" class="absolute left-0 top-0 bottom-0 w-1 bg-yellow-400 transition-colors duration-500"></div> 
            
            <div class="flex gap-4">
                 <div class="flex flex-col items-center gap-1 shrink-0 w-12 pt-1">
                    <span class="text-sm font-bold text-gray-900">10:30</span>
                    <span class="text-[10px] text-gray-400">AM</span>
                </div>

                <div class="flex-1 min-w-0">
                    <div class="flex justify-between items-start mb-1">
                        <div>
                            <h4 class="text-sm font-bold text-gray-900 name-target">Kpl. Abu Bakar</h4>
                            <p class="text-[10px] text-gray-500">Rondaan MPV • Sektor A</p>
                        </div>
                        <span id="badge-1" class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-yellow-100 text-yellow-800 transition-colors duration-500">
                            Menunggu
                        </span>
                    </div>

                    <p class="text-xs text-gray-500 line-clamp-2 mb-3">
                        Membuat rondaan di kawasan perumahan Taman Bahagia. Keadaan terkawal.
                    </p>

                    {{-- Action Buttons Container --}}
                    <div id="actions-1" class="flex gap-2 mt-2">
                        <button onclick="openVerificationModal(1, 'Kpl. Abu Bakar')" class="flex-1 bg-[#00205B] text-white text-xs font-bold py-2 rounded-lg hover:bg-blue-900 transition shadow-sm">
                            Sahkan
                        </button>
                        <button class="px-3 bg-white border border-gray-200 text-red-600 text-xs font-bold py-2 rounded-lg hover:bg-red-50 transition">
                            Tolak
                        </button>
                        {{-- BUTIRAN BUTTON: Calls viewTaskDetails(1) --}}
                         <button onclick="viewTaskDetails(1)" class="px-3 bg-white border border-gray-200 text-gray-600 text-xs font-bold py-2 rounded-lg hover:bg-gray-50 transition">
                            Butiran
                        </button>
                    </div>

                    {{-- Signature Container --}}
                    <div id="signature-1" class="hidden mt-3 pt-2 border-t border-gray-50 animate-fade-in"></div>
                </div>
            </div>
        </div>

        {{-- ITEM 2 --}}
        <div id="task-2" class="task-card bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden p-4 relative">
            <div id="stripe-2" class="absolute left-0 top-0 bottom-0 w-1 bg-yellow-400 transition-colors duration-500"></div> 
            
            <div class="flex gap-4">
                 <div class="flex flex-col items-center gap-1 shrink-0 w-12 pt-1">
                    <span class="text-sm font-bold text-gray-900">09:15</span>
                    <span class="text-[10px] text-gray-400">AM</span>
                </div>

                <div class="flex-1 min-w-0">
                    <div class="flex justify-between items-start mb-1">
                        <div>
                            <h4 class="text-sm font-bold text-gray-900 name-target">L/Kpl Siti Aminah</h4>
                            <p class="text-[10px] text-gray-500">Kaunter Aduan</p>
                        </div>
                        <span id="badge-2" class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-yellow-100 text-yellow-800 transition-colors duration-500">
                            Menunggu
                        </span>
                    </div>
                    <p class="text-xs text-gray-500 line-clamp-2 mb-3">
                        Menerima laporan kehilangan kad pengenalan. No Repot: MR/123/2026.
                    </p>
                    <div id="actions-2" class="flex gap-2 mt-2">
                        <button onclick="openVerificationModal(2, 'L/Kpl Siti Aminah')" class="flex-1 bg-[#00205B] text-white text-xs font-bold py-2 rounded-lg hover:bg-blue-900 transition shadow-sm">
                            Sahkan
                        </button>
                        <button class="px-3 bg-white border border-gray-200 text-red-600 text-xs font-bold py-2 rounded-lg hover:bg-red-50 transition">
                            Tolak
                        </button>
                        {{-- BUTIRAN BUTTON: Calls viewTaskDetails(2) --}}
                         <button onclick="viewTaskDetails(2)" class="px-3 bg-white border border-gray-200 text-gray-600 text-xs font-bold py-2 rounded-lg hover:bg-gray-50 transition">
                            Butiran
                        </button>
                    </div>
                     <div id="signature-2" class="hidden mt-3 pt-2 border-t border-gray-50 animate-fade-in"></div>
                </div>
            </div>
        </div>

    </div>

    {{-- SECTION B: VERIFIED (Disahkan) --}}
    <div id="content-verified" class="space-y-4 hidden">
        {{-- Previously Verified Item --}}
        <div class="task-card bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden p-4 relative opacity-75 hover:opacity-100 transition">
            <div class="absolute left-0 top-0 bottom-0 w-1 bg-green-500"></div> 
            <div class="flex gap-4">
                 <div class="flex flex-col items-center gap-1 shrink-0 w-12 pt-1">
                    <span class="text-sm font-bold text-gray-900">08:00</span>
                    <span class="text-[10px] text-gray-400">AM</span>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex justify-between items-start mb-1">
                        <div>
                            <h4 class="text-sm font-bold text-gray-900 name-target">Kpl. Abu Bakar</h4>
                            <p class="text-[10px] text-gray-500">Lapor Masuk</p>
                        </div>
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-green-100 text-green-800">
                            Disahkan
                        </span>
                    </div>
                    <p class="text-xs text-gray-500 line-clamp-1">Melapor diri untuk bertugas Sif A (08-16).</p>
                    <div class="mt-2 flex items-center gap-2">
                        <div class="flex items-center text-[10px] text-gray-400 bg-gray-50 px-2 py-1 rounded border border-gray-100">
                            <svg class="w-3 h-3 mr-1 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Disahkan oleh Sjn. Mejar Halim • 08:05 AM
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ==============================
     MODAL 1: PENGESAHAN (SIGN)
     ============================== --}}
<div id="verifyModal" class="hidden fixed inset-0 z-[100] w-screen h-screen overflow-hidden" role="dialog" aria-modal="true">
    <div class="absolute inset-0 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" onclick="closeVerificationModal()"></div>
        <div class="relative z-10 w-full max-w-sm bg-white rounded-xl shadow-2xl overflow-hidden transform transition-all">
            <div class="bg-[#00205B] px-4 py-3 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-sm font-bold text-white flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Pengesahan Tugasan
                </h3>
                <button onclick="closeVerificationModal()" class="text-white/70 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div class="p-5 space-y-4">
                <div class="bg-blue-50 p-3 rounded-lg border border-blue-100">
                    <p class="text-xs text-blue-600 mb-1">Anggota:</p>
                    <p class="text-sm font-bold text-blue-900" id="verify-anggota-name">Nama Anggota</p>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Ulasan Penyelia (Opsyenal)</label>
                    <textarea id="modal-comment" rows="3" class="w-full text-sm border-gray-200 rounded-lg focus:border-blue-900 focus:ring-blue-900 placeholder-gray-400" placeholder="Masukkan ulasan atau teguran..."></textarea>
                </div>
                <div class="flex items-center gap-2 p-2 border border-dashed border-gray-300 rounded bg-gray-50">
                    <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-xs font-bold text-gray-600">SM</div>
                    <div class="text-[10px] text-gray-500">
                        <p>Ditandatangani secara digital oleh:</p>
                        <p class="font-bold text-gray-700">Sjn. Mejar Halim (ID: 8888)</p>
                        <p class="text-xs text-gray-400">{{ now()->format('d M Y, H:i') }}</p>
                    </div>
                </div>
                <div class="flex gap-2 pt-2">
                    <button onclick="closeVerificationModal()" class="flex-1 px-4 py-2 bg-white border border-gray-300 text-gray-700 text-sm font-bold rounded-lg hover:bg-gray-50">Batal</button>
                    <button onclick="saveVerification()" class="flex-1 px-4 py-2 bg-green-600 text-white text-sm font-bold rounded-lg hover:bg-green-700 shadow-lg shadow-green-600/20">Sahkan & Simpan</button>
                </div>
            </div>
            <input type="hidden" id="verify-task-id">
        </div>
    </div>
</div>

{{-- ==============================
     MODAL 2: BUTIRAN (DETAILS)
     ============================== --}}
<div id="detailModal" class="hidden fixed inset-0 z-[100] w-screen h-screen overflow-hidden" role="dialog" aria-modal="true">
    <div class="absolute inset-0 flex items-center justify-center p-4">
        {{-- Backdrop --}}
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="closeDetailModal()"></div>

        {{-- Panel --}}
        <div class="relative z-10 w-full max-w-md bg-white rounded-xl shadow-2xl overflow-hidden flex flex-col max-h-[90vh]">
            
            {{-- Header --}}
            <div class="bg-white px-5 py-4 border-b border-gray-100 flex items-center justify-between sticky top-0 z-20">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Butiran Tugasan</h3>
                    <p class="text-xs text-gray-500" id="detail-date">Tarikh...</p>
                </div>
                <button onclick="closeDetailModal()" class="p-1 bg-gray-100 rounded-full text-gray-500 hover:bg-gray-200 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            {{-- Scrollable Content --}}
            <div class="p-5 overflow-y-auto">
                
                {{-- User Info --}}
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-full bg-[#00205B] flex items-center justify-center text-white text-sm font-bold shadow-md">
                        <span id="detail-initials">AB</span>
                    </div>
                    <div>
                        <h4 class="text-base font-bold text-gray-900" id="detail-name">Nama...</h4>
                        <p class="text-xs text-gray-500" id="detail-id">ID...</p>
                    </div>
                </div>

                {{-- Task Info Grid --}}
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div class="bg-gray-50 p-3 rounded-lg border border-gray-100">
                        <p class="text-[10px] text-gray-400 uppercase tracking-wider font-bold">Jenis Tugas</p>
                        <p class="text-sm font-bold text-gray-800 mt-0.5" id="detail-type">Rondaan</p>
                    </div>
                    <div class="bg-gray-50 p-3 rounded-lg border border-gray-100">
                        <p class="text-[10px] text-gray-400 uppercase tracking-wider font-bold">Masa</p>
                        <p class="text-sm font-bold text-gray-800 mt-0.5" id="detail-time">10:00 AM</p>
                    </div>
                    <div class="col-span-2 bg-gray-50 p-3 rounded-lg border border-gray-100">
                        <p class="text-[10px] text-gray-400 uppercase tracking-wider font-bold">Lokasi</p>
                        <p class="text-sm font-bold text-gray-800 mt-0.5" id="detail-location">Lokasi...</p>
                    </div>
                </div>

                {{-- Description --}}
                <div class="mb-6">
                    <h5 class="text-sm font-bold text-gray-900 mb-2">Laporan Aktiviti</h5>
                    <p class="text-sm text-gray-600 leading-relaxed bg-white border border-gray-100 p-3 rounded-lg shadow-sm" id="detail-description">
                        Keterangan tugasan...
                    </p>
                </div>

                {{-- Supporting Image --}}
                <div id="detail-image-container" class="mb-2 hidden">
                    <h5 class="text-sm font-bold text-gray-900 mb-2">Lampiran Gambar</h5>
                    <div class="rounded-lg overflow-hidden border border-gray-200 shadow-sm">
                        <img id="detail-image" src="" alt="Bukti Tugasan" class="w-full h-auto object-cover max-h-60">
                    </div>
                </div>
                <div id="no-image-placeholder" class="hidden mb-2 p-4 text-center border-2 border-dashed border-gray-200 rounded-lg">
                    <p class="text-xs text-gray-400 italic">Tiada lampiran gambar disertakan.</p>
                </div>

            </div>

            {{-- Footer --}}
            <div class="bg-gray-50 px-5 py-3 border-t border-gray-100 text-center">
                <button onclick="closeDetailModal()" class="w-full bg-white border border-gray-300 text-gray-700 text-sm font-bold py-2.5 rounded-lg hover:bg-gray-100 transition shadow-sm">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // --- MOCK DATA FOR DETAILS ---
    const mockTasks = {
        1: {
            name: "Kpl. Abu Bakar",
            id: "RF12345",
            initials: "KA",
            type: "Rondaan MPV",
            location: "Sektor A - Taman Bahagia",
            date: "{{ now()->format('d M Y') }}",
            time: "10:30 AM",
            description: "Membuat rondaan di kawasan perumahan Taman Bahagia. Keadaan terkawal dan tiada aktiviti mencurigakan. Semakan log pintu masuk utama mendapati pengawal keselamatan bertugas dengan baik.",
            // Using a placeholder image for demo
            image: "https://images.unsplash.com/photo-1595150266023-4475476a6665?q=80&w=600&auto=format&fit=crop" 
        },
        2: {
            name: "L/Kpl Siti Aminah",
            id: "RF67890",
            initials: "SA",
            type: "Kaunter Aduan",
            location: "Balai Polis Muar",
            date: "{{ now()->format('d M Y') }}",
            time: "09:15 AM",
            description: "Menerima laporan kehilangan kad pengenalan daripada orang awam. No Repot: MR/123/2026. Pengadu telah dinasihatkan untuk ke JPN bagi urusan penggantian.",
            image: null // No image case
        }
    };

    // --- TAB SWITCHING ---
    function switchTab(tab) {
        const contentPending = document.getElementById('content-pending');
        const contentVerified = document.getElementById('content-verified');
        const tabPending = document.getElementById('tab-pending');
        const tabVerified = document.getElementById('tab-verified');

        const activeClasses = ['bg-white', 'text-gray-900', 'shadow-sm', 'font-bold'];
        const inactiveClasses = ['text-gray-500', 'font-medium', 'bg-transparent', 'shadow-none'];

        if (tab === 'pending') {
            contentPending.classList.remove('hidden');
            contentVerified.classList.add('hidden');
            
            tabPending.classList.add(...activeClasses);
            tabPending.classList.remove(...inactiveClasses, 'text-gray-500');
            
            tabVerified.classList.remove(...activeClasses);
            tabVerified.classList.add(...inactiveClasses);
        } else {
            contentVerified.classList.remove('hidden');
            contentPending.classList.add('hidden');

            tabVerified.classList.add(...activeClasses);
            tabVerified.classList.remove(...inactiveClasses, 'text-gray-500');
            
            tabPending.classList.remove(...activeClasses);
            tabPending.classList.add(...inactiveClasses);
        }
    }

    // --- VIEW DETAILS MODAL LOGIC ---
    function viewTaskDetails(taskId) {
        const data = mockTasks[taskId];
        if (!data) return;

        // Populate Data
        document.getElementById('detail-name').innerText = data.name;
        document.getElementById('detail-id').innerText = data.id;
        document.getElementById('detail-initials').innerText = data.initials;
        document.getElementById('detail-type').innerText = data.type;
        document.getElementById('detail-time').innerText = data.time;
        document.getElementById('detail-location').innerText = data.location;
        document.getElementById('detail-date').innerText = data.date;
        document.getElementById('detail-description').innerText = data.description;

        // Handle Image
        const imgContainer = document.getElementById('detail-image-container');
        const noImage = document.getElementById('no-image-placeholder');
        const imgElement = document.getElementById('detail-image');

        if (data.image) {
            imgElement.src = data.image;
            imgContainer.classList.remove('hidden');
            noImage.classList.add('hidden');
        } else {
            imgContainer.classList.add('hidden');
            noImage.classList.remove('hidden');
        }

        // Show Modal
        document.getElementById('detailModal').classList.remove('hidden');
    }

    function closeDetailModal() {
        document.getElementById('detailModal').classList.add('hidden');
    }

    // --- VERIFICATION MODAL LOGIC ---
    function openVerificationModal(taskId, anggotaName) {
        document.getElementById('verify-task-id').value = taskId;
        document.getElementById('verify-anggota-name').innerText = anggotaName;
        document.getElementById('modal-comment').value = ''; 
        document.getElementById('verifyModal').classList.remove('hidden');
    }

    function closeVerificationModal() {
        document.getElementById('verifyModal').classList.add('hidden');
    }

    function saveVerification() {
        const taskId = document.getElementById('verify-task-id').value;
        const supervisorName = "Sjn. Mejar Halim";
        const supervisorID = "8888";
        const now = new Date();
        const timeString = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

        closeVerificationModal();

        Swal.fire({
            icon: 'success',
            title: 'Tugasan Disahkan',
            text: 'Tandatangan digital telah direkodkan.',
            timer: 1500,
            showConfirmButton: false
        }).then(() => {
            updateCardUI(taskId, supervisorName, supervisorID, timeString);
        });
    }

    function updateCardUI(id, name, badgeId, time) {
        document.getElementById(`stripe-${id}`).classList.remove('bg-yellow-400');
        document.getElementById(`stripe-${id}`).classList.add('bg-green-500');

        const badge = document.getElementById(`badge-${id}`);
        badge.classList.remove('bg-yellow-100', 'text-yellow-800');
        badge.classList.add('bg-green-100', 'text-green-800');
        badge.innerText = 'Disahkan';

        document.getElementById(`actions-${id}`).remove();

        const signatureDiv = document.getElementById(`signature-${id}`);
        signatureDiv.classList.remove('hidden');
        signatureDiv.innerHTML = `
            <div class="flex flex-col gap-1">
                <div class="flex items-center text-[10px] text-gray-500 bg-gray-50 px-2 py-1.5 rounded border border-gray-100">
                    <svg class="w-3 h-3 mr-1.5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Disahkan oleh <strong>${name} (${badgeId})</strong></span>
                </div>
                <div class="flex justify-between items-center px-1">
                    <span class="text-[10px] text-gray-400">Tarikh: {{ now()->format('d M Y') }}, ${time}</span>
                </div>
            </div>
        `;
    }

    // --- SEARCH FILTER ---
    function filterTasks() {
        const input = document.getElementById('searchInput');
        const filter = input.value.toLowerCase();
        const cards = document.getElementsByClassName('task-card');

        for (let i = 0; i < cards.length; i++) {
            const nameElement = cards[i].querySelector('.name-target');
            const txtValue = nameElement.textContent || nameElement.innerText;
            if (txtValue.toLowerCase().indexOf(filter) > -1) {
                cards[i].style.display = "";
            } else {
                cards[i].style.display = "none";
            }
        }
    }
</script>

<style>
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(-5px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fade-in 0.3s ease-out forwards;
    }
</style>
@endsection
@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Pengesahan Tugasan') }}
    </h2>
@endsection

@section('content')
{{-- MOCK DATA: GROUPED BY USER --}}
@php
    $groupedTasks = [
        [
            'id' => 101, // User ID
            'name' => 'Kpl. Abu Bakar',
            'initials' => 'AB',
            'pending_count' => 2,
            'tasks' => [
                [
                    'id' => 1,
                    'time' => '10:30 AM',
                    'type' => 'Rondaan MPV',
                    'location' => 'Sektor A',
                    'desc' => 'Membuat rondaan di kawasan perumahan Taman Bahagia. Keadaan terkawal.',
                    'status' => 'pending',
                    'image' => 'https://images.unsplash.com/photo-1595150266023-4475476a6665?q=80&w=600&auto=format&fit=crop'
                ],
                [
                    'id' => 3, 
                    'time' => '11:45 AM',
                    'type' => 'Pemeriksaan Kenderaan',
                    'location' => 'Jalan Besar',
                    'desc' => 'Menahan dan memeriksa sebuah van putih dalam keadaan mencurigakan.',
                    'status' => 'pending',
                    'image' => null
                ]
            ]
        ],
        [
            'id' => 102,
            'name' => 'L/Kpl Siti Aminah',
            'initials' => 'SA',
            'pending_count' => 1,
            'tasks' => [
                [
                    'id' => 2,
                    'time' => '09:15 AM',
                    'type' => 'Kaunter Aduan',
                    'location' => 'Balai Polis',
                    'desc' => 'Menerima laporan kehilangan kad pengenalan. No Repot: MR/123/2026.',
                    'status' => 'pending',
                    'image' => null
                ]
            ]
        ]
    ];
@endphp

<div class="py-6 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto pb-24">
    
    {{-- 1. SEARCH BAR --}}
    <div class="mb-6">
        <div class="relative">
            <input type="text" id="searchInput" onkeyup="filterUserGroups()" placeholder="Cari nama anggota..." 
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
        </button>
        <button onclick="switchTab('verified')" id="tab-verified" 
                class="flex-1 py-2 text-sm font-medium rounded-lg text-gray-500 hover:text-gray-900 transition-all duration-200">
            Telah Disahkan
        </button>
    </div>

    {{-- 3. CONTENT SECTIONS --}}

    {{-- SECTION A: PENDING (GROUPED LIST) --}}
    <div id="content-pending" class="space-y-4 block">
        
        @foreach($groupedTasks as $user)
        {{-- USER GROUP CARD --}}
        <div class="user-group-card bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden" data-name="{{ strtolower($user['name']) }}">
            
            {{-- HEADER: CLICK TO EXPAND --}}
            <div onclick="toggleGroup({{ $user['id'] }})" class="p-4 flex items-center justify-between cursor-pointer bg-white hover:bg-gray-50 transition select-none group">
                <div class="flex items-center gap-3">
                    {{-- Avatar --}}
                    <div class="w-10 h-10 rounded-full bg-[#00205B] flex items-center justify-center text-white text-xs font-bold shadow-sm shrink-0">
                        {{ $user['initials'] }}
                    </div>
                    
                    {{-- User Info & Bulk Action --}}
                    <div class="flex flex-col sm:flex-row sm:items-center sm:gap-3">
                        <div>
                            <h4 class="text-sm font-bold text-gray-900">{{ $user['name'] }}</h4>
                            <p class="text-[10px] text-gray-500" id="status-text-{{ $user['id'] }}">
                                <span class="text-orange-600 font-bold" id="count-{{ $user['id'] }}">{{ $user['pending_count'] }}</span> tugasan baru
                            </p>
                        </div>

                        {{-- [NEW] BULK VERIFY BUTTON (Only show if count > 1) --}}
                        @if($user['pending_count'] > 1)
                        <button onclick="event.stopPropagation(); verifyAllUserTasks({{ $user['id'] }}, '{{ $user['name'] }}')" 
                                id="btn-verify-all-{{ $user['id'] }}"
                                class="mt-1 sm:mt-0 px-3 py-1 bg-blue-50 text-blue-700 text-[10px] font-bold rounded-full border border-blue-100 hover:bg-blue-100 transition flex items-center gap-1 w-fit">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Sahkan Semua
                        </button>
                        @endif
                    </div>
                </div>
                
                {{-- CHEVRON ICON --}}
                <div id="chevron-{{ $user['id'] }}" class="text-gray-400 transition-transform duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </div>

            {{-- BODY: LIST OF TASKS --}}
            <div id="group-body-{{ $user['id'] }}" class="hidden border-t border-gray-100 bg-gray-50/50">
                {{-- Added ID here to find tasks easier --}}
                <div class="p-3 space-y-3" id="task-list-{{ $user['id'] }}">
                    
                    @foreach($user['tasks'] as $task)
                    {{-- Added 'user-task-item' class and 'data-task-id' --}}
                    <div id="task-{{ $task['id'] }}" data-task-id="{{ $task['id'] }}" class="user-task-item bg-white border border-gray-200 rounded-xl p-3 shadow-sm relative">
                        {{-- Status Stripe --}}
                        <div id="stripe-{{ $task['id'] }}" class="absolute left-0 top-0 bottom-0 w-1 bg-yellow-400 rounded-l-xl transition-colors duration-500"></div>
                        
                        <div class="pl-3">
                            <div class="flex justify-between items-start mb-1">
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-bold text-gray-900">{{ $task['time'] }}</span>
                                    <span class="text-[10px] text-gray-400">&bull;</span>
                                    <span class="text-xs font-semibold text-gray-700">{{ $task['type'] }}</span>
                                </div>
                                <span id="badge-{{ $task['id'] }}" class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-medium bg-yellow-100 text-yellow-800">
                                    Menunggu
                                </span>
                            </div>
                            
                            <p class="text-xs text-gray-600 line-clamp-2 mb-2">
                                {{ $task['desc'] }}
                            </p>

                            {{-- Actions --}}
                            <div id="actions-{{ $task['id'] }}" class="flex gap-2 mt-2">
                                <button onclick="openVerificationModal({{ $task['id'] }}, '{{ $user['name'] }}', {{ $user['id'] }})" class="flex-1 bg-[#00205B] text-white text-[10px] font-bold py-1.5 rounded hover:bg-blue-900 transition">
                                    Sahkan
                                </button>
                                <button onclick="viewTaskDetails({{ $task['id'] }}, '{{ $user['name'] }}', '{{ $user['initials'] }}')" class="px-4 bg-white border border-gray-300 text-gray-600 text-[10px] font-bold py-1.5 rounded hover:bg-gray-50 transition">
                                    Butiran
                                </button>
                            </div>

                             {{-- Signature Container --}}
                             <div id="signature-{{ $task['id'] }}" class="hidden mt-2 pt-2 border-t border-gray-50 animate-fade-in"></div>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
        @endforeach

    </div>

    {{-- SECTION B: VERIFIED (Disahkan) --}}
    <div id="content-verified" class="space-y-4 hidden">
        <div class="text-center py-10">
            <svg class="w-16 h-16 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <p class="text-gray-500 text-sm">Tiada tugasan yang baru disahkan hari ini.</p>
        </div>
    </div>
</div>

{{-- ==============================
     MODAL 1: PENGESAHAN (SIGN)
     ============================== --}}
<div id="verifyModal" class="hidden fixed inset-0 z-[100] w-screen h-screen overflow-hidden" role="dialog" aria-modal="true">
    <input type="hidden" id="verify-task-id">
    <input type="hidden" id="verify-user-id">
    
    {{-- [NEW] This input tracks if we are doing Single or Batch --}}
    <input type="hidden" id="verify-mode" value="single">
    
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
                {{-- Anggota Name --}}
                <div class="bg-blue-50 p-3 rounded-lg border border-blue-100">
                    <p class="text-xs text-blue-600 mb-1">Anggota:</p>
                    <p class="text-sm font-bold text-blue-900" id="verify-anggota-name">Nama Anggota</p>
                </div>
                
                {{-- Comment --}}
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Ulasan Penyelia (Optional)</label>
                    <textarea id="modal-comment" rows="3" class="w-full text-sm border-gray-200 rounded-lg focus:border-blue-900 focus:ring-blue-900 placeholder-gray-400 border-2" placeholder="Masukkan ulasan atau teguran..."></textarea>
                </div>

                {{-- Signature Pad --}}
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-2">Tandatangan Digital</label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg bg-gray-50 overflow-hidden">
                        <canvas id="signaturePad" class="w-full h-40 bg-white cursor-crosshair"></canvas>
                    </div>
                    <div class="flex justify-between items-center mt-2">
                        <button type="button" onclick="clearSignature()" class="text-xs text-red-600 hover:text-red-700 font-medium flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            Padam
                        </button>
                        <span class="text-[10px] text-gray-400">Sila tandatangan di ruang putih</span>
                    </div>
                </div>

                {{-- SIGNATURE INFO (Restored) --}}
                <div class="flex items-center gap-2 p-2 border border-dashed border-gray-300 rounded bg-gray-50">
                    <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-xs font-bold text-gray-600">SM</div>
                    <div class="text-[10px] text-gray-500">
                        <p>Ditandatangani secara digital oleh:</p>
                        <p class="font-bold text-gray-700">Sjn. Mejar Halim (ID: 8888)</p>
                        <p class="text-xs text-gray-400">{{ now()->format('d M Y, H:i') }}</p>
                    </div>
                </div>

                {{-- Buttons --}}
                <div class="flex gap-2 pt-2">
                    <button onclick="closeVerificationModal()" class="flex-1 px-4 py-2 bg-white border border-gray-300 text-gray-700 text-sm font-bold rounded-lg hover:bg-gray-50">Batal</button>
                    <button onclick="saveVerification()" class="flex-1 px-4 py-2 bg-green-600 text-white text-sm font-bold rounded-lg hover:bg-green-700 shadow-lg shadow-green-600/20">Sahkan & Simpan</button>
                </div>
            </div>
            <input type="hidden" id="verify-task-id">
            <input type="hidden" id="verify-user-id">
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
                    <p class="text-xs text-gray-500" id="detail-date">{{ now()->format('d M Y') }}</p>
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

<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let signaturePad = null;

    // --- ACCORDION LOGIC ---
    function toggleGroup(userId) {
        const body = document.getElementById(`group-body-${userId}`);
        const chevron = document.getElementById(`chevron-${userId}`);
        
        if (body.classList.contains('hidden')) {
            body.classList.remove('hidden');
            chevron.classList.add('rotate-180');
        } else {
            body.classList.add('hidden');
            chevron.classList.remove('rotate-180');
        }
    }

    // --- SEARCH FILTER ---
    function filterUserGroups() {
        const input = document.getElementById('searchInput');
        const filter = input.value.toLowerCase();
        const groups = document.getElementsByClassName('user-group-card');

        for (let i = 0; i < groups.length; i++) {
            const name = groups[i].getAttribute('data-name');
            if (name.indexOf(filter) > -1) {
                groups[i].style.display = "";
            } else {
                groups[i].style.display = "none";
            }
        }
    }

    // --- SIGNATURE PAD SETUP ---
    function initializeSignaturePad() {
        const canvas = document.getElementById('signaturePad');
        if (!canvas) return;
        const ratio = Math.max(window.devicePixelRatio || 1, 1);
        canvas.width = canvas.offsetWidth * ratio;
        canvas.height = canvas.offsetHeight * ratio;
        canvas.getContext("2d").scale(ratio, ratio);
        signaturePad = new SignaturePad(canvas, { backgroundColor: 'rgb(255, 255, 255)', penColor: 'rgb(0, 32, 91)' });
    }

    function clearSignature() { if (signaturePad) signaturePad.clear(); }
    function getSignatureData() { return (signaturePad && !signaturePad.isEmpty()) ? signaturePad.toDataURL('image/png') : null; }

    // --- [1] OPEN MODAL: SINGLE TASK ---
    function openVerificationModal(taskId, name, userId) {
        document.getElementById('verify-mode').value = 'single'; // Set Single Mode
        document.getElementById('verify-task-id').value = taskId;
        document.getElementById('verify-user-id').value = userId;
        document.getElementById('verify-anggota-name').innerText = name;
        document.getElementById('modal-comment').value = ''; 
        
        document.getElementById('verifyModal').classList.remove('hidden');
        setTimeout(() => initializeSignaturePad(), 100);
    }

    // --- [2] OPEN MODAL: BATCH (ALL TASKS) ---
    function verifyAllUserTasks(userId, name) {
        document.getElementById('verify-mode').value = 'batch'; // Set Batch Mode
        document.getElementById('verify-user-id').value = userId;
        document.getElementById('verify-anggota-name').innerText = name + " (Semua Tugasan)";
        document.getElementById('modal-comment').value = ''; 
        
        document.getElementById('verifyModal').classList.remove('hidden');
        setTimeout(() => initializeSignaturePad(), 100);
    }

    function closeVerificationModal() {
        document.getElementById('verifyModal').classList.add('hidden');
        if (signaturePad) signaturePad.clear();
    }

    // --- [3] SAVE LOGIC (HANDLES BOTH) ---
    function saveVerification() {
        const mode = document.getElementById('verify-mode').value;
        const signatureData = getSignatureData();
        const userId = document.getElementById('verify-user-id').value;

        if (!signatureData) {
            Swal.fire({ icon: 'warning', title: 'Tandatangan Diperlukan', text: 'Sila tandatangan sebelum mengesahkan.', confirmButtonColor: '#00205B' });
            return;
        }

        closeVerificationModal();

        Swal.fire({
            icon: 'success',
            title: mode === 'batch' ? 'Semua Tugasan Disahkan' : 'Tugasan Disahkan',
            timer: 1500,
            showConfirmButton: false
        }).then(() => {
            if (mode === 'batch') {
                // Find all tasks for this user and verify them loop
                const container = document.getElementById(`task-list-${userId}`);
                const tasks = container.querySelectorAll('.user-task-item');
                
                tasks.forEach(task => {
                    const taskId = task.getAttribute('data-task-id');
                    // Check if task still needs verification (buttons exist)
                    if(document.getElementById(`actions-${taskId}`)) {
                        updateCardUI(taskId, userId, signatureData, false); // false = don't update count yet
                    }
                });
                
                // Finally set count to 0 and hide "Verify All" button
                updateUserCountUI(userId, 0);

            } else {
                // Single Update
                const taskId = document.getElementById('verify-task-id').value;
                updateCardUI(taskId, userId, signatureData, true); // true = decrease count by 1
            }
        });
    }

    // Helper: Updates visual state of ONE card
    function updateCardUI(taskId, userId, signatureImage, updateCount) {
        // Change colors
        document.getElementById(`stripe-${taskId}`).classList.replace('bg-yellow-400', 'bg-green-500');
        const badge = document.getElementById(`badge-${taskId}`);
        badge.classList.replace('bg-yellow-100', 'bg-green-100');
        badge.classList.replace('text-yellow-800', 'text-green-800');
        badge.innerText = 'Disahkan';
        
        // Remove buttons
        const actionDiv = document.getElementById(`actions-${taskId}`);
        if(actionDiv) actionDiv.remove();

        // Show Signature
        const signatureDiv = document.getElementById(`signature-${taskId}`);
        signatureDiv.classList.remove('hidden');
        signatureDiv.innerHTML = `
            <div class="flex flex-col gap-2">
                <div class="flex items-center text-[10px] text-gray-500 bg-gray-50 px-2 py-1 rounded border border-gray-100">
                    <svg class="w-3 h-3 mr-1 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span>Disahkan oleh <strong>Sjn. Mejar Halim</strong></span>
                </div>
                <img src="${signatureImage}" alt="Tandatangan" class="h-12 w-auto self-start border border-gray-100 rounded p-1 bg-white">
            </div>
        `;

        // If single mode, decrement count
        if(updateCount) {
            decrementUserCount(userId);
        }
    }

    // Helper: Decrease count by 1
    function decrementUserCount(userId) {
        const countSpan = document.getElementById(`count-${userId}`);
        let currentCount = parseInt(countSpan.innerText);
        if (currentCount > 1) {
            updateUserCountUI(userId, currentCount - 1);
        } else {
            updateUserCountUI(userId, 0);
        }
    }

    // Helper: Update Header Count/Status
    function updateUserCountUI(userId, count) {
        const countSpan = document.getElementById(`count-${userId}`);
        const statusText = document.getElementById(`status-text-${userId}`);
        const verifyAllBtn = document.getElementById(`btn-verify-all-${userId}`);

        countSpan.innerText = count;

        if (count === 0) {
            // Show "Semua Disahkan" green text
            statusText.innerHTML = `<span class="text-green-600 font-bold flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Semua Disahkan</span>`;
            // Remove the bulk button if it exists
            if(verifyAllBtn) verifyAllBtn.remove();
        }
    }

    // --- MOCK DATA FOR BUTIRAN ---
    // (Keep your existing mockTaskData and viewTaskDetails function here)
    const mockTaskData = {
        1: { type: "Rondaan MPV", location: "Sektor A", desc: "Membuat rondaan...", time: "10:30 AM", image: "https://images.unsplash.com/photo-1595150266023-4475476a6665?q=80&w=600" },
        2: { type: "Kaunter Aduan", location: "Balai Polis", desc: "Menerima laporan...", time: "09:15 AM", image: null },
        3: { type: "Pemeriksaan", location: "Jalan Besar", desc: "Menahan van putih...", time: "11:45 AM", image: null }
    };

    // --- FIXED VIEW DETAILS FUNCTION ---
    // This now populates the specific IDs in the HTML instead of replacing innerHTML
    function viewTaskDetails(taskId, name, initials) {
        const data = mockTaskData[taskId];
        
        // 1. Set Header Info
        document.getElementById('detail-name').innerText = name;
        document.getElementById('detail-initials').innerText = initials;
        
        // 2. Set Text Fields
        document.getElementById('detail-type').innerText = data.type;
        document.getElementById('detail-time').innerText = data.time;
        document.getElementById('detail-location').innerText = data.location;
        document.getElementById('detail-description').innerText = data.desc;

        // 3. Handle Image Logic
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

        // 4. Show Modal
        document.getElementById('detailModal').classList.remove('hidden');
    }

    function closeDetailModal() {
        document.getElementById('detailModal').classList.add('hidden');
    }

    // --- SIGNATURE & VERIFICATION LOGIC ---
    function initializeSignaturePad() {
        const canvas = document.getElementById('signaturePad');
        if (!canvas) return;
        const ratio = Math.max(window.devicePixelRatio || 1, 1);
        canvas.width = canvas.offsetWidth * ratio;
        canvas.height = canvas.offsetHeight * ratio;
        canvas.getContext("2d").scale(ratio, ratio);
        signaturePad = new SignaturePad(canvas, { backgroundColor: 'rgb(255, 255, 255)', penColor: 'rgb(0, 32, 91)' });
    }

    function clearSignature() { if (signaturePad) signaturePad.clear(); }
    function getSignatureData() { return (signaturePad && !signaturePad.isEmpty()) ? signaturePad.toDataURL('image/png') : null; }

    function openVerificationModal(taskId, name, userId) {
        document.getElementById('verify-task-id').value = taskId;
        document.getElementById('verify-user-id').value = userId; 
        document.getElementById('verify-anggota-name').innerText = name;
        document.getElementById('modal-comment').value = ''; 
        document.getElementById('verifyModal').classList.remove('hidden');
        setTimeout(() => initializeSignaturePad(), 100);
    }

    function closeVerificationModal() {
        document.getElementById('verifyModal').classList.add('hidden');
        if (signaturePad) signaturePad.clear();
    }

    function saveVerification() {
        const taskId = document.getElementById('verify-task-id').value;
        const userId = document.getElementById('verify-user-id').value;
        const signatureData = getSignatureData();

        if (!signatureData) {
            Swal.fire({ icon: 'warning', title: 'Tandatangan Diperlukan', text: 'Sila tandatangan sebelum mengesahkan.', confirmButtonColor: '#00205B' });
            return;
        }

        closeVerificationModal();

        Swal.fire({
            icon: 'success',
            title: 'Tugasan Disahkan',
            timer: 1500,
            showConfirmButton: false
        }).then(() => {
            updateCardUI(taskId, userId, signatureData);
        });
    }

    function updateCardUI(taskId, userId, signatureImage) {
        // 1. Update Task Card Visuals
        document.getElementById(`stripe-${taskId}`).classList.replace('bg-yellow-400', 'bg-green-500');
        const badge = document.getElementById(`badge-${taskId}`);
        badge.classList.replace('bg-yellow-100', 'bg-green-100');
        badge.classList.replace('text-yellow-800', 'text-green-800');
        badge.innerText = 'Disahkan';
        document.getElementById(`actions-${taskId}`).remove(); 

        // Add Signature Display
        const signatureDiv = document.getElementById(`signature-${taskId}`);
        signatureDiv.classList.remove('hidden');
        signatureDiv.innerHTML = `
            <div class="flex flex-col gap-2">
                <div class="flex items-center text-[10px] text-gray-500 bg-gray-50 px-2 py-1 rounded border border-gray-100">
                    <svg class="w-3 h-3 mr-1 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span>Disahkan oleh <strong>Sjn. Mejar Halim</strong></span>
                </div>
                <img src="${signatureImage}" alt="Tandatangan" class="h-12 w-auto self-start border border-gray-100 rounded p-1 bg-white">
            </div>
        `;

        // 2. Update Parent Group Count
        const countSpan = document.getElementById(`count-${userId}`);
        const statusText = document.getElementById(`status-text-${userId}`);
        let currentCount = parseInt(countSpan.innerText);
        
        if (currentCount > 1) {
            countSpan.innerText = currentCount - 1;
        } else {
            countSpan.innerText = 0;
            statusText.innerHTML = `<span class="text-green-600 font-bold flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Semua Disahkan</span>`;
        }
    }

    function switchTab(tab) {
        const pending = document.getElementById('content-pending');
        const verified = document.getElementById('content-verified');
        const btnP = document.getElementById('tab-pending');
        const btnV = document.getElementById('tab-verified');

        if(tab === 'pending') {
            pending.classList.remove('hidden'); verified.classList.add('hidden');
            btnP.classList.add('bg-white', 'text-gray-900', 'shadow-sm', 'font-bold'); btnP.classList.remove('text-gray-500');
            btnV.classList.remove('bg-white', 'text-gray-900', 'shadow-sm', 'font-bold'); btnV.classList.add('text-gray-500');
        } else {
            verified.classList.remove('hidden'); pending.classList.add('hidden');
            btnV.classList.add('bg-white', 'text-gray-900', 'shadow-sm', 'font-bold'); btnV.classList.remove('text-gray-500');
            btnP.classList.remove('bg-white', 'text-gray-900', 'shadow-sm', 'font-bold'); btnP.classList.add('text-gray-500');
        }
    }
</script>

<style>
    @keyframes fade-in { from { opacity: 0; transform: translateY(-5px); } to { opacity: 1; transform: translateY(0); } }
    .animate-fade-in { animation: fade-in 0.3s ease-out forwards; }
</style>
@endsection
@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Tetapan Sistem') }}
    </h2>
@endsection

@section('content')
@php
    // Mock Data
    $types = [
        ['id' => 1, 'name' => 'Rondaan MPV'],
        ['id' => 2, 'name' => 'Rondaan URB'],
        ['id' => 3, 'name' => 'Bit / Pondok Polis'],
        ['id' => 4, 'name' => 'Tugas Pejabat'],
        ['id' => 5, 'name' => 'Operasi Khas'],
    ];

    $areas = [
        ['id' => 1, 'name' => 'Pos Pengawal'],
        ['id' => 2, 'name' => 'Kaunter Aduan'],
        ['id' => 3, 'name' => 'Bilik Siasatan'],
        ['id' => 4, 'name' => 'Bilik Operasi'],
        ['id' => 5, 'name' => 'Lokap / Penjara'],
    ];

    $ranks = [
        ['id' => 1, 'name' => 'Konstabel (Konst)'],
        ['id' => 2, 'name' => 'Lans Koperal (L/Kpl)'],
        ['id' => 3, 'name' => 'Koperal (Kpl)'],
        ['id' => 4, 'name' => 'Sarjan (Sjn)'],
        ['id' => 5, 'name' => 'Sub-Inspektor (SI)'],
    ];

    // NEW: Emergency Contacts Data
    $contacts = [
        ['id' => 1, 'name' => 'IPD Muar', 'phone' => '06-952 6001'],
        ['id' => 2, 'name' => 'Bomba Muar', 'phone' => '06-951 4444'],
        ['id' => 3, 'name' => 'Hospital Sultanah Fatimah', 'phone' => '06-952 1999'],
        ['id' => 4, 'name' => 'APM (Pertahanan Awam)', 'phone' => '06-951 3999'],
        ['id' => 5, 'name' => 'Bilik Gerakan', 'phone' => '06-952 6002'],
    ];
@endphp

<div class="py-6 px-4 sm:px-6 lg:px-8 max-w-[90rem] mx-auto pb-24">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-[#00205B]">Konfigurasi Data</h1>
        <p class="text-sm text-gray-500">Uruskan senarai pilihan dan maklumat rujukan sistem.</p>
    </div>

    {{-- CHANGED: Updated grid to support 4 columns on extra large screens --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-1 gap-6">

        {{-- COLUMN 1: JENIS PENUGASAN --}}
        <div class="space-y-4">
            <div class="flex items-center justify-between mb-2">
                <div class="flex items-center gap-2">
                    <div class="p-2 bg-blue-100 rounded-lg text-blue-900">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Jenis Tugas</h3>
                        <p class="text-xs text-gray-400">Pilihan Penugasan</p>
                    </div>
                </div>
                <button onclick="openModal('add', 'Jenis Tugas')" class="px-3 py-1.5 bg-blue-50 text-blue-700 text-xs font-bold rounded-lg border border-blue-100 hover:bg-blue-100 transition flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah
                </button>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <ul class="divide-y divide-gray-100 max-h-[400px] overflow-y-auto">
                    @foreach($types as $type)
                    <li class="px-4 py-3 flex items-center justify-between group hover:bg-gray-50 transition">
                        <span class="text-sm font-medium text-gray-700">{{ $type['name'] }}</span>
                        <div class="flex items-center gap-2 opacity-50 group-hover:opacity-100 transition">
                            <button onclick="openModal('edit', 'Jenis Tugas', '{{ $type['name'] }}', {{ $type['id'] }})" class="text-blue-600 hover:bg-blue-50 p-1.5 rounded-md">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </button>
                            <button onclick="deleteItem('{{ $type['name'] }}')" class="text-red-600 hover:bg-red-50 p-1.5 rounded-md">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>

        {{-- COLUMN 2: KAWASAN PENUGASAN --}}
        <div class="space-y-4">
             <div class="flex items-center justify-between mb-2">
                <div class="flex items-center gap-2">
                    <div class="p-2 bg-indigo-100 rounded-lg text-indigo-900">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Kawasan</h3>
                        <p class="text-xs text-gray-400">Lokasi Penugasan</p>
                    </div>
                </div>
                <button onclick="openModal('add', 'Kawasan')" class="px-3 py-1.5 bg-indigo-50 text-indigo-700 text-xs font-bold rounded-lg border border-indigo-100 hover:bg-indigo-100 transition flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah
                </button>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <ul class="divide-y divide-gray-100 max-h-[400px] overflow-y-auto">
                    @foreach($areas as $area)
                    <li class="px-4 py-3 flex items-center justify-between group hover:bg-gray-50 transition">
                        <span class="text-sm font-medium text-gray-700">{{ $area['name'] }}</span>
                        <div class="flex items-center gap-2 opacity-50 group-hover:opacity-100 transition">
                             <button onclick="openModal('edit', 'Kawasan', '{{ $area['name'] }}', {{ $area['id'] }})" class="text-blue-600 hover:bg-blue-50 p-1.5 rounded-md">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </button>
                            <button onclick="deleteItem('{{ $area['name'] }}')" class="text-red-600 hover:bg-red-50 p-1.5 rounded-md">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>

        {{-- COLUMN 3: SENARAI JAWATAN --}}
        <div class="space-y-4">
             <div class="flex items-center justify-between mb-2">
                <div class="flex items-center gap-2">
                    <div class="p-2 bg-emerald-100 rounded-lg text-emerald-900">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Pangkat</h3>
                        <p class="text-xs text-gray-400">Senarai Jawatan</p>
                    </div>
                </div>
                <button onclick="openModal('add', 'Jawatan')" class="px-3 py-1.5 bg-emerald-50 text-emerald-700 text-xs font-bold rounded-lg border border-emerald-100 hover:bg-emerald-100 transition flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah
                </button>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <ul class="divide-y divide-gray-100 max-h-[400px] overflow-y-auto">
                    @foreach($ranks as $rank)
                    <li class="px-4 py-3 flex items-center justify-between group hover:bg-gray-50 transition">
                        <span class="text-sm font-medium text-gray-700">{{ $rank['name'] }}</span>
                        <div class="flex items-center gap-2 opacity-50 group-hover:opacity-100 transition">
                             <button onclick="openModal('edit', 'Jawatan', '{{ $rank['name'] }}', {{ $rank['id'] }})" class="text-blue-600 hover:bg-blue-50 p-1.5 rounded-md">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </button>
                            <button onclick="deleteItem('{{ $rank['name'] }}')" class="text-red-600 hover:bg-red-50 p-1.5 rounded-md">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>

        {{-- COLUMN 4: EMERGENCY CONTACTS (New) --}}
        <div class="space-y-4">
             <div class="flex items-center justify-between mb-2">
                <div class="flex items-center gap-2">
                    <div class="p-2 bg-red-100 rounded-lg text-red-900">
                        {{-- Phone/SOS Icon --}}
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Kecemasan</h3>
                        <p class="text-xs text-gray-400">Hubungan Penting</p>
                    </div>
                </div>
                <button onclick="openModal('add', 'Hubungan')" class="px-3 py-1.5 bg-red-50 text-red-700 text-xs font-bold rounded-lg border border-red-100 hover:bg-red-100 transition flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah
                </button>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <ul class="divide-y divide-gray-100 max-h-[400px] overflow-y-auto">
                    @foreach($contacts as $contact)
                    <li class="px-4 py-3 flex items-center justify-between group hover:bg-gray-50 transition">
                        <div class="flex flex-col">
                            <span class="text-sm font-medium text-gray-800">{{ $contact['name'] }}</span>
                            <span class="text-xs text-gray-500">{{ $contact['phone'] }}</span>
                        </div>
                        <div class="flex items-center gap-2 opacity-50 group-hover:opacity-100 transition">
                             <button onclick="openModal('edit', 'Hubungan', '{{ $contact['name'] }} - {{ $contact['phone'] }}', {{ $contact['id'] }})" class="text-blue-600 hover:bg-blue-50 p-1.5 rounded-md">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </button>
                            <button onclick="deleteItem('{{ $contact['name'] }}')" class="text-red-600 hover:bg-red-50 p-1.5 rounded-md">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>

    </div>
</div>

{{-- MODAL (Reusable) --}}
<div id="dataModal" style="display: none;" class="fixed inset-0 z-[100] w-screen h-screen overflow-hidden" role="dialog" aria-modal="true">
    <div class="absolute inset-0 flex items-center justify-center p-4">
        {{-- Backdrop --}}
        <div class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" onclick="closeModal()"></div>

        {{-- Panel --}}
        <div class="relative z-10 w-full max-w-md bg-white rounded-xl shadow-2xl overflow-hidden ring-1 ring-black/5 transform transition-all">
            
            <div class="bg-gray-50 px-4 py-4 border-b border-gray-100 flex items-center gap-3">
                <div class="p-2 bg-blue-100 rounded-lg text-blue-900 shrink-0">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800" id="modalTitle">Tambah Data</h3>
            </div>

            <div class="p-6">
                <form id="modalForm" action="#" method="POST">
                    @csrf
                    <div id="methodField"></div>
                    
                    <label id="inputLabel" for="itemName" class="block text-sm font-medium text-gray-700 mb-1">Nama Item</label>
                    <input type="text" id="itemName" name="name" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-blue-900 focus:border-blue-900 text-sm transition-all" placeholder="Masukkan nama..." required>
                    
                    <div class="mt-6 flex justify-end gap-3">
                        <button type="button" onclick="closeModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none transition-colors">
                            Batal
                        </button>
                        <button type="button" onclick="submitMock()" class="px-4 py-2 text-sm font-bold text-white bg-[#00205B] rounded-lg hover:bg-blue-900 focus:outline-none shadow-lg shadow-blue-900/20 transition-all transform hover:scale-105">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // 1. OPEN MODAL
    function openModal(action, category, currentName = '', id = null) {
        const modal = document.getElementById('dataModal');
        const title = document.getElementById('modalTitle');
        const input = document.getElementById('itemName');
        const label = document.getElementById('inputLabel');
        const methodField = document.getElementById('methodField');

        modal.style.display = 'block'; 

        // Adjust label for Emergency Contacts
        if (category === 'Hubungan') {
            label.innerText = 'Nama & No. Telefon';
            input.placeholder = 'Cth: Bomba - 999';
        } else {
            label.innerText = 'Nama Item';
            input.placeholder = 'Masukkan nama...';
        }

        if (action === 'add') {
            title.innerText = 'Tambah ' + category + ' Baru';
            input.value = '';
            methodField.innerHTML = ''; 
        } else {
            title.innerText = 'Kemaskini ' + category;
            input.value = currentName;
            methodField.innerHTML = '<input type="hidden" name="_method" value="PUT">';
        }
        
        setTimeout(() => input.focus(), 100);
    }

    // 2. CLOSE MODAL
    function closeModal() {
        const modal = document.getElementById('dataModal');
        modal.style.display = 'none';
    }

    // 3. MOCK SUBMIT
    function submitMock() {
        closeModal();
        Swal.fire({
            icon: 'success',
            title: 'Berjaya!',
            text: 'Data telah disimpan.',
            timer: 1500,
            showConfirmButton: false
        });
    }

    // 4. DELETE
    function deleteItem(name) {
        Swal.fire({
            title: 'Padam Data?',
            text: "Adakah anda pasti mahu memadam '" + name + "'?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Padam',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire('Berjaya!', 'Data telah dipadam.', 'success');
            }
        })
    }
    
    // Close modal on ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const modal = document.getElementById('dataModal');
            if (modal.style.display !== 'none') {
                closeModal();
            }
        }
    });
</script>
@endsection
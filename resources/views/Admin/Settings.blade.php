@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Tetapan Sistem') }}
    </h2>
@endsection

@section('content')
@php

    $contacts = [
        ['id' => 1, 'name' => 'IPD Pekan', 'phone' => '06-952 6001'],
        ['id' => 2, 'name' => 'Bomba Pekan', 'phone' => '06-951 4444'],
        ['id' => 3, 'name' => 'Hospital Sultanah Fatimah', 'phone' => '06-952 1999'],
        ['id' => 4, 'name' => 'APM (Pertahanan Awam)', 'phone' => '06-951 3999'],
    ];
@endphp

<div class="py-6 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto pb-24">
    {{-- Success Alert --}}
    @if(session('success'))
        <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg shadow-sm text-sm font-bold flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg shadow-sm text-sm">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-[#00205B]">Konfigurasi Data</h1>
        <p class="text-sm text-gray-500">Uruskan senarai pilihan dan maklumat rujukan sistem.</p>
    </div>

    <div class="space-y-4">

        {{-- SECTION 1: JENIS TUGAS --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div onclick="toggleSection('section-types')" class="p-4 flex items-center justify-between cursor-pointer hover:bg-gray-50 transition select-none">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-blue-100 rounded-lg text-blue-900">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-gray-800">Jenis Tugas</h3>
                        <p class="text-xs text-gray-500">Urus senarai jenis penugasan (Luar/Dalam).</p>
                    </div>
                </div>
                <svg id="icon-section-types" class="w-5 h-5 text-gray-400 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </div>
            
            <div id="section-types" class="hidden border-t border-gray-100 bg-gray-50/50">
                <div class="p-4">
                    <div class="flex justify-end mb-4">
                        <button onclick="openPenugasanModal('add', '{{ route('Admin.Settings.StorePenugasan') }}')" class="px-3 py-1.5 bg-[#00205B] text-white text-xs font-bold rounded-lg hover:bg-blue-900 transition flex items-center gap-1 shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Tambah Tugasan
                        </button>
                    </div>
                    <ul class="space-y-2">
                        @forelse($all_penugasan as $item)
                        <li class="bg-white p-3 rounded-lg border border-gray-200 flex items-center justify-between shadow-sm">
                            <div class="flex items-center gap-3">
                                <span class="px-2 py-1 text-[10px] font-bold uppercase rounded {{ $item->category == 'Kawasan Luar' ? 'bg-purple-100 text-purple-700 border border-purple-200' : 'bg-orange-100 text-orange-700 border border-orange-200' }}">
                                    {{ $item->category }}
                                </span>
                                <div>
                                    <span class="text-sm font-medium text-gray-700">{{ $item->name }}</span>
                                    @if($item->description)
                                    <p class="text-[10px] text-gray-400">{{ $item->description }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <button onclick="openPenugasanModal('edit', '{{ route('Admin.Settings.UpdatePenugasan', $item->id) }}', '{{ $item->name }}', '{{ $item->category }}', '{{ $item->description }}')" class="text-gray-400 hover:text-blue-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </button>
                                <button onclick="deletePenugasan('{{ route('Admin.Settings.DeletePenugasan', $item->id) }}', '{{ $item->name }}')" class="text-gray-400 hover:text-red-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </li>
                        @empty
                        <li class="text-center text-sm text-gray-400 py-4 italic">Tiada data penugasan.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        {{-- SECTION 2: PANGKAT --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div onclick="toggleSection('section-ranks')" class="p-4 flex items-center justify-between cursor-pointer hover:bg-gray-50 transition select-none">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-emerald-100 rounded-lg text-emerald-900">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-gray-800">Pangkat</h3>
                        <p class="text-xs text-gray-500">Urus senarai pangkat anggota.</p>
                    </div>
                </div>
                <svg id="icon-section-ranks" class="w-5 h-5 text-gray-400 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </div>
            
            <div id="section-ranks" class="hidden border-t border-gray-100 bg-gray-50/50">
                <div class="p-4">
                    <div class="flex justify-end mb-4">
                        <button onclick="openPangkatModal('add', '{{ route('Admin.Settings.StorePangkat') }}')" class="px-3 py-1.5 bg-[#00205B] text-white text-xs font-bold rounded-lg hover:bg-blue-900 transition flex items-center gap-1 shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Tambah Pangkat
                        </button>
                    </div>
                    <ul class="space-y-2">
                        @if(!empty($all_pangkat))
                            @foreach($all_pangkat as $pangkat)
                            <li class="bg-white p-3 rounded-lg border border-gray-200 flex items-center justify-between shadow-sm">
                                <span class="text-sm font-medium text-black">{{ $pangkat['pangkat_name'] }}</span>
                                <div class="flex items-center gap-2">
                                    <button onclick="openPangkatModal('edit', '{{ route('Admin.Settings.UpdatePangkat', $pangkat['id']) }}', '{{ $pangkat['pangkat_name'] }}')" class="text-gray-400 hover:text-blue-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </button>
                                    <button onclick="deleteItem('{{ $pangkat['pangkat_name'] }}', 'pangkat')" class="text-gray-400 hover:text-red-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </li>
                            @endforeach
                        @else
                            <li class="text-center text-sm text-gray-400 py-4 italic">Tiada pangkat dijumpai.</li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>

        {{-- SECTION 3: KECEMASAN --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div onclick="toggleSection('section-contacts')" class="p-4 flex items-center justify-between cursor-pointer hover:bg-gray-50 transition select-none">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-red-100 rounded-lg text-red-900">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-gray-800">Kecemasan</h3>
                        <p class="text-xs text-gray-500">Urus nombor telefon penting.</p>
                    </div>
                </div>
                <svg id="icon-section-contacts" class="w-5 h-5 text-gray-400 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </div>
            
            <div id="section-contacts" class="hidden border-t border-gray-100 bg-gray-50/50">
                <div class="p-4">
                    <div class="flex justify-end mb-4">
                        <button onclick="openKecemasanModal('add', '{{ route('Admin.Settings.StoreKecemasan') }}')" class="px-3 py-1.5 bg-[#00205B] text-white text-xs font-bold rounded-lg hover:bg-blue-900 transition flex items-center gap-1 shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Tambah Nombor
                        </button>
                    </div>
                    <ul class="space-y-2">
                        @foreach($contacts as $contact)
                        <li class="bg-white p-3 rounded-lg border border-gray-200 flex items-center justify-between shadow-sm">
                            <div class="flex flex-col">
                                <span class="text-sm font-medium text-gray-800">{{ $contact['name'] }}</span>
                                <span class="text-xs text-gray-500">{{ $contact['phone'] }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <button onclick="openKecemasanModal('edit', '{{ route('Admin.Settings.UpdateKecemasan', $contact['id']) }}', '{{ $contact['name'] }}', '{{ $contact['phone'] }}')" class="text-gray-400 hover:text-blue-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </button>
                                <button onclick="deleteItem('{{ $contact['name'] }}', 'kecemasan')" class="text-gray-400 hover:text-red-600">
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
</div>

{{-- ============================================
     MODAL 1: PENUGASAN (JENIS TUGAS)
     ============================================ --}}
<div id="penugasanModal" style="display: none;" class="fixed inset-0 z-[100] w-screen h-screen overflow-hidden" role="dialog" aria-modal="true">
    <div class="absolute inset-0 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" onclick="closePenugasanModal()"></div>
        <div class="relative z-10 w-full max-w-md bg-white rounded-xl shadow-2xl overflow-hidden ring-1 ring-black/5 transform transition-all">
            
            <div class="bg-gray-50 px-4 py-4 border-b border-gray-100 flex items-center gap-3">
                <div class="p-2 bg-blue-100 rounded-lg text-blue-900 shrink-0">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800" id="penugasanModalTitle">Tambah Jenis Tugas</h3>
            </div>

            <div class="p-6">
                <form id="penugasanForm" action="" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="_method" id="penugasanMethod">
                    <div>
                        <label for="penugasanName" class="block text-sm font-medium text-gray-700 mb-1">Nama Tugasan</label>
                        <input type="text" id="penugasanName" name="name" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-blue-900 focus:border-blue-900 text-sm transition-all" placeholder="Masukkan nama tugasan..." required>
                    </div>

                    <div>
                        <label for="penugasanCategory" class="block text-sm font-medium text-gray-700 mb-1">Kategori Tugas</label>
                        <select id="penugasanCategory" name="category" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-blue-900 focus:border-blue-900 text-sm transition-all" required>
                            <option value="Kawasan Luar">Kawasan Luar</option>
                            <option value="Kawasan Dalam">Kawasan Dalam</option>
                        </select>
                    </div>

                    <div>
                        <label for="penugasanDescription" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi (Optional)</label>
                        <input type="text" id="penugasanDescription" name="description" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-blue-900 focus:border-blue-900 text-sm transition-all" placeholder="Keterangan ringkas...">
                    </div>
                    
                    <div class="flex justify-end gap-3 pt-4">
                        <button type="button" onclick="closePenugasanModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none transition-colors">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2 text-sm font-bold text-white bg-[#00205B] rounded-lg hover:bg-blue-900 focus:outline-none shadow-lg shadow-blue-900/20 transition-all transform hover:scale-105">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- ============================================
     MODAL 2: PANGKAT
     ============================================ --}}
<div id="pangkatModal" style="display: none;" class="fixed inset-0 z-[100] w-screen h-screen overflow-hidden" role="dialog" aria-modal="true">
    <div class="absolute inset-0 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" onclick="closePangkatModal()"></div>
        <div class="relative z-10 w-full max-w-md bg-white rounded-xl shadow-2xl overflow-hidden ring-1 ring-black/5 transform transition-all">
            
            <div class="bg-gray-50 px-4 py-4 border-b border-gray-100 flex items-center gap-3">
                <div class="p-2 bg-emerald-100 rounded-lg text-emerald-900 shrink-0">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800" id="pangkatModalTitle">Tambah Pangkat</h3>
            </div>

            <div class="p-6">
                <form id="pangkatForm" action="" method="POST" class="space-y-4">
                    @csrf
                    
                    <div>
                        <label for="pangkatName" class="block text-sm font-medium text-gray-700 mb-1">Nama Pangkat</label>
                        <input type="text" id="pangkatName" name="name" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-blue-900 focus:border-blue-900 text-sm transition-all" placeholder="Masukkan nama pangkat..." required>
                    </div>
                    
                    <div class="flex justify-end gap-3 pt-4">
                        <button type="button" onclick="closePangkatModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none transition-colors">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2 text-sm font-bold text-white bg-[#00205B] rounded-lg hover:bg-blue-900 focus:outline-none shadow-lg shadow-blue-900/20 transition-all transform hover:scale-105">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- ============================================
     MODAL 3: KECEMASAN
     ============================================ --}}
<div id="kecemasanModal" style="display: none;" class="fixed inset-0 z-[100] w-screen h-screen overflow-hidden" role="dialog" aria-modal="true">
    <div class="absolute inset-0 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" onclick="closeKecemasanModal()"></div>
        <div class="relative z-10 w-full max-w-md bg-white rounded-xl shadow-2xl overflow-hidden ring-1 ring-black/5 transform transition-all">
            
            <div class="bg-gray-50 px-4 py-4 border-b border-gray-100 flex items-center gap-3">
                <div class="p-2 bg-red-100 rounded-lg text-red-900 shrink-0">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800" id="kecemasanModalTitle">Tambah Nombor Kecemasan</h3>
            </div>

            <div class="p-6">
                <form id="kecemasanForm" action="" method="POST" class="space-y-4">
                    @csrf
                    
                    <div>
                        <label for="kecemasanName" class="block text-sm font-medium text-gray-700 mb-1">Nama Agensi/Individu</label>
                        <input type="text" id="kecemasanName" name="name" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-blue-900 focus:border-blue-900 text-sm transition-all" placeholder="Masukkan nama..." required>
                    </div>

                    <div>
                        <label for="kecemasanPhone" class="block text-sm font-medium text-gray-700 mb-1">No. Telefon</label>
                        <input type="text" id="kecemasanPhone" name="phone" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-blue-900 focus:border-blue-900 text-sm transition-all" placeholder="012-3456789" required>
                    </div>
                    
                    <div class="flex justify-end gap-3 pt-4">
                        <button type="button" onclick="closeKecemasanModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none transition-colors">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2 text-sm font-bold text-white bg-[#00205B] rounded-lg hover:bg-blue-900 focus:outline-none shadow-lg shadow-blue-900/20 transition-all transform hover:scale-105">
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
    // ============================================
    // ACCORDION TOGGLE (SHARED)
    // ============================================
    function toggleSection(id) {
        const content = document.getElementById(id);
        const icon = document.getElementById('icon-' + id);
        
        if (content.classList.contains('hidden')) {
            content.classList.remove('hidden');
            icon.classList.add('rotate-180');
        } else {
            content.classList.add('hidden');
            icon.classList.remove('rotate-180');
        }
    }

    // ============================================
    // MODAL 1: PENUGASAN FUNCTIONS
    // ============================================
    function openPenugasanModal(action, routeUrl = '#', name = '', category = 'Kawasan Luar', description = '') {
        const modal = document.getElementById('penugasanModal');
        const form = document.getElementById('penugasanForm');
        const title = document.getElementById('penugasanModalTitle');
        const nameInput = document.getElementById('penugasanName');
        const categoryInput = document.getElementById('penugasanCategory');
        const descriptionInput = document.getElementById('penugasanDescription');
        const methodInput = document.getElementById('penugasanMethod'); 

        modal.style.display = 'block';
        form.action = routeUrl;

        if (action === 'add') {
            title.innerText = 'Tambah Jenis Tugas';
            nameInput.value = '';
            categoryInput.value = 'Kawasan Luar';
            descriptionInput.value = '';
            methodInput.value = 'POST'; 
        } else {
            title.innerText = 'Kemaskini Jenis Tugas';
            nameInput.value = name;
            categoryInput.value = category;
            descriptionInput.value = description;
            methodInput.value = 'PUT';
        }

        setTimeout(() => nameInput.focus(), 100);
    }


    function closePenugasanModal() {
        document.getElementById('penugasanModal').style.display = 'none';
    }

    // ============================================
    // MODAL 2: PANGKAT FUNCTIONS
    // ============================================
    function openPangkatModal(action, routeUrl = '#', name = '') {
        const modal = document.getElementById('pangkatModal');
        const form = document.getElementById('pangkatForm');
        const title = document.getElementById('pangkatModalTitle');
        const nameInput = document.getElementById('pangkatName');

        modal.style.display = 'block';
        form.action = routeUrl;
        
        if (action === 'add') {
            title.innerText = 'Tambah Pangkat';
            nameInput.value = '';
        } else {
            title.innerText = 'Kemaskini Pangkat';
            nameInput.value = name;
        }
        
        setTimeout(() => nameInput.focus(), 100);
    }

    function closePangkatModal() {
        document.getElementById('pangkatModal').style.display = 'none';
    }

    // ============================================
    // MODAL 3: KECEMASAN FUNCTIONS
    // ============================================
    function openKecemasanModal(action, routeUrl = '#', name = '', phone = '') {
        const modal = document.getElementById('kecemasanModal');
        const form = document.getElementById('kecemasanForm');
        const title = document.getElementById('kecemasanModalTitle');
        const nameInput = document.getElementById('kecemasanName');
        const phoneInput = document.getElementById('kecemasanPhone');

        modal.style.display = 'block';
        form.action = routeUrl;
        
        if (action === 'add') {
            title.innerText = 'Tambah Nombor Kecemasan';
            nameInput.value = '';
            phoneInput.value = '';
        } else {
            title.innerText = 'Kemaskini Nombor Kecemasan';
            nameInput.value = name;
            phoneInput.value = phone;
        }
        
        setTimeout(() => nameInput.focus(), 100);
    }

    function closeKecemasanModal() {
        document.getElementById('kecemasanModal').style.display = 'none';
    }

    // ============================================
    // DELETE FUNCTION (SHARED)
    // ============================================
    function deleteItem(name, type = '') {
        let typeText = '';
        if (type === 'penugasan') typeText = 'tugasan';
        else if (type === 'pangkat') typeText = 'pangkat';
        else if (type === 'kecemasan') typeText = 'nombor kecemasan';
        
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
                // Submit DELETE form or Ajax call here
                Swal.fire('Berjaya!', 'Data telah dipadam.', 'success');
            }
        })
    }

    // ============================================
    // CLOSE MODALS ON ESC KEY (OPTIONAL)
    // ============================================
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closePenugasanModal();
            closePangkatModal();
            closeKecemasanModal();
        }
    });

    function deletePenugasan(routeUrl, name) {
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

                // Create form dynamically
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = routeUrl;

                // CSRF token
                const csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = '{{ csrf_token() }}';

                // Method spoofing DELETE
                const method = document.createElement('input');
                method.type = 'hidden';
                method.name = '_method';
                method.value = 'DELETE';

                form.appendChild(csrf);
                form.appendChild(method);

                document.body.appendChild(form);
                form.submit();
            }
        });
    }

</script>
@endsection
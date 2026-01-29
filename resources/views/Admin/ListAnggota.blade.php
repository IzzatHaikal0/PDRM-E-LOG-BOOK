@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Senarai Anggota') }}
    </h2>
@endsection

@section('content')
{{-- MOCK DATA --}}
@php
    $stats = [
        ['label' => 'Inspektor', 'count' => 4, 'color' => 'bg-red-50 text-red-700', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
        ['label' => 'Sarjan', 'count' => 12, 'color' => 'bg-orange-50 text-orange-700', 'icon' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'],
        ['label' => 'Koperal', 'count' => 28, 'color' => 'bg-yellow-50 text-yellow-700', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
        ['label' => 'L/Kpl & Konst', 'count' => 45, 'color' => 'bg-blue-50 text-blue-700', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'],
    ];

    $users = [
        ['name' => 'Ahmad Albab', 'id' => 'RF12345', 'rank' => 'Inspektor', 'phone' => '012-3456789', 'badge' => 'I-1234'],
        ['name' => 'Siti Nurhaliza', 'id' => 'RF67890', 'rank' => 'Sarjan', 'phone' => '013-9876543', 'badge' => 'S-5678'],
        ['name' => 'Chong Wei', 'id' => 'RF11223', 'rank' => 'Koperal', 'phone' => '019-8877665', 'badge' => 'K-9900'],
        ['name' => 'Muthu Sami', 'id' => 'RF44556', 'rank' => 'L/Kpl', 'phone' => '017-3344556', 'badge' => 'L-1122'],
        ['name' => 'Sarah Ali', 'id' => 'RF99887', 'rank' => 'Konstabel', 'phone' => '011-1234123', 'badge' => 'K-3344'],
    ];
@endphp

<div class="py-6 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-[#00205B]">Direktori Anggota</h1>
            <p class="text-sm text-gray-500">Senarai penuh anggota dan pegawai berdaftar.</p>
        </div>
        <a href="{{ route('Admin.Registration') }}" class="inline-flex justify-center items-center px-4 py-2 bg-[#00205B] text-white rounded-lg text-sm font-bold shadow-md hover:bg-blue-900 transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Anggota
        </a>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        @foreach($stats as $stat)
            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-md transition">
                <div>
                    <p class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">{{ $stat['label'] }}</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $stat['count'] }}</h3>
                </div>
                <div class="p-2 rounded-lg {{ $stat['color'] }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat['icon'] }}"></path>
                    </svg>
                </div>
            </div>
        @endforeach
    </div>

    <div class="bg-white p-4 rounded-t-xl shadow-sm border border-gray-100 border-b-0 flex flex-col md:flex-row gap-4 items-center justify-between">
        <div class="relative w-full md:w-96">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input type="text" class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg leading-5 bg-gray-50 placeholder-gray-400 focus:outline-none focus:bg-white focus:ring-1 focus:ring-blue-900 sm:text-sm" placeholder="Cari Nama, ID atau No. Tel...">
        </div>
        <div class="w-full md:w-auto flex items-center gap-2">
            <span class="text-xs text-gray-500 hidden md:block">Susun Ikut:</span>
            <select class="block w-full md:w-48 pl-3 pr-10 py-2 text-base border-gray-200 focus:outline-none focus:ring-blue-900 focus:border-blue-900 sm:text-sm rounded-lg">
                <option>Semua Pangkat</option>
                <option>Pegawai Kanan</option>
                <option>Pegawai Rendah</option>
            </select>
        </div>
    </div>

    {{-- DESKTOP TABLE --}}
    <div class="hidden md:block bg-white shadow-sm border border-gray-100 rounded-b-xl overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Anggota</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Pangkat / ID</th>
                    {{-- NEW COLUMN: Nombor Badan --}}
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">No. Badan</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">No. Telefon</th>
                    <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Tindakan</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($users as $user)
                <tr class="hover:bg-blue-50/50 transition">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-800 font-bold text-sm">
                                {{ substr($user['name'], 0, 2) }}
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-bold text-gray-900">{{ $user['name'] }}</div>
                                <div class="text-xs text-gray-500">{{ $user['id'] }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                            {{ $user['rank'] }}
                        </span>
                    </td>
                    {{-- NEW COLUMN DATA --}}
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-700">
                        {{ $user['badge'] }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $user['phone'] }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('Admin.EditUser', ['id' => $user['id']]) }}" class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 p-2 rounded-lg transition" title="Kemaskini">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                            <button onclick="confirmDelete('{{ $user['name'] }}')" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 p-2 rounded-lg transition" title="Padam">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
            <div class="flex justify-between items-center">
                <p class="text-xs text-gray-700">Menunjukkan 1-5 dari 97</p>
                <div class="flex gap-2">
                    <button class="px-3 py-1 border rounded text-xs hover:bg-gray-50">Sebelum</button>
                    <button class="px-3 py-1 border rounded text-xs hover:bg-gray-50">Seterusnya</button>
                </div>
            </div>
        </div>
    </div>

    {{-- MOBILE CARD VIEW --}}
    <div class="md:hidden space-y-3">
        @foreach($users as $user)
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 relative">
            <div class="flex items-start gap-3">
                 <div class="h-12 w-12 rounded-full bg-blue-50 flex items-center justify-center text-blue-900 font-bold text-sm border border-blue-100 flex-shrink-0">
                    {{ substr($user['name'], 0, 2) }}
                </div>
                <div class="flex-1 min-w-0">
                    <h4 class="text-sm font-bold text-gray-900 truncate">{{ $user['name'] }}</h4>
                    <p class="text-xs text-gray-500">{{ $user['rank'] }} &bull; {{ $user['id'] }}</p>
                    {{-- Badge Number displayed here for mobile --}}
                    <p class="text-xs text-gray-400 mt-1">No. Badan: <span class="font-semibold text-gray-600">{{ $user['badge'] }}</span></p>
                </div>
            </div>
            
            <div class="flex items-center justify-end gap-2 border-t border-gray-50 pt-3 mt-3">
                <a href="{{ route('Admin.EditUser', ['id' => $user['id']]) }}" class="flex-1 flex items-center justify-center px-3 py-1.5 text-xs font-medium text-blue-700 bg-blue-50 rounded-lg">
                    Edit
                </a>
                <button onclick="confirmDelete('{{ $user['name'] }}')" class="flex-1 flex items-center justify-center px-3 py-1.5 text-xs font-medium text-red-700 bg-red-50 rounded-lg">
                    Padam
                </button>
            </div>
        </div>
        @endforeach
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(name) {
        Swal.fire({
            title: 'Anda pasti?',
            text: "Adakah anda ingin memadam anggota: " + name + "?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Padam!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                    'Berjaya!',
                    'Anggota telah dipadam.',
                    'success'
                )
            }
        })
    }
</script>
@endsection
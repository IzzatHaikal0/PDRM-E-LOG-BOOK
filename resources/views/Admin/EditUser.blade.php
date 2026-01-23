@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Kemaskini Anggota') }}
    </h2>
@endsection

@section('content')
<div class="py-6 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-[#00205B]">Kemaskini Maklumat Anggota</h1>
        <p class="text-sm text-gray-500">Kemaskini butiran anggota untuk ID: <span class="font-mono font-bold text-gray-700">RF12345</span></p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        
        <div class="bg-orange-600 px-6 py-4">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-white/10 rounded-lg text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-white">Edit Profil</h3>
                    <p class="text-xs text-orange-100">Perubahan akan direkodkan dalam sistem.</p>
                </div>
            </div>
        </div>

        <div class="p-6">
            <form method="POST" action="#" class="space-y-6"> @csrf
                @method('PUT')

                <div>
                    <h4 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-orange-600"></span> Maklumat Perkhidmatan
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="rank" class="block text-sm font-medium text-gray-700 mb-1">Pangkat</label>
                            <select id="rank" name="rank" class="block w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                                <option value="inspektor" selected>Inspektor (Insp)</option> {{-- Pre-selected --}}
                                <option value="sarjan">Sarjan (Sjn)</option>
                                <option value="koperal">Koperal (Kpl)</option>
                            </select>
                        </div>
                        <div>
                            <label for="badge_number" class="block text-sm font-medium text-gray-700 mb-1">Nombor Badan / ID</label>
                            <input type="text" name="badge_number" id="badge_number" value="RF12345" readonly 
                                class="block w-full px-4 py-2.5 bg-gray-100 border border-gray-200 rounded-lg text-gray-500 cursor-not-allowed sm:text-sm">
                            <p class="text-xs text-red-500 mt-1">*Nombor badan tidak boleh diubah.</p>
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-100 my-2"></div>

                <div>
                    <h4 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-orange-600"></span> Maklumat Peribadi
                    </h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Penuh</label>
                            <input type="text" name="name" id="name" value="Ahmad Albab Bin Labu"
                                class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                        </div>
                        <div>
                            <label for="ic_number" class="block text-sm font-medium text-gray-700 mb-1">No. Kad Pengenalan</label>
                            <input type="text" name="ic_number" id="ic_number" value="880101-01-5555"
                                class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                        </div>
                         <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Nombor Telefon</label>
                            <input type="tel" name="phone" id="phone" value="012-3456789"
                                class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                        </div>
                        <div class="md:col-span-2">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat Emel</label>
                            <input type="email" name="email" id="email" value="ahmad.albab@pdrm.gov.my"
                                class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                        </div>
                        <div class="md:col-span-2">
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Alamat Tetap</label>
                            <textarea id="address" name="address" rows="3"
                                class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-orange-500 focus:border-orange-500 sm:text-sm">No 12, Jalan Polis 1, Taman Perumahan PDRM, 84000 Muar, Johor.</textarea>
                        </div>
                    </div>
                </div>

                <div class="pt-4 flex items-center justify-end gap-3">
                    <a href="{{ route('Admin.ListAnggota') }}" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                        Batal
                    </a>
                    <button type="submit" class="px-5 py-2.5 text-sm font-bold text-white bg-orange-600 rounded-lg hover:bg-orange-700 shadow-lg shadow-orange-500/30 transition">
                        Simpan Perubahan
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
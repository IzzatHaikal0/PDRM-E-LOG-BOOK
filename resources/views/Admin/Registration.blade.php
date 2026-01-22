@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Pendaftaran Anggota') }}
    </h2>
@endsection

@section('content')
<div class="py-6 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-[#00205B]">Daftar Anggota Baru</h1>
        <p class="text-sm text-gray-500">Masukkan maklumat peribadi dan perkhidmatan anggota.</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        
        <div class="bg-[#00205B] px-6 py-4">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-white/10 rounded-lg text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-white">Butiran Anggota</h3>
                    <p class="text-xs text-blue-200">Pastikan semua maklumat adalah tepat.</p>
                </div>
            </div>
        </div>

        <div class="p-6">
            <form method="POST" action="}" class="space-y-6">
                @csrf

                <div>
                    <h4 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-blue-600"></span> Maklumat Perkhidmatan
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <div>
                            <label for="rank" class="block text-sm font-medium text-gray-700 mb-1">Pangkat</label>
                            <div class="relative">
                                <select id="rank" name="rank" class="block w-full pl-3 pr-10 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-blue-900 focus:border-blue-900 sm:text-sm">
                                    <option value="" disabled selected>Pilih Pangkat</option>
                                    <option value="konstabel">Konstabel (Konst)</option>
                                    <option value="lans_koperal">Lans Koperal (L/Kpl)</option>
                                    <option value="koperal">Koperal (Kpl)</option>
                                    <option value="sarjan">Sarjan (Sjn)</option>
                                    <option value="inspektor">Inspektor (Insp)</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label for="badge_number" class="block text-sm font-medium text-gray-700 mb-1">Nombor Badan / ID</label>
                            <input type="text" name="badge_number" id="badge_number" placeholder="Contoh: RF12345"
                                class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-blue-900 focus:border-blue-900 sm:text-sm">
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-100 my-2"></div>

                <div>
                    <h4 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-blue-600"></span> Maklumat Peribadi
                    </h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Penuh</label>
                            <input type="text" name="name" id="name" placeholder="Nama seperti dalam Kad Pengenalan" 
                                class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-blue-900 focus:border-blue-900 sm:text-sm">
                        </div>

                        <div>
                            <label for="ic_number" class="block text-sm font-medium text-gray-700 mb-1">No. Kad Pengenalan</label>
                            <input type="text" name="ic_number" id="ic_number" placeholder="Contoh: 880101-01-5555" 
                                class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-blue-900 focus:border-blue-900 sm:text-sm">
                        </div>

                         <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Nombor Telefon</label>
                            <input type="tel" name="phone" id="phone" placeholder="Contoh: 012-3456789" 
                                class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-blue-900 focus:border-blue-900 sm:text-sm">
                        </div>

                        <div class="md:col-span-2">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat Emel</label>
                            <input type="email" name="email" id="email" placeholder="nama@pdrm.gov.my" 
                                class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-blue-900 focus:border-blue-900 sm:text-sm">
                        </div>

                        <div class="md:col-span-2">
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Alamat Tetap</label>
                            <textarea id="address" name="address" rows="3" placeholder="Alamat kediaman semasa..." 
                                class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-blue-900 focus:border-blue-900 sm:text-sm"></textarea>
                        </div>
                    </div>
                </div>

                <div class="pt-4 flex items-center justify-end gap-3">
                    <button type="button" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-4 focus:ring-gray-100">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2.5 text-sm font-bold text-white bg-[#00205B] rounded-lg hover:bg-blue-900 focus:ring-4 focus:ring-blue-900/30 shadow-lg shadow-blue-900/30 transition transform hover:-translate-y-0.5">
                        Simpan Maklumat
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
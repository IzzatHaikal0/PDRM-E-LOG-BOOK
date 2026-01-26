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
        <p class="text-sm text-gray-500">Pilih kaedah pendaftaran: secara manual atau muat naik serentak.</p>
    </div>

    <div class="mb-6 border-b border-gray-200">
        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
            <button onclick="switchTab('manual')" id="tab-manual" 
                class="border-[#00205B] text-[#00205B] whitespace-nowrap py-4 px-1 border-b-2 font-bold text-sm transition-colors">
                Pendaftaran Manual
            </button>

            <button onclick="switchTab('bulk')" id="tab-bulk" 
                class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                Pendaftaran Serentak
            </button>
        </nav>
    </div>

    <div id="content-manual" class="block">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-[#00205B] px-6 py-4">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-white/10 rounded-lg text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-white">Borang Manual</h3>
                        <p class="text-xs text-blue-200">Isi maklumat untuk seorang anggota.</p>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <form method="POST" action="#" class="space-y-6">
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
                                <input type="text" name="badge_number" id="badge_number" placeholder="Contoh: RF12345" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-blue-900 focus:border-blue-900 sm:text-sm">
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
                                <input type="text" name="name" id="name" placeholder="Nama seperti dalam Kad Pengenalan" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-blue-900 focus:border-blue-900 sm:text-sm">
                            </div>
                            <div>
                                <label for="ic_number" class="block text-sm font-medium text-gray-700 mb-1">No. Kad Pengenalan</label>
                                <input type="text" name="ic_number" id="ic_number" placeholder="Contoh: 880101-01-5555" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-blue-900 focus:border-blue-900 sm:text-sm">
                            </div>
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Nombor Telefon</label>
                                <input type="tel" name="phone" id="phone" placeholder="Contoh: 012-3456789" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-blue-900 focus:border-blue-900 sm:text-sm">
                            </div>
                            <div class="md:col-span-2">
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat Emel</label>
                                <input type="email" name="email" id="email" placeholder="nama@pdrm.gov.my" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-blue-900 focus:border-blue-900 sm:text-sm">
                            </div>
                            <div class="md:col-span-2">
                                <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Alamat Tetap</label>
                                <textarea id="address" name="address" rows="3" placeholder="Alamat kediaman semasa..." class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-blue-900 focus:border-blue-900 sm:text-sm"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 flex items-center justify-end gap-3">
                        <button type="button" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-4 focus:ring-gray-100">Batal</button>
                        <button type="submit" class="px-5 py-2.5 text-sm font-bold text-white bg-[#00205B] rounded-lg hover:bg-blue-900 focus:ring-4 focus:ring-blue-900/30 shadow-lg shadow-blue-900/30 transition transform hover:-translate-y-0.5">Simpan Maklumat</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="content-bulk" class="hidden">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            
            <div class="bg-indigo-900 px-6 py-4">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-white/10 rounded-lg text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-white">Muat Naik Serentak</h3>
                        <p class="text-xs text-indigo-200">Import ramai anggota menggunakan fail Excel/CSV.</p>
                    </div>
                </div>
            </div>

            <div class="p-8">
                <div class="mb-8 bg-blue-50 border border-blue-100 rounded-xl p-4 flex items-start justify-between">
                    <div>
                        <h4 class="text-sm font-bold text-blue-900 mb-1">Langkah 1: Muat Turun Template</h4>
                        <p class="text-xs text-blue-700">Sila gunakan template rasmi untuk mengelakkan ralat data.</p>
                    </div>
                    <a href="#" class="px-4 py-2 bg-white border border-blue-200 text-blue-700 text-xs font-bold rounded-lg hover:bg-blue-50 shadow-sm flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        Muat Turun .XLSX
                    </a>
                </div>

                <form action="#" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-6">
                        <h4 class="text-sm font-bold text-gray-900 mb-2">Langkah 2: Muat Naik Fail</h4>
                        <div class="flex items-center justify-center w-full">
                            <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-48 border-2 border-gray-300 border-dashed rounded-2xl cursor-pointer bg-gray-50 hover:bg-gray-100 transition">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                    <p class="mb-2 text-sm text-gray-500"><span class="font-semibold text-[#00205B]">Klik untuk muat naik</span> atau seret fail ke sini</p>
                                    <p class="text-xs text-gray-500">XLSX atau CSV (MAX. 5MB)</p>
                                </div>
                                <input id="dropzone-file" type="file" class="hidden" name="bulk_file" />
                            </label>
                        </div>
                    </div>

                    <div class="text-xs text-gray-500 space-y-1 mb-6">
                        <p class="font-semibold">Nota Penting:</p>
                        <ul class="list-disc pl-4 space-y-1">
                            <li>Pastikan format tarikh lahir adalah DD/MM/YYYY.</li>
                            <li>Nombor Badan/ID mestilah unik untuk setiap anggota.</li>
                            <li>Kolum 'Pangkat' mesti mengikut ejaan: <em>Konstabel, Lans Koperal, Koperal, Sarjan, Inspektor</em>.</li>
                        </ul>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="px-6 py-3 text-sm font-bold text-white bg-indigo-900 rounded-lg hover:bg-indigo-800 focus:ring-4 focus:ring-indigo-900/30 shadow-lg shadow-indigo-900/20 transition transform hover:-translate-y-0.5">
                            Proses Fail
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<script>
    function switchTab(tab) {
        // Elements
        const btnManual = document.getElementById('tab-manual');
        const btnBulk = document.getElementById('tab-bulk');
        const contentManual = document.getElementById('content-manual');
        const contentBulk = document.getElementById('content-bulk');

        // Styles
        const activeClass = ['border-[#00205B]', 'text-[#00205B]', 'font-bold'];
        const inactiveClass = ['border-transparent', 'text-gray-500', 'font-medium'];

        if (tab === 'manual') {
            // Show Manual, Hide Bulk
            contentManual.classList.remove('hidden');
            contentBulk.classList.add('hidden');

            // Update Tab Styling
            btnManual.classList.add(...activeClass);
            btnManual.classList.remove(...inactiveClass);
            
            btnBulk.classList.add(...inactiveClass);
            btnBulk.classList.remove(...activeClass);
        } else {
            // Show Bulk, Hide Manual
            contentBulk.classList.remove('hidden');
            contentManual.classList.add('hidden');

            // Update Tab Styling
            btnBulk.classList.add(...activeClass);
            btnBulk.classList.remove(...inactiveClass);

            btnManual.classList.add(...inactiveClass);
            btnManual.classList.remove(...activeClass);
        }
    }
</script>
@endsection
@extends('layouts.app')

@section('content')
<div class="py-6 px-4 max-w-lg mx-auto pb-24">

    {{-- 1. HEADER & SEARCH --}}
    <div class="mb-6">
        <h2 class="font-bold text-xl text-[#00205B] mb-1">Direktori Perhubungan</h2>
        <p class="text-xs text-gray-500 mb-4">Carian nombor telefon pegawai penyelia & jabatan.</p>

        <div class="relative">
            <input type="text" id="searchInput" onkeyup="filterContacts()" placeholder="Cari nama, pangkat atau peranan..." 
                   class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 bg-white text-sm focus:ring-2 focus:ring-[#00205B] focus:border-[#00205B] shadow-sm transition">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
        </div>
    </div>

    {{-- 2. TABS BUTTONS --}}
    <div class="flex p-1 mb-6 bg-gray-100 rounded-xl border border-gray-200">
        <button onclick="switchContactTab('penyelia')" id="tab-penyelia" 
                class="flex-1 py-2.5 text-xs font-bold rounded-lg shadow-sm bg-white text-[#00205B] border border-gray-100 transition-all duration-200">
            Senarai Contact
        </button>
        <button onclick="switchContactTab('kecemasan')" id="tab-kecemasan" 
                class="flex-1 py-2.5 text-xs font-medium rounded-lg text-gray-500 hover:text-gray-900 transition-all duration-200">
            Senarai Jabatan
        </button>
    </div>

    {{-- 3. CONTENT AREA --}}

    {{-- === VIEW A: PENYELIA LIST === --}}
    <div id="view-penyelia" class="space-y-3 animate-fade-in">
        
        @forelse($contact_penyelia ?? [] as $penyelia)
        <div class="contact-card bg-white p-4 rounded-xl border border-gray-100 shadow-sm flex items-center justify-between hover:shadow-md transition">
            
            {{-- Left: Info --}}
            <div class="flex items-center gap-3 overflow-hidden">
                {{-- Initials Avatar (Blue theme for Penyelia) --}}
                <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-800 font-bold flex items-center justify-center text-sm shrink-0 uppercase">
                    {{ substr($penyelia->name, 0, 2) }}
                </div>
                
                <div class="min-w-0">
                    <h4 class="font-bold text-gray-800 text-sm truncate search-name">{{ $penyelia->name }}</h4>
                    <p class="text-xs text-gray-500 truncate search-role">
                        {{ $penyelia->pangkat->pangkat_name ?? 'Pegawai PDRM' }} 
                        {{-- Add station/department here if available in your User model --}}
                        {{-- • {{ $penyelia->cawangan ?? 'IPD' }} --}}
                    </p>
                </div>
            </div>

            {{-- Right: Actions --}}
            <div class="flex items-center gap-2 shrink-0">
                
                {{-- Clean Phone Number for WhatsApp --}}
                @php 
                    $cleanPhonePenyelia = preg_replace('/[^0-9]/', '', $penyelia->no_telefon);
                    if(!str_starts_with($cleanPhonePenyelia, '6') && !empty($cleanPhonePenyelia)) $cleanPhonePenyelia = '6' . $cleanPhonePenyelia;
                @endphp

                @if(!empty($cleanPhonePenyelia))
                    {{-- WhatsApp --}}
                    <a href="https://wa.me/{{ $cleanPhonePenyelia }}" target="_blank" class="w-9 h-9 rounded-lg bg-green-50 text-green-600 flex items-center justify-center border border-green-100 hover:bg-green-100 transition">
                       <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                    </a>
                @endif

                {{-- Call --}}
                <a href="tel:{{ $penyelia->no_telefon }}" class="w-9 h-9 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center border border-blue-100 hover:bg-blue-100 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                </a>
            </div>
        </div>
        @empty
        <div class="text-center py-6 text-sm text-gray-400">Tiada senarai penyelia direkodkan.</div>
        @endforelse
    </div>

    {{-- === VIEW B: KECEMASAN LIST === --}}
    <div id="view-kecemasan" class="space-y-3 hidden animate-fade-in">
        
        {{-- Pinned MERS 999 --}}
        <div class="bg-gradient-to-r from-red-600 to-red-800 rounded-2xl p-4 text-white shadow-lg relative overflow-hidden mb-4 contact-card">
            <div class="absolute right-0 top-0 w-24 h-24 bg-white/10 rounded-full -mr-10 -mt-10"></div>
            <div class="flex justify-between items-center relative z-10">
                <div>
                    <h4 class="font-bold text-lg search-name">MERS 999</h4>
                    <p class="text-red-100 text-xs search-role">Talian Kecemasan Umum</p>
                </div>
                <a href="tel:999" class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-red-600 shadow-md active:scale-95 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                </a>
            </div>
        </div>

        @forelse($kecemasans as $kecemasan)
        <div class="contact-card bg-white p-4 rounded-xl border border-gray-100 shadow-sm flex items-center justify-between hover:shadow-md transition">
            
            {{-- Left: Info --}}
            <div class="flex items-center gap-3 overflow-hidden">
                <div class="w-10 h-10 rounded-full bg-red-50 text-red-800 font-bold flex items-center justify-center text-sm shrink-0 uppercase">
                    {{ substr($kecemasan->name, 0, 2) }}
                </div>
                
                <div class="min-w-0">
                    <h4 class="font-bold text-gray-800 text-sm truncate search-name">{{ $kecemasan->name }}</h4>
                    <p class="text-xs text-gray-500 truncate search-role">Kenalan Kecemasan</p>
                </div>
            </div>

            {{-- Right: Actions --}}
            <div class="flex items-center gap-2 shrink-0">
                
                @php 
                    $cleanPhone = preg_replace('/[^0-9]/', '', $kecemasan->no_telefon);
                    if(!str_starts_with($cleanPhone, '6') && !empty($cleanPhone)) $cleanPhone = '6' . $cleanPhone;
                @endphp

                @if(!empty($cleanPhone))
                    {{-- WhatsApp --}}
                    <a href="https://wa.me/{{ $cleanPhone }}" target="_blank" class="w-9 h-9 rounded-lg bg-green-50 text-green-600 flex items-center justify-center border border-green-100 hover:bg-green-100 transition">
                       <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                    </a>
                @endif

                {{-- Call --}}
                <a href="tel:{{ $kecemasan->no_telefon }}" class="w-9 h-9 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center border border-blue-100 hover:bg-blue-100 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                </a>
            </div>
        </div>
        @empty
        <div class="text-center py-6 text-sm text-gray-400">Tiada kenalan kecemasan didaftarkan.</div>
        @endforelse
    </div>

    {{-- Empty State --}}
    <div id="noResults" class="hidden flex-col items-center justify-center py-10">
        <p class="text-gray-400 text-sm">Tiada maklumat dijumpai.</p>
    </div>

</div>

{{-- SCRIPTS: TAB & SEARCH --}}
<script>
    function switchContactTab(tab) {
        const viewPenyelia = document.getElementById('view-penyelia');
        const viewKecemasan = document.getElementById('view-kecemasan');
        const tabPenyelia = document.getElementById('tab-penyelia');
        const tabKecemasan = document.getElementById('tab-kecemasan');

        const activeClasses = ['bg-white', 'text-[#00205B]', 'shadow-sm', 'font-bold', 'border-gray-100'];
        const inactiveClasses = ['text-gray-500', 'font-medium', 'bg-transparent', 'shadow-none', 'border-transparent'];

        if (tab === 'penyelia') {
            viewPenyelia.classList.remove('hidden');
            viewKecemasan.classList.add('hidden');
            
            tabPenyelia.classList.add(...activeClasses);
            tabPenyelia.classList.remove(...inactiveClasses);
            
            tabKecemasan.classList.remove(...activeClasses);
            tabKecemasan.classList.add(...inactiveClasses);
        } else {
            viewKecemasan.classList.remove('hidden');
            viewPenyelia.classList.add('hidden');

            tabKecemasan.classList.add(...activeClasses);
            tabKecemasan.classList.remove(...inactiveClasses);
            
            tabPenyelia.classList.remove(...activeClasses);
            tabPenyelia.classList.add(...inactiveClasses);
        }
        
        // Reset Search when switching tabs
        document.getElementById('searchInput').value = '';
        filterContacts(); 
    }

    function filterContacts() {
        const input = document.getElementById('searchInput').value.toLowerCase();
        
        // Determine which container is currently visible
        const isPenyelia = !document.getElementById('view-penyelia').classList.contains('hidden');
        const activeContainer = isPenyelia ? document.getElementById('view-penyelia') : document.getElementById('view-kecemasan');
        
        const cards = activeContainer.querySelectorAll('.contact-card');
        let visibleCount = 0;

        cards.forEach(card => {
            const name = card.querySelector('.search-name').innerText.toLowerCase();
            const role = card.querySelector('.search-role').innerText.toLowerCase();
            
            if (name.includes(input) || role.includes(input)) {
                card.style.display = "";
                visibleCount++;
            } else {
                card.style.display = "none";
            }
        });

        const noResults = document.getElementById('noResults');
        if (visibleCount === 0) {
            noResults.classList.remove('hidden');
            noResults.classList.add('flex');
        } else {
            noResults.classList.add('hidden');
            noResults.classList.remove('flex');
        }
    }
</script>

<style>
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(5px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fade-in 0.2s ease-out forwards;
    }
</style>
@endsection
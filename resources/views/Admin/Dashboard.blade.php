@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Admin Dashboard') }}
    </h2>
@endsection

@section('content')
<div class="py-6 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    
    {{-- 1. WELCOME SECTION --}}
    {{-- Desktop: Flex row (Name left, Date right). Mobile: Stacked. --}}
    <div class="mb-6 flex flex-col sm:flex-row sm:items-end sm:justify-between gap-2">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-[#00205B]">Selamat Datang, Tuan.</h1>
            <p class="text-sm text-gray-500 mt-1">Paparan Admin Sistem PDRM EP5</p>
        </div>
        <div class="text-sm font-medium text-blue-800 bg-blue-50 px-3 py-1 rounded-lg self-start sm:self-auto">
            {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
        </div>
    </div>

    {{-- 2. STATS GRID --}}
    {{-- Mobile: 2 Columns. Desktop: 4 Columns. --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between hover:shadow-md transition">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Pegawai</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-1">{{$count_penyelia}}</h3>
                </div>
                <div class="p-2 bg-blue-50 rounded-lg text-blue-900">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
            </div>
            <div class="mt-2 flex items-center text-xs text-green-600">
                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                <span>{{$new_penyelia_today}} penyelia baru hari ini</span>
            </div>
        </div>

        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between hover:shadow-md transition">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Anggota</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $count_anggota }}</h3>
                </div>
                <div class="p-2 bg-indigo-50 rounded-lg text-indigo-900">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
            </div>
            <div class="mt-2 flex items-center text-xs text-green-600">
                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                <span>{{$new_anggota_today}} anggota baru hari ini</span>
            </div>
        </div>

        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between hover:shadow-md transition">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Jenis Penugasan</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $count_penugasan }}</h3>
                </div>
                <div class="p-2 bg-emerald-50 rounded-lg text-emerald-900">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
            </div>
            <div class="mt-2 flex items-center text-xs text-green-600">
                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                <span>{{$new_penugasan_today}} penambahan baru hari ini</span>
            </div>
        </div>

        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between hover:shadow-md transition">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Laporan</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-1">{{$all_logs}}</h3>
                </div>
                <div class="p-2 bg-red-50 rounded-lg text-red-900">
                   <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
            </div>
            <div class="mt-2 flex items-center text-xs text-green-600">
                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                <span>{{$new_logs_today}} tugasan baru hari ini</span>
            </div>
        </div>
    </div>

    {{-- 3. MAIN CONTENT SPLIT --}}
    {{-- Mobile: Single Column. Desktop: Grid with Side-by-Side panels. --}}
    {{-- ... existing content ... --}}

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- LEFT COLUMN: Recent Logs (Existing, slightly adjusted for grid) --}}
        <div class="lg:col-span-2 space-y-4">
            <div class="flex items-center justify-between px-1">
                <h3 class="text-base font-bold text-gray-800">Log Terkini</h3>
                <a href="#" class="text-sm font-semibold text-blue-800 hover:text-blue-600">Lihat Semua</a>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="divide-y divide-gray-100">
                    
                    @forelse($recent_logs as $log)
                    <div class="p-4 flex items-center gap-4 hover:bg-gray-50 transition">
                        {{-- Avatar --}}
                        <div class="w-10 h-10 rounded-full bg-gray-200 flex-shrink-0 overflow-hidden relative">
                            @if($log->user && $log->user->gambar_profile)
                                <img src="{{ asset('storage/' . $log->user->gambar_profile) }}" class="w-full h-full object-cover" alt="Profile">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($log->user->name ?? 'User') }}&background=0D8ABC&color=fff" class="w-full h-full" alt="Avatar">
                            @endif
                            {{-- Online Status Indicator (Optional) --}}
                            <span class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-green-500 border-2 border-white rounded-full"></span>
                        </div>

                        {{-- Content --}}
                        <div class="flex-1 min-w-0">
                            <div class="flex items-baseline gap-2">
                                <p class="text-sm font-bold text-gray-900 truncate">
                                    {{ $log->user->pangkat->pangkat_name ?? '' }} {{ $log->user->name ?? 'Unknown User' }}
                                </p>
                                <span class="text-[10px] text-gray-400 font-medium bg-gray-100 px-1.5 rounded">{{ $log->user->no_badan ?? 'N/A' }}</span>
                            </div>
                            <p class="text-xs text-gray-500 truncate">
                                {{ $log->description ?? $log->type }} 
                                @if($log->status)
                                    - <span class="capitalize font-medium {{ $log->status === 'approved' ? 'text-green-600' : ($log->status === 'rejected' ? 'text-red-600' : 'text-yellow-600') }}">{{ $log->status }}</span>
                                @endif
                            </p>
                        </div>

                        {{-- Time --}}
                        <span class="text-xs font-medium text-gray-400 whitespace-nowrap">
                            {{ $log->created_at->diffForHumans(null, true) }}
                        </span>
                    </div>
                    @empty
                        <div class="p-8 text-center text-gray-400 text-sm">
                            Tiada log aktiviti terkini.
                        </div>
                    @endforelse

                </div>
            </div>
        </div>

        {{-- RIGHT COLUMN: Personnel Overview (New Section) --}}
        <div class="space-y-4">
            <div class="flex items-center justify-between px-1">
                <h3 class="text-base font-bold text-gray-800">Anggota & Penyelia</h3>
                <a href="{{ route('Admin.ListAnggota') }}" class="text-sm font-semibold text-blue-800 hover:text-blue-600">Direktori</a>
            </div>

            {{-- Personnel List / Cards --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden p-4 space-y-4">
                
                @foreach($recent_users as $user) 
                <button onclick="openUserModal({{ json_encode($user) }})" class="w-full text-left group flex items-start gap-3 p-3 rounded-xl border border-transparent hover:border-gray-100 hover:bg-gray-50 transition-all cursor-pointer">
                    {{-- Profile Image --}}
                    <div class="relative">
                        <div class="h-12 w-12 rounded-full overflow-hidden bg-gray-100 flex items-center justify-center">
                            @if($user->gambar_profile)
                                <img src="{{ asset('storage/' . $user->gambar_profile) }}"
                                    alt="{{ $user->name }}"
                                    class="h-full w-full object-cover">
                            @else
                                <span class="text-sm font-bold text-gray-600">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </span>
                            @endif
                        </div>
                        <span class="absolute -bottom-1 -right-1 px-1.5 py-0.5 text-[9px] font-bold uppercase rounded text-white {{ $user->role === 'penyelia' ? 'bg-indigo-500' : 'bg-blue-500' }} border-2 border-white">
                            {{ substr($user->role, 0, 1) }}
                        </span>
                    </div>

                    <div class="flex-1 min-w-0">
                        <h4 class="text-sm font-bold text-gray-900 truncate group-hover:text-blue-700 transition-colors">
                            {{ $user->name }}
                        </h4>
                        
                        <div class=" items-center gap-2 mt-1">
                            <span class="inline-flex items-center gap-1 text-[10px] font-medium text-gray-500 bg-gray-100 px-1.5 py-0.5 rounded">
                                <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                                {{ $user->no_badan }}
                            </span>
                            <span class="inline-flex items-center gap-1 text-[10px] font-medium text-blue-800 bg-blue-200 px-1.5 py-0.5 rounded">
                                <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                                {{ $user->pangkat->pangkat_name ?? '' }}
                            </span>
                            
                        </div>
                    </div>
                    
                    <div class="self-center">
                        <svg class="w-4 h-4 text-gray-300 group-hover:text-blue-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                </button>
                @endforeach

                @if($recent_users->isEmpty())
                    <div class="text-center py-6">
                        <p class="text-xs text-gray-400">Tiada anggota didaftarkan.</p>
                    </div>
                @endif

            </div>
        </div>

    </div>
</div>

{{-- USER DETAIL MODAL --}}
<div id="userModal" style="display: none;" class="fixed inset-0 z-[100] w-screen h-screen overflow-hidden" role="dialog" aria-modal="true">
    <div class="absolute inset-0 flex items-center justify-center p-4">
        {{-- Backdrop --}}
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="closeUserModal()"></div>
        
        {{-- Modal Card --}}
        <div class="relative z-10 w-full max-w-sm bg-white rounded-2xl shadow-2xl overflow-hidden ring-1 ring-black/5 transform transition-all">
            
            {{-- Header (Color changes based on role in JS) --}}
            <div id="modalHeader" class="h-24 bg-blue-900 relative">
                <button onclick="closeUserModal()" class="absolute top-3 right-3 text-white/70 hover:text-white bg-black/20 hover:bg-black/40 rounded-full p-1 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <div class="px-6 pb-6 relative">
                {{-- Profile Image (Floating) --}}
                <div class="absolute -top-12 left-6 p-1 bg-white rounded-2xl shadow-md">
                    <img id="modalImage" src="" class="w-24 h-24 rounded-xl object-cover bg-gray-200">
                </div>

                {{-- Action Buttons (Top Right) --}}
                <div class="flex justify-end pt-3 mb-2 gap-2">
                    {{-- Edit Button (Dynamic Link) --}}
                    <a id="modalEditLink" href="#" class="text-xs font-bold text-blue-700 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition">
                        Edit Profil
                    </a>
                </div>

                {{-- User Info --}}
                <div class="mt-4">
                    <h3 id="modalName" class="text-xl font-bold text-gray-900 leading-tight"></h3>
                    <p id="modalRank" class="text-sm text-gray-500 font-medium"></p>
                </div>

                {{-- Details Grid --}}
                <div class="mt-6 space-y-3">
                    
                    {{-- Badge & Role --}}
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-gray-50 flex items-center justify-center text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">No. Badan</p>
                            <p id="modalBadge" class="text-sm font-semibold text-gray-800"></p>
                        </div>
                    </div>

                    {{-- Phone --}}
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-gray-50 flex items-center justify-center text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Telefon</p>
                            <p id="modalPhone" class="text-sm font-semibold text-gray-800"></p>
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-gray-50 flex items-center justify-center text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Emel Rasmi</p>
                            <p id="modalEmail" class="text-sm font-semibold text-gray-800 truncate"></p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function openUserModal(user) {
        const modal = document.getElementById('userModal');
        const header = document.getElementById('modalHeader');
        
        // 1. Set Image (Handle default vs uploaded)
        const img = document.getElementById('modalImage');
        if (user.gambar_profile) {
            img.src = '/storage/' + user.gambar_profile;
        } else {
            // UI Avatar generator
            img.src = `https://ui-avatars.com/api/?name=${encodeURIComponent(user.name)}&background=0D8ABC&color=fff`;
        }

        // 2. Set Text Content
        // Handle Pangkat safely (it might be nested or null depending on your JSON structure)
        const pangkatName = user.pangkat ? user.pangkat.pangkat_name : ''; 
        document.getElementById('modalName').innerText = user.name;
        document.getElementById('modalRank').innerText = pangkatName;
        document.getElementById('modalBadge').innerText = user.no_badan || '-';
        document.getElementById('modalPhone').innerText = user.no_telefon || '-';
        document.getElementById('modalEmail').innerText = user.email || '-';

        // 3. Set Edit Link (Replace '999' with actual ID)
        // Note: You must ensure this route exists: route('Admin.Anggota.Edit', id)
        // We construct the URL dynamically assuming standard Laravel routing /admin/anggota/{id}/edit
        const editUrl = "{{ route('Admin.EditUser', 'ID_PLACEHOLDER') }}".replace('ID_PLACEHOLDER', user.id);
        document.getElementById('modalEditLink').href = editUrl;

        // 4. Color Logic (Blue for Anggota, Indigo for Penyelia)
        if(user.role === 'penyelia') {
            header.className = "h-24 bg-indigo-900 relative";
        } else {
            header.className = "h-24 bg-[#00205B] relative";
        }

        // 5. Show Modal
        modal.style.display = 'block';
    }

    function closeUserModal() {
        document.getElementById('userModal').style.display = 'none';
    }

    // Close on Escape Key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') closeUserModal();
    });
</script>
@endsection
@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Profil Saya') }}
    </h2>
@endsection

@section('content')
<div class="py-6 px-4 max-w-lg mx-auto pb-24 relative">

    {{-- 1. PROFILE HEADER CARD --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 mb-6 text-center relative overflow-hidden">
        {{-- Background Gradient --}}
        <div class="absolute top-0 left-0 w-full h-24 bg-gradient-to-b from-[#00205B] to-blue-900"></div>
        
        <div class="relative z-10 mt-8">
            {{-- ADDED: 'group' class here to handle hover effects --}}
            <div class="w-24 h-24 bg-white p-1 rounded-full mx-auto shadow-lg relative group">
                
                {{-- Avatar Container --}}
                <div class="w-full h-full bg-gray-200 rounded-full flex items-center justify-center text-gray-500 font-bold text-2xl overflow-hidden relative">
                    {{-- LOGIC UPDATE: Use 'gambar_profile' from DB and asset() helper --}}
                    @if(Auth::user() && Auth::user()->gambar_profile)
                        <img id="profileImagePreview" src="{{ asset('storage/' . Auth::user()->gambar_profile) }}" class="w-full h-full object-cover">
                    @else
                        <span id="profileInitials">{{ substr(Auth::user()->name ?? 'Razak', 0, 2) }}</span>
                    @endif
                </div>

                {{-- === [START] CHANGE PHOTO BUTTON === --}}
                <label for="photoInput" class="absolute inset-0 flex items-center justify-center bg-black/40 rounded-full opacity-0 group-hover:opacity-100 transition cursor-pointer z-20">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </label>

                {{-- Hidden Input Field --}}
                {{-- CRITICAL UPDATE: Added route() to action attribute --}}
                <form id="photoForm" action="{{ route('Penyelia.update_photo', Auth::id()) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    {{-- Name is 'photo' to match Controller validation --}}
                    <input type="file" id="photoInput" name="photo" class="hidden" accept="image/*" onchange="previewImage(this)">
                </form>
                {{-- === [END] CHANGE PHOTO BUTTON === --}}
                
                {{-- Supervisor Badge --}}
                <div class="absolute bottom-0 right-0 bg-yellow-400 border-4 border-white rounded-full p-1.5 text-white shadow-sm pointer-events-none z-10" title="Akaun Penyelia">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                </div>
            </div>
            
            {{-- DISPLAY NAME & RANK --}}
            <h3 class="mt-3 text-xl font-bold text-gray-900">
                {{ $user->name }}
            </h3>
            <p class="text-sm text-gray-500 font-medium">
                {{-- Use optional chaining for Pangkat in case it's null --}}
                {{ $user->pangkat->pangkat_name ?? 'Tiada Pangkat' }} • {{ $user->no_badan ?? '-' }}
            </p>
        </div>
    </div>


    {{-- 3. MAKLUMAT PERIBADI --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-6 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-50 bg-gray-50/50 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                <h4 class="font-bold text-gray-800 text-sm uppercase tracking-wide">Maklumat Peribadi</h4>
            </div>

            <a href="{{ route('Users.EditProfile', $user->id) }}" class="text-blue-600 hover:text-blue-800 hover:bg-blue-50 p-1.5 rounded-lg transition flex items-center gap-1 text-xs font-bold">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                Ubah
            </a>
        </div>
        
        <div class="p-5 space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">No. Kad Pengenalan</label>
                    <p class="text-sm font-semibold text-gray-800">{{ $user->no_ic }}</p>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">No. Telefon</label>
                    <p class="text-sm font-semibold text-gray-800">{{ $user->no_telefon }}</p>
                </div>
            </div>
            
            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">Emel Rasmi</label>
                <p class="text-sm font-semibold text-gray-800">{{ $user->email }}</p>
            </div>

            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">Alamat Tetap</label>
                <p class="text-sm font-semibold text-gray-800 leading-relaxed">
                    {{ $user->alamat ?? 'Alamat belum dikemaskini.' }}
                </p>
            </div>
        </div>
    </div>

    {{-- 4. LOGOUT BUTTON --}}
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="w-full flex items-center justify-center gap-2 p-4 bg-white border border-red-100 rounded-2xl shadow-sm hover:bg-red-50 transition group">
            <svg class="w-5 h-5 text-red-500 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
            <span class="text-red-600 font-bold text-sm">Log Keluar Akaun</span>
        </button>
    </form>
    
    <div class="text-center mt-6 mb-2">
        <p class="text-[10px] text-gray-300">PDRM EP5 System v1.0</p>
    </div>

</div>

{{-- SCRIPT: IMAGE PREVIEW --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            
            // 1. Optional: Visual Feedback (Loading)
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
            
            Toast.fire({
                icon: 'info',
                title: 'Sedang memuat naik gambar...'
            });

            // 2. CRITICAL STEP: Submit the form to the server
            // This sends the file to your 'update_photo' controller
            document.getElementById('photoForm').submit();
        }
    }
</script>
@endsection
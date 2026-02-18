@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Profil Pegawai') }}
    </h2>
@endsection

@section('content')
<div class="py-6 px-4 max-w-lg mx-auto pb-24">

    {{-- 1. PROFILE HEADER CARD (PENYELIA) --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 mb-6 text-center relative overflow-hidden">
        {{-- Background Decoration --}}
        <div class="absolute top-0 left-0 w-full h-24 bg-gradient-to-b from-[#00205B] to-blue-900"></div>
        
        <div class="relative z-10 mt-8">
            <div class="w-24 h-24 bg-white p-1 rounded-full mx-auto shadow-lg relative group">
                
                {{-- Avatar Container --}}
                <div class="w-full h-full bg-gray-200 rounded-full flex items-center justify-center text-gray-500 font-bold text-2xl overflow-hidden relative">
                    @if(Auth::user() && Auth::user()->gambar_profile)
                        <img id="profileImagePreview" src="{{ asset('storage/' . Auth::user()->gambar_profile) }}" class="w-full h-full object-cover">
                    @else
                        <span id="profileInitials">{{ substr(Auth::user()->name ?? 'Razak', 0, 2) }}</span>
                    @endif
                </div>

                {{-- CHANGE PHOTO BUTTON --}}
                <label for="photoInput" class="absolute inset-0 flex items-center justify-center bg-black/40 rounded-full opacity-0 group-hover:opacity-100 transition cursor-pointer z-20">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </label>

                <form id="photoForm" action="{{ route('Penyelia.update_photo', Auth::id()) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" id="photoInput" name="photo" class="hidden" accept="image/*" onchange="previewImage(this)">
                </form>
                
                {{-- Supervisor Badge --}}
                <div class="absolute bottom-0 right-0 bg-yellow-400 border-4 border-white rounded-full p-1.5 text-white shadow-sm pointer-events-none z-10" title="Akaun Penyelia">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                </div>
            </div>
            
            <h3 class="mt-3 text-xl font-bold text-gray-900 flex items-center justify-center gap-2">
                {{ Auth::user()->name ?? 'N/A' }}
            </h3>
            
            <p class="text-sm text-gray-500 font-medium mb-2">
                {{ Auth::user()->pangkat->pangkat_name ?? 'N/A' }} • {{ Auth::user()->no_badan ?? 'N/A' }}
            </p>

            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800 tracking-wide">
                PEGAWAI PENYELIA
            </span>
        </div>
    </div>

    {{-- 2. MAKLUMAT PERIBADI --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-6 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-50 bg-gray-50/50 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                <h4 class="font-bold text-gray-800 text-sm uppercase tracking-wide">Maklumat Peribadi</h4>
            </div>
            <a href="{{ route('Penyelia.EditProfile', $user->id) }}" class="text-blue-600 hover:text-blue-800 hover:bg-blue-50 p-1.5 rounded-lg transition flex items-center gap-1 text-xs font-bold">
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
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">Jawatan Rasmi</label>
                <p class="text-sm font-semibold text-gray-800">{{ $user->pangkat->pangkat_name }}</p>
            </div>
            
            {{-- [UPDATED] EMAIL SECTION WITH WARNING --}}
            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">Emel Rasmi</label>
                @if(!empty($user->email))
                    <p class="text-sm font-semibold text-gray-800">{{ $user->email }}</p>
                @else
                    <div class="mt-1 flex items-start gap-2 text-amber-600 bg-amber-50 px-3 py-2 rounded-lg border border-amber-100">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        <div>
                            <span class="block text-xs font-bold">Tiada Emel Rasmi</span>
                            <span class="block text-[10px] leading-tight mt-0.5 text-amber-700">Sila kemaskini untuk membolehkan fungsi "Lupa Kata Laluan".</span>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- 3. TETAPAN KESELAMATAN --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-6 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-50 bg-gray-50/50 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                <h4 class="font-bold text-gray-800 text-sm uppercase tracking-wide">Tetapan Keselamatan</h4>
            </div>
        </div>
        
        <div class="p-2">
            <button onclick="openPasswordModal()" class="w-full flex items-center justify-between p-3 hover:bg-blue-50 rounded-xl transition group text-left">
                <div>
                    <span class="block text-sm font-bold text-gray-800">Tukar Kata Laluan</span>
                    <span class="block text-[10px] text-gray-400">Kemaskini kata laluan untuk keselamatan akaun.</span>
                </div>
                <div class="bg-gray-100 p-2 rounded-lg group-hover:bg-blue-200 transition">
                    <svg class="w-4 h-4 text-gray-500 group-hover:text-blue-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </div>
            </button>
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
        <p class="text-[10px] text-gray-300">PDRM EP5 System v1.0 (Supervisor Access)</p>
    </div>

</div>

{{-- PASSWORD MODAL --}}
<div id="passwordModal" style="display: none;" class="fixed inset-0 z-[100] w-screen h-screen overflow-hidden" role="dialog" aria-modal="true">
    <div class="absolute inset-0 flex items-center justify-center p-4">
        {{-- Backdrop --}}
        <div class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" onclick="closePasswordModal()"></div>
        
        {{-- Modal Content --}}
        <div class="relative z-10 w-full max-w-md bg-white rounded-xl shadow-2xl overflow-hidden ring-1 ring-black/5 transform transition-all">
            <div class="bg-gray-50 px-4 py-4 border-b border-gray-100 flex items-center gap-3">
                <div class="p-2 bg-blue-100 rounded-lg text-blue-900 shrink-0">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800">Tukar Kata Laluan</h3>
            </div>

            <div class="p-6">
                <form action="{{ route('Users.Profile.UpdatePassword') }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    {{-- Current Password --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kata Laluan Semasa</label>
                        <div class="relative">
                            <input type="password" id="current_password" name="current_password" class="block w-full px-4 py-2.5 pr-10 bg-gray-50 border border-gray-200 rounded-lg focus:ring-blue-900 focus:border-blue-900 text-sm transition-all" required>
                            <button type="button" onclick="togglePassword('current_password')" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-400 hover:text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </button>
                        </div>
                    </div>

                    {{-- New Password --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kata Laluan Baru</label>
                        <div class="relative">
                            <input type="password" id="password" name="password" class="block w-full px-4 py-2.5 pr-10 bg-gray-50 border border-gray-200 rounded-lg focus:ring-blue-900 focus:border-blue-900 text-sm transition-all" required>
                            <button type="button" onclick="togglePassword('password')" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-400 hover:text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </button>
                        </div>
                    </div>

                    {{-- Confirm Password --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Sahkan Kata Laluan Baru</label>
                        <div class="relative">
                            <input type="password" id="password_confirmation" name="password_confirmation" class="block w-full px-4 py-2.5 pr-10 bg-gray-50 border border-gray-200 rounded-lg focus:ring-blue-900 focus:border-blue-900 text-sm transition-all" required>
                            <button type="button" onclick="togglePassword('password_confirmation')" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-400 hover:text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </button>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 pt-4">
                        <button type="button" onclick="closePasswordModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none transition-colors">Batal</button>
                        <button type="submit" class="px-4 py-2 text-sm font-bold text-white bg-[#00205B] rounded-lg hover:bg-blue-900 focus:outline-none shadow-lg shadow-blue-900/20 transition-all transform hover:scale-105">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- SCRIPT & STYLES --}}
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
            document.getElementById('photoForm').submit();
        }
    }

    // 2. MODAL FUNCTIONS (New)
    function openPasswordModal() {
        document.getElementById('passwordModal').style.display = 'block';
    }

    function closePasswordModal() {
        document.getElementById('passwordModal').style.display = 'none';
    }

    // 3. TOGGLE PASSWORD VISIBILITY (New)
    function togglePassword(inputId) {
        const input = document.getElementById(inputId);
        if (input.type === "password") {
            input.type = "text";
        } else {
            input.type = "password";
        }
    }

    // 4. EVENT LISTENERS
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closePasswordModal();
        }
    });

    // 5. ALERT LOGIC
    document.addEventListener('DOMContentLoaded', function() {
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berjaya!',
                text: "{{ session('success') }}",
                confirmButtonColor: '#00205B',
                timer: 3000
            });
        @endif

        @if ($errors->any())
            let errorHtml = '<ul class="text-left text-sm list-disc pl-5">';
            @foreach ($errors->all() as $error)
                errorHtml += '<li>{{ $error }}</li>';
            @endforeach
            errorHtml += '</ul>';

            Swal.fire({
                icon: 'error',
                title: 'Ralat!',
                html: errorHtml,
                confirmButtonColor: '#d33'
            });
            openPasswordModal(); // Re-open if error
        @endif
    });
</script>

<style>
    #toggle:checked + .toggle-bg {
        background-color: #00205B;
        border-color: #00205B;
    }
    #toggle:checked + .toggle-bg + .toggle-circle {
        transform: translateX(100%);
        border-color: white;
    }
</style>
@endsection
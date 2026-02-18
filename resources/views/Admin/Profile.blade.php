@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Profil Admin') }}
    </h2>
@endsection

@section('content')
<div class="py-6 px-4 max-w-4xl mx-auto pb-24 relative">
    
    {{-- 1. ADMIN PROFILE HEADER CARD (UPDATED WITH UPLOAD FEATURE) --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 mb-6 text-center relative overflow-hidden">
        {{-- Background Gradient --}}
        <div class="absolute top-0 left-0 w-full h-24 bg-gradient-to-b from-[#00205B] to-blue-900"></div>
        
        <div class="relative z-10 mt-8">
            <div class="w-24 h-24 bg-white p-1 rounded-full mx-auto shadow-lg relative group">
                <div class="w-full h-full bg-gray-200 rounded-full flex items-center justify-center text-gray-500 font-bold text-2xl overflow-hidden relative">
                    @if(Auth::user() && Auth::user()->gambar_profile)
                        <img id="profileImagePreview" src="{{ asset('storage/' . Auth::user()->gambar_profile) }}" class="w-full h-full object-cover">
                    @else
                        <span id="profileInitials" class="uppercase">{{ substr(Auth::user()->name ?? 'AD', 0, 2) }}</span>
                    @endif
                </div>

                {{-- Hover/Tap Overlay --}}
                <label for="photoInput" class="absolute inset-0 flex items-center justify-center bg-black/40 rounded-full opacity-0 group-hover:opacity-100 transition cursor-pointer z-20">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </label>

                {{-- Hidden Upload Form --}}
                <form id="photoForm" action="{{ route('Admin.update_photo', Auth::id()) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" id="photoInput" name="photo" class="hidden" accept="image/*" onchange="previewImage(this)">
                </form>
                
                {{-- Admin Badge (Bottom Right) --}}
                <div class="absolute bottom-0 right-0 bg-indigo-600 border-4 border-white rounded-full p-1.5 text-white shadow-sm pointer-events-none z-10" title="Super Admin">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                </div>
            </div>
            
            <h3 class="mt-3 text-xl font-bold text-gray-900">{{ Auth::user()->name ?? 'Tuan Admin' }}</h3>
            <p class="text-sm text-gray-500 font-medium">{{ Auth::user()->email ?? 'Administrator' }}</p>
            <div class="mt-4 inline-flex items-center px-3 py-1 rounded-full bg-indigo-50 text-indigo-800 text-xs font-bold uppercase tracking-wider">
                Super Admin
            </div>
        </div>
    </div>

    {{-- 2. MAKLUMAT PERIBADI --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-6 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 bg-gray-50/50 flex items-center justify-between">
            <h3 class="text-sm font-bold text-gray-800">Maklumat Peribadi</h3>
            
            {{-- THE "UBAH" BUTTON (Exactly like Anggota) --}}
            <a href="{{ route('Admin.EditProfile', $user->id) }}" class="text-blue-600 hover:text-blue-800 hover:bg-blue-50 p-1.5 rounded-lg transition flex items-center gap-1 text-xs font-bold">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                Ubah
            </a>
        </div>
        
        <div class="p-5 space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                
                {{-- Nama Penuh --}}
                <div class="sm:col-span-2">
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Nama Penuh</label>
                    <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                </div>

                {{-- No. KP --}}
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">No. Kad Pengenalan</label>
                    <p class="text-sm font-medium text-gray-900">{{ Auth::user()->no_ic ?? 'Tiada Rekod' }}</p>
                </div>

                {{-- No. Badan --}}
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">No. Badan</label>
                    <p class="text-sm font-medium text-gray-900">{{ Auth::user()->no_badan ?? 'Tiada Rekod' }}</p>
                </div>

                {{-- No. Telefon --}}
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">No. Telefon</label>
                    <p class="text-sm font-medium text-gray-900">{{ Auth::user()->no_telefon ?? 'Tiada Rekod' }}</p>
                </div>

                {{-- Pangkat --}}
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Pangkat</label>
                    <p class="text-sm font-medium text-gray-900">{{ Auth::user()->pangkat->pangkat_name ?? 'Super Admin' }}</p>
                </div>

                {{-- Emel Rasmi (Added from Anggota view) --}}
                <div class="sm:col-span-2">
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Emel Rasmi</label>
                    <p class="text-sm font-medium text-gray-900">{{ Auth::user()->email ?? 'Tiada Rekod' }}</p>
                </div>

                {{-- Alamat Tetap (Added from Anggota view) --}}
                <div class="sm:col-span-2">
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Alamat Tetap</label>
                    <p class="text-sm font-medium text-gray-900 leading-relaxed">{{ Auth::user()->alamat ?? 'Alamat belum dikemaskini.' }}</p>
                </div>

            </div>
        </div>
    </div>

    {{-- 3. MENU OPTIONS (Settings & Logout) --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden divide-y divide-gray-100">
        
        <div class="px-5 py-3 border-b border-gray-100 bg-gray-50/50">
            <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider">Tetapan Akaun</h3>
        </div>

        {{-- Tukar Kata Laluan Button --}}
        <button onclick="openPasswordModal()" class="w-full flex items-center justify-between p-4 hover:bg-gray-50 transition">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-gray-100 rounded-lg text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </div>
                <div class="text-left">
                    <span class="block text-sm font-medium text-gray-700">Tukar Kata Laluan</span>
                    <span class="block text-[10px] text-gray-400">Kemaskini kata laluan keselamatan</span>
                </div>
            </div>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        </button>

        {{-- Logout Button --}}
        <form method="POST" action="{{ route('logout') }}" class="w-full">
            @csrf
            <button type="submit" class="w-full flex items-center justify-between p-4 hover:bg-red-50 transition group">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-red-50 rounded-lg text-red-600 group-hover:bg-red-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    </div>
                    <span class="text-sm font-bold text-red-600">Log Keluar</span>
                </div>
            </button>
        </form>
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
                <form action="{{ route('Admin.Profile.UpdatePassword') }}" method="POST" class="space-y-4">
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

{{-- SCRIPT: IMAGE PREVIEW, MODAL LOGIC & ALERTS --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // 1. IMAGE PREVIEW (Added from Anggota)
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const Toast = Swal.mixin({
                toast: true, position: 'top-end', showConfirmButton: false, timer: 3000, timerProgressBar: true
            });
            Toast.fire({ icon: 'info', title: 'Sedang memuat naik gambar...' });
            
            // Instantly submit the form to the backend
            document.getElementById('photoForm').submit();
        }
    }

    // 2. Modal Functions
    function openPasswordModal() {
        document.getElementById('passwordModal').style.display = 'block';
    }

    function closePasswordModal() {
        document.getElementById('passwordModal').style.display = 'none';
    }

    // 3. Toggle Password Visibility
    function togglePassword(inputId) {
        const input = document.getElementById(inputId);
        if (input.type === "password") {
            input.type = "text";
        } else {
            input.type = "password";
        }
    }

    // 4. Close on Escape Key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closePasswordModal();
        }
    });

    // 5. Alert Logic
    document.addEventListener('DOMContentLoaded', function() {
        // Success
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berjaya!',
                text: "{{ session('success') }}",
                confirmButtonColor: '#00205B',
                timer: 3000
            });
        @endif

        // Validation Errors
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
            // Re-open modal if there are errors so user can fix them
            openPasswordModal();
        @endif
    });
</script>
@endsection
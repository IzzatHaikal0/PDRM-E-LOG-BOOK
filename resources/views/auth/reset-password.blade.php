<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tetapkan Semula Kata Laluan - PDRM EP5</title>
    
    {{-- Load Tailwind CSS & JS via Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#132143] font-sans antialiased text-gray-900">
    
    <div class="min-h-screen flex flex-col justify-center items-center pt-6 sm:pt-0 px-4">
        
        {{-- Logo / Branding --}}
        <div class="mb-6 text-center">
            <h2 class="text-3xl font-bold text-white tracking-tight">PDRM EP5</h2>
        </div>

        <div class="w-full sm:max-w-md bg-white p-8 shadow-lg rounded-2xl border border-gray-100">
            
            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold text-[#00205B]">Cipta Kata Laluan Baru</h2>
                <p class="text-sm text-gray-500 mt-2">Sila masukkan kata laluan baru anda di bawah.</p>
            </div>

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                {{-- Hidden Token (Crucial for security) --}}
                <input type="hidden" name="token" value="{{ $token }}">

                {{-- Email (Read-only, pre-filled from the link) --}}
                <div class="mb-4">
                    <label for="email" class="block text-sm font-bold text-gray-700 mb-1">Emel Rasmi</label>
                    <input id="email" type="email" name="email" value="{{ $email ?? old('email') }}" required readonly
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-500 cursor-not-allowed">
                    @error('email') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                {{-- New Password --}}
                <div class="mb-4">
                    <label for="password" class="block text-sm font-bold text-gray-700 mb-1">Kata Laluan Baru</label>
                    <div class="relative">
                        <input id="password" type="password" name="password" required autofocus
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#00205B] focus:border-[#00205B] transition-all pr-10"
                            placeholder="••••••••">
                        
                        {{-- Toggle Button --}}
                        <button type="button" onclick="togglePassword('password')" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-400 hover:text-[#00205B] focus:outline-none">
                            {{-- Eye Icon (Show) --}}
                            <svg id="eye-password" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            {{-- Eye Off Icon (Hide) - Hidden by default --}}
                            <svg id="eye-off-password" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                            </svg>
                        </button>
                    </div>
                    @error('password') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                {{-- Confirm Password --}}
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-1">Sahkan Kata Laluan</label>
                    <div class="relative">
                        <input id="password_confirmation" type="password" name="password_confirmation" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#00205B] focus:border-[#00205B] transition-all pr-10"
                            placeholder="••••••••">
                        
                        {{-- Toggle Button --}}
                        <button type="button" onclick="togglePassword('password_confirmation')" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-400 hover:text-[#00205B] focus:outline-none">
                            {{-- Eye Icon --}}
                            <svg id="eye-password_confirmation" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            {{-- Eye Off Icon --}}
                            <svg id="eye-off-password_confirmation" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                            </svg>
                        </button>
                    </div>
                </div>

                <button type="submit" class="w-full bg-[#00205B] text-white font-bold py-3 px-4 rounded-xl hover:bg-blue-900 transition-all shadow-lg shadow-blue-900/20 active:scale-95">
                    Simpan Kata Laluan Baru
                </button>
            </form>
        </div>
        
        {{-- Footer --}}
        <div class="mt-8 text-center text-xs text-gray-400">
            &copy; {{ date('Y') }} Sistem PDRM EP5. Hak Cipta Terpelihara.
        </div>
    </div>

    {{-- Script for Toggling Password Visibility --}}
    <script>
        function togglePassword(fieldId) {
            const input = document.getElementById(fieldId);
            const eyeIcon = document.getElementById('eye-' + fieldId);
            const eyeOffIcon = document.getElementById('eye-off-' + fieldId);

            if (input.type === 'password') {
                input.type = 'text';
                eyeIcon.classList.add('hidden');
                eyeOffIcon.classList.remove('hidden');
            } else {
                input.type = 'password';
                eyeIcon.classList.remove('hidden');
                eyeOffIcon.classList.add('hidden');
            }
        }
    </script>
</body>
</html>
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
                    <input id="password" type="password" name="password" required autofocus
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#00205B] focus:border-[#00205B] transition-all"
                        placeholder="••••••••">
                    @error('password') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                {{-- Confirm Password --}}
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-1">Sahkan Kata Laluan</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#00205B] focus:border-[#00205B] transition-all"
                        placeholder="••••••••">
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

</body>
</html>
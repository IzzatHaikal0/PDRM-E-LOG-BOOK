<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#00205B">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'PDRM System') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        pdrm: {
                            blue: '#082f6e', // Deep Royal Blue
                            dark: '#02102b', // Night Blue
                            accent: '#fbbf24', // Gold/Yellow accent if needed
                        }
                    },
                    fontFamily: {
                        sans: ['Instrument Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="font-sans antialiased text-gray-900 bg-[#0a101f]">
    
    {{-- @include('layouts.splash-screen') --}}
    
    <div class="min-h-screen flex flex-col justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-[#0f172a] via-[#00205B] to-[#0f172a] relative overflow-hidden">
        
        <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-blue-600 rounded-full mix-blend-screen filter blur-[100px] opacity-30 animate-blob"></div>
        
        <div class="absolute bottom-[-10%] right-[-10%] w-96 h-96 bg-indigo-600 rounded-full mix-blend-screen filter blur-[100px] opacity-30 animate-blob animation-delay-2000"></div>

        <div class="absolute inset-0 opacity-[0.03]" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 30px 30px;"></div>

        <div class="w-3/4 sm:max-w-md px-6 py-8 bg-white/95 backdrop-blur-md shadow-2xl sm:rounded-3xl border border-white/50 relative z-10 m-4 rounded-2xl ring-1 ring-white/20">
            <div class="flex justify-center mb-6">
                <div class="p-3 bg-white rounded-2xl shadow-md border border-slate-100">
                    <img src="{{ asset('storage/Logo/logo_polis.png') }}" alt="PDRM Logo" class="h-24 w-auto drop-shadow-sm">
                </div>
            </div>

            @yield('content')
        </div>

        <div class="mt-8 text-center px-6 relative z-10">
             <p class="text-[10px] text-blue-200/80 font-medium uppercase tracking-wider drop-shadow-md">
                Developed by FAKULTI KOMPUTERAN &bull; UMPSA
            </p>
        </div>
    </div>
</body>
</html>
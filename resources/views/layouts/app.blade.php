<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'PDRM System') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen">
        
        {{-- Desktop Navigation (Hidden on Mobile) --}}
        <div class="hidden sm:block">
            @include('layouts.navigation')
        </div>

        {{-- Mobile Top Header --}}
        @include('layouts.mobile-header')

        {{-- Desktop Page Header --}}
        @isset($header)
            <header class="bg-white shadow hidden sm:block">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        {{-- Main Content --}}
        <main class="pt-20 pb-24 sm:pt-0 sm:pb-0">
            @yield('content')
        </main>

        {{-- Mobile Bottom Navigation --}}
        <div class="sm:hidden">
            @php
                // LOGIC TO CHOOSE NAV FILE
                $showAdminNav = false;

                if (Auth::check() && Auth::user()->role === 'admin') {
                    // 1. If actually logged in as Admin -> Show Admin
                    $showAdminNav = true;
                } elseif (request()->is('admin*') || request()->routeIs('Dashboard.Admin') || request()->routeIs('Admin.*')) {
                    // 2. UI TESTING FALLBACK: If URL has 'admin' -> Show Admin
                    $showAdminNav = true;
                }
            @endphp

            @if($showAdminNav)
                @include('layouts.Adminbottom-nav')
            @else
                @include('layouts.Usersbottom-nav')
            @endif
        </div>
        
    </div>
</body>
</html>
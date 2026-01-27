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

    {{-- @include('layouts.splash-screen') --}}

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
                // Default to User/Anggota navigation
                $navType = 'user'; 

                if (Auth::check()) {
                    // 1. Real Logic: Check Database Role
                    $role = strtolower(Auth::user()->role);
                    
                    if ($role === 'admin') {
                        $navType = 'admin';
                    } elseif ($role === 'penyelia' || $role === 'supervisor') {
                        $navType = 'penyelia';
                    }
                } else {
                    // 2. UI Testing Fallback: Check URL patterns
                    if (request()->is('admin*') || request()->routeIs('Dashboard.Admin') || request()->routeIs('Admin.*')) {
                        $navType = 'admin';
                    } elseif (request()->is('penyelia*') || request()->routeIs('penyelia.*')) {
                        $navType = 'penyelia';
                    }
                }
            @endphp

            @if($navType === 'admin')
                @include('layouts.Adminbottom-nav')
            @elseif($navType === 'penyelia')
                @include('layouts.Penyeliabottom-nav')
            @else
                @include('layouts.Usersbottom-nav')
            @endif
        </div>
        
    </div>
</body>
</html>
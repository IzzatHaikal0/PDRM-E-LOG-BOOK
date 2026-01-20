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
        
        <div class="hidden sm:block">
            @include('layouts.navigation')
        </div>

        @include('layouts.mobile-header')

        @isset($header)
            <header class="bg-white shadow hidden sm:block">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <main class="pt-20 pb-24 sm:pt-0 sm:pb-0">
            @yield('content')
        </main>

        <div class="sm:hidden">
            @include('layouts.bottom-nav')
        </div>
        
    </div>
</body>
</html>
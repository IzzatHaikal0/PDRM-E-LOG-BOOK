@php
    // 1. DEFAULT VALUES (User/Anggota)
    $headerColor = 'bg-[#00205B]'; 
    $roleLabel = 'Sistem Pelaporan'; 

    // 2. LOGIC TO DETECT ROLE
    if (Auth::check()) {
        $role = strtolower(Auth::user()->role);

        if ($role === 'admin') {
            $headerColor = 'bg-gray-900'; // Dark for Admin
            $roleLabel = 'Panel Admin';
            $titleLable = 'PDRM EP5';
        } elseif ($role === 'penyelia' || $role === 'supervisor') {
            $headerColor = 'bg-indigo-900'; // Indigo for Penyelia
            $roleLabel = 'Panel Penyelia';
            $titleLable = 'PDRM EP4';
        }elseif ($role === 'anggota') {
            $headerColor; 
            $roleLabel = 'Panel Anggota';
            $titleLable = 'PDRM EP5';
        }

    } else {
        // 3. UI TESTING FALLBACK (Check URL)
        if (request()->is('admin*') || request()->routeIs('Dashboard.Admin') || request()->routeIs('Admin.*')) {
            $headerColor = 'bg-gray-900';
            $roleLabel = 'Panel Admin';
        } elseif (request()->is('penyelia*')) {
            $headerColor = 'bg-indigo-900';
            $roleLabel = 'Panel Penyelia';
        }
    }
@endphp

<div class="fixed top-0 left-0 w-full h-16 {{ $headerColor }} shadow-md z-40 flex items-center justify-between px-4 sm:hidden transition-colors duration-300">
    
    <div class="flex items-center gap-3">
        {{-- Logo Circle --}}
        <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center p-0.5 shrink-0">
             <img src="{{ asset('storage/Logo/logo_polis.png') }}" class="w-full h-full object-contain">
        </div>

        {{-- Text & Label --}}
        <div class="flex flex-col">
            <span class="text-white font-bold tracking-wider text-sm leading-none">{{ $titleLable }}</span>
            <span class="text-[10px] text-white/80 uppercase tracking-widest leading-none mt-0.5">{{ $roleLabel }}</span>
        </div>
    </div>

    {{-- Optional: Add a Notification Bell or Empty Div to balance 'justify-between' --}}
    <div></div> 

</div>
<nav class="fixed bottom-0 left-0 z-50 w-full h-16 bg-white border-t border-gray-200 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)]">

    @php
        $baseClass = "inline-flex flex-col items-center justify-center px-5 group transition-all duration-200";
        $activeClass = "text-[#00205B]"; 
        $inactiveClass = "text-gray-400 hover:bg-gray-50 hover:text-gray-600";
    @endphp

    {{-- Grid: 5 Columns for User --}}
    <div class="grid h-full max-w-lg grid-cols-5 mx-auto font-medium">
        
        {{-- 1. UTAMA (User Dashboard) --}}
        <a href="{{ route('dashboard') }}" 
           class="{{ $baseClass }} {{ request()->routeIs('dashboard') ? $activeClass : $inactiveClass }}">
            <svg class="w-6 h-6 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span class="text-[10px] uppercase tracking-wide font-semibold">Utama</span>
        </a>

        {{-- 2. HUBUNGI --}}
        <a href="{{ route('contacts') }}" 
           class="{{ $baseClass }} {{ request()->routeIs('contacts') ? $activeClass : $inactiveClass }}">
            <svg class="w-6 h-6 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <span class="text-[10px] uppercase tracking-wide font-semibold">Hubungi</span>
        </a>

        {{-- 3. REKOD (Center Action) --}}
        <a href="{{ route('logs.create') }}" 
           class="{{ $baseClass }} {{ request()->routeIs('logs.create') ? $activeClass : $inactiveClass }}">
            <div class="p-1 bg-[#00205B] rounded-full text-white shadow-lg shadow-blue-900/40 transform transition hover:scale-105 active:scale-95">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
            </div>
            <span class="text-[10px] uppercase tracking-wide mt-1 font-semibold">Rekod</span>
        </a>

        {{-- 4. SEJARAH --}}
        <a href="{{ route('logs.history') }}" 
           class="{{ $baseClass }} {{ request()->routeIs('logs.history') ? $activeClass : $inactiveClass }}">
            <svg class="w-6 h-6 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="text-[10px] uppercase tracking-wide font-semibold">Sejarah</span>
        </a>

        {{-- 5. PROFIL --}}
        <a href="{{ route('profile.show') }}" 
           class="{{ $baseClass }} {{ request()->routeIs('profile.*') ? $activeClass : $inactiveClass }}">
            <svg class="w-6 h-6 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <span class="text-[10px] uppercase tracking-wide font-semibold">Profil</span>
        </a>

    </div>
</nav>
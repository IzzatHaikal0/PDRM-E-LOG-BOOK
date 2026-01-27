<nav class="fixed bottom-0 left-0 z-50 w-full h-16 bg-white border-t border-gray-200 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)]">
    
    @php
        $baseClass = "inline-flex flex-col items-center justify-center px-5 group transition-all duration-200";
        $activeClass = "text-[#00205B]"; 
        $inactiveClass = "text-gray-400 hover:bg-gray-50 hover:text-gray-600";
    @endphp

    {{-- UPDATED: Grid changed to 5 Columns --}}
    <div class="grid h-full max-w-lg grid-cols-5 mx-auto font-medium">
        
        {{-- 1. UTAMA (Dashboard) --}}
        <a href="{{ route('Penyelia.Dashboard') }}" 
           class="{{ $baseClass }} {{ request()->routeIs('Penyelia.Dashboard') ? $activeClass : $inactiveClass }}">
            <svg class="w-6 h-6 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span class="text-[10px] uppercase tracking-wide font-semibold">Utama</span>
        </a>

        {{-- 2. SAHKAN (Verify Task) --}}
        <a href="{{ route('Penyelia.VerifyList') }}" 
           class="{{ $baseClass }} {{ request()->routeIs('Penyelia.VerifyList') ? $activeClass : $inactiveClass }}">
            <svg class="w-6 h-6 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
            </svg>
            <span class="text-[10px] uppercase tracking-wide font-semibold">Sahkan</span>
        </a>

        {{-- 3. REKOD (Add Task - Center Highlight) --}}
        <a href="{{ route('Penyelia.Logs.Create') }}" 
           class="{{ $baseClass }} {{ request()->routeIs('Penyelia.Logs.Create') ? $activeClass : $inactiveClass }}">
            <div class="p-1.5 bg-[#00205B] rounded-xl text-white shadow-lg shadow-blue-900/40 transform transition hover:scale-105 active:scale-95 mb-1">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
            </div>
            <span class="text-[10px] uppercase tracking-wide font-semibold text-[#00205B]">Rekod</span>
        </a>

        {{-- 4. SEJARAH (History Verified) --}}
        {{-- You might want to split this into 'My History' vs 'Verified History' later --}}
        <a href="{{ route('Penyelia.Logs.History') }}" 
           class="{{ $baseClass }} {{ request()->routeIs('Penyelia.Logs.History') ? $activeClass : $inactiveClass }}">
            <svg class="w-6 h-6 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="text-[10px] uppercase tracking-wide font-semibold">Sejarah</span>
        </a>

        {{-- 5. PROFIL --}}
        <a href="{{ route('Penyelia.Profile') }}" 
           class="{{ $baseClass }} {{ request()->routeIs('Penyelia.Profile') ? $activeClass : $inactiveClass }}">
            <svg class="w-6 h-6 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <span class="text-[10px] uppercase tracking-wide font-semibold">Profil</span>
        </a>

    </div>
</nav>
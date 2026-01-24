<nav class="fixed bottom-0 left-0 z-50 w-full h-16 bg-white border-t border-gray-200 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)]">
    
    @php
        $baseClass = "inline-flex flex-col items-center justify-center px-5 group transition-all duration-200";
        $activeClass = "text-[#00205B]"; 
        $inactiveClass = "text-gray-400 hover:bg-gray-50 hover:text-gray-600";
    @endphp

    {{-- Grid: 5 Columns for Admin --}}
    <div class="grid h-full max-w-lg grid-cols-5 mx-auto font-medium">
        
        {{-- 1. UTAMA (Admin Dashboard) --}}
        <a href="{{ route('Admin.Dashboard') }}" 
           class="{{ $baseClass }} {{ request()->routeIs('Admin.Dashboard') ? $activeClass : $inactiveClass }}">
            <svg class="w-6 h-6 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span class="text-[10px] uppercase tracking-wide font-semibold">Utama</span>
        </a>

        {{-- 2. PENGGUNA --}}
        <a href="{{ route('Admin.ListAnggota') }}"
           class="{{ $baseClass }} {{ request()->routeIs('Admin.ListAnggota') ? $activeClass : $inactiveClass }}">
            <svg class="w-6 h-6 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            <span class="text-[10px] uppercase tracking-wide font-semibold">Pengguna</span>
        </a>

        {{-- 3. DAFTAR (Center Action) --}}
        <a href="{{ route('Admin.Registration') }}" 
           class="{{ $baseClass }} {{ request()->routeIs('Admin.Registration') ? $activeClass : $inactiveClass }}">
            <div class="p-1 bg-[#00205B] rounded-full text-white shadow-lg shadow-blue-900/40 transform transition hover:scale-105 active:scale-95">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
            </div>
            <span class="text-[10px] uppercase tracking-wide mt-1 font-semibold">Daftar</span>
        </a>

        {{-- 4. TETAPAN --}}
        {{-- IF ADMIN: Show "Tetapan" --}}
        <a href="{{ route('Admin.Settings') }}" 
            class="nav-item {{ $baseClass }} {{ request()->routeIs('Admin.Settings') ? $activeClass : $inactiveClass }}"
            data-target="settings">
                {{-- Icon --}}
                <svg class="w-6 h-6 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span class="text-[10px] uppercase tracking-wide font-semibold">Tetapan</span>
        </a>

        {{-- 5. PROFIL --}}
        <a href="{{ route('admin.profile') }}" 
           class="{{ $baseClass }} {{ request()->routeIs('admin.profile') ? $activeClass : $inactiveClass }}">
            <svg class="w-6 h-6 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <span class="text-[10px] uppercase tracking-wide font-semibold">Profil</span>
        </a>

    </div>
</nav>
<nav class="fixed bottom-0 left-0 z-50 w-full h-16 bg-white border-t border-gray-200 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)]">
    
    @php 
        // 1. TEST VARIABLE: Change to 'admin', 'officer', or 'staff'
        $role = 'admin'; 

        // 2. DYNAMIC GRID: 5 columns for Admin, 4 for others
        $gridCols = ($role === 'admin') ? 'grid-cols-5' : 'grid-cols-4';

        // 3. STYLING LOGIC
        $baseClass = "inline-flex flex-col items-center justify-center px-5 group transition-all duration-200";
        $activeClass = "text-[#00205B]"; 
        $inactiveClass = "text-gray-400 hover:bg-gray-50 hover:text-gray-600";
    @endphp

    {{-- Apply Dynamic Grid Class Here --}}
    <div class="grid h-full max-w-lg {{ $gridCols }} mx-auto font-medium">
        
        {{-- 1. UTAMA (All Roles) --}}
        <a href="" 
           class="nav-item {{ $baseClass }} {{ request()->routeIs('dashboard') ? $activeClass : $inactiveClass }}"
           data-target="dashboard">
            <svg class="w-6 h-6 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span class="text-[10px] uppercase tracking-wide font-semibold">Utama</span>
        </a>

        {{-- 2. SLOT 2 (Left of Center) --}}
        
        {{-- IF ADMIN: Show "Pengguna" --}}
        @if($role === 'admin')
            <a href="#" 
               class="nav-item {{ $baseClass }} {{ request()->routeIs('users.*') ? $activeClass : $inactiveClass }}"
               data-target="users">
                <svg class="w-6 h-6 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <span class="text-[10px] uppercase tracking-wide font-semibold">Pengguna</span>
            </a>
        @endif

        {{-- IF OFFICER: Show "Log" --}}
        @if(in_array($role, ['officer', 'staff']))
            <a href="#" 
               class="nav-item {{ $baseClass }} {{ request()->routeIs('logs.*') ? $activeClass : $inactiveClass }}"
               data-target="logs">
                <svg class="w-6 h-6 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span class="text-[10px] uppercase tracking-wide font-semibold">Log</span>
            </a>
        @endif

        {{-- 3. SLOT 3 (Center Highlight - DAFTAR) --}}
        @if($role === 'admin')
            <a href="{{ route('Admin.Registration') }}" 
            class="nav-item {{ $baseClass }} {{ request()->routeIs('scan.*') ? $activeClass : $inactiveClass }}"
            data-target="scan">
                <div class="p-1 bg-[#00205B] rounded-full text-white shadow-lg shadow-blue-900/40 transform transition hover:scale-105 active:scale-95">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                </div>
                <span class="text-[10px] uppercase tracking-wide mt-1 font-semibold">Daftar</span>
            </a>
        @endif
        {{-- 4. SLOT 4 (Right of Center) --}}

        {{-- IF ADMIN: Show "Tetapan" --}}
        @if($role === 'admin')
            <a href="#" 
               class="nav-item {{ $baseClass }} {{ request()->routeIs('settings.*') ? $activeClass : $inactiveClass }}"
               data-target="settings">
                {{-- Updated Icon: Cog/Gear for Settings --}}
                <svg class="w-6 h-6 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span class="text-[10px] uppercase tracking-wide font-semibold">Tetapan</span>
            </a>
        @endif

        {{-- 5. SLOT 5 (Far Right - PROFIL) --}}
        <a href="#" 
           class="nav-item {{ $baseClass }} {{ request()->routeIs('profile.*') ? $activeClass : $inactiveClass }}"
           data-target="profile">
            <svg class="w-6 h-6 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <span class="text-[10px] uppercase tracking-wide font-semibold">Profil</span>
        </a>

    </div>
</nav>

{{-- JS for Testing UI --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    const navItems = document.querySelectorAll('.nav-item');
    const activeClass = 'text-[#00205B]';
    navItems.forEach(item => {
        item.addEventListener('click', function(e) {
            if(this.getAttribute('href') === '#') {
                e.preventDefault();
                navItems.forEach(nav => {
                    nav.classList.remove(activeClass);
                    nav.classList.add('text-gray-400', 'hover:bg-gray-50');
                });
                this.classList.remove('text-gray-400', 'hover:bg-gray-50');
                this.classList.add(activeClass);
            }
        });
    });
});
</script>
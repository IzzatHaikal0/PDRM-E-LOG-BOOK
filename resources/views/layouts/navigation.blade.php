<nav x-data="{ open: false }" class="bg-[#00205B] border-b border-blue-900 sticky top-0 z-50 shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            
            {{-- LEFT SIDE: Logo & Links --}}
            <div class="flex">
                <div class="shrink-0 flex items-center gap-3">
                    <a href="#" class="flex items-center gap-2 group">
                        <div class="bg-white p-1 rounded-full transition group-hover:scale-105">
                             {{-- Ensure this path matches your actual logo file --}}
                             <img src="{{ asset('storage/Logo/logo_polis.png') }}" class="block h-9 w-auto" />
                        </div>
                        <div class="flex flex-col">
                            <span class="text-white font-bold tracking-wider text-sm leading-tight">PDRM EP5</span>
                            <span class="text-[10px] text-blue-200 uppercase tracking-widest leading-tight">Sistem Pelaporan</span>
                        </div>
                    </a>
                </div>

                <div class="hidden space-x-1 sm:-my-px sm:ml-10 sm:flex">
                    
                    {{-- TEST VARIABLE (Remove later) --}}
                    @php $role = 'admin'; @endphp

                    {{-- 1. UTAMA (Dashboard) --}}
                    <a href="{{ route('Admin.Dashboard') }}" 
                       class="inline-flex items-center px-4 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out
                       {{ request()->routeIs('dashboard') ? 'border-white text-white' : 'border-transparent text-blue-200 hover:text-white hover:border-blue-300' }}">
                        Utama
                    </a>

                    {{-- 2. PENGGUNA (Admin Only) --}}
                    @if($role === 'admin')
                        <a href="{{ route('Admin.ListAnggota') }}"
                           class="inline-flex items-center px-4 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-blue-200 hover:text-white hover:border-blue-300 transition duration-150 ease-in-out">
                            Pengguna
                        </a>
                        <a href="{{ route('Admin.Settings') }}" 
                           class="inline-flex items-center px-4 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-blue-200 hover:text-white hover:border-blue-300 transition duration-150 ease-in-out">
                            Tetapan
                        </a>
                    @endif

                    {{-- 3. LOG HARIAN (Staff/Officer) --}}
                    @if(in_array($role, ['officer', 'staff']))
                        <a href="#" 
                           class="inline-flex items-center px-4 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-blue-200 hover:text-white hover:border-blue-300 transition duration-150 ease-in-out">
                            Log Harian
                        </a>
                    @endif

                    {{-- 4. ACTION BUTTON (Daftar) --}}
                    <div class="flex items-center ml-2">
                        <a href="{{ route('Admin.Registration') }}" class="px-4 py-1.5 rounded-md bg-blue-800 text-white text-xs font-bold uppercase tracking-wide hover:bg-blue-700 transition shadow-sm ring-1 ring-white/20">
                            + Daftar Baru
                        </a>
                    </div>
                </div>
            </div>

            {{-- RIGHT SIDE: User Dropdown --}}
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <div class="mr-3 text-right hidden lg:block">
                    <div class="text-sm font-bold text-white leading-tight">{{ Auth::user()->name ?? 'Tuan Admin' }}</div>
                    <div class="text-[10px] text-blue-300 uppercase tracking-wider">{{ $role }}</div>
                </div>

                <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                    {{-- Dropdown Trigger --}}
                    <button @click="open = ! open" class="flex items-center text-sm font-medium text-white transition duration-150 ease-in-out focus:outline-none">
                        <div class="h-9 w-9 rounded-full bg-white/10 flex items-center justify-center text-white ring-2 ring-transparent hover:ring-white/50 transition">
                            {{-- User Avatar Icon --}}
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div class="ml-1">
                            <svg class="fill-current h-4 w-4 text-blue-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>

                    {{-- Dropdown Content --}}
                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50" 
                         style="display: none;">
                        
                        <a href="" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            {{ __('Profil Saya') }}
                        </a>

                        <div class="border-t border-gray-100"></div>

                        <form method="POST" action="">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 font-medium">
                                {{ __('Log Keluar') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
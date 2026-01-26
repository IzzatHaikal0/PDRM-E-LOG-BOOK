@extends('layouts.guest')



@section('content')
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-pdrm-blue tracking-tight">PDRM EP5</h2>
        <p class="text-xs font-semibold text-slate-500 uppercase mt-1 tracking-widest">
            {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
        </p>
    </div>

    
@if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <form method="POST" action="{{ route('login.submit') }}" class="space-y-5"> <!--change later to redirect to controller-->
        @csrf

        <div class="relative group">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-pdrm-blue transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <input id="email" 
                   type="text" 
                   name="email" 
                   value="{{ old('email') }}" 
                   required 
                   autofocus 
                   placeholder="Emel"
                   class="block w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-pdrm-blue/20 focus:border-pdrm-blue transition-all duration-200 sm:text-sm shadow-sm" />
        </div>

        <div class="relative group">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-pdrm-blue transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
            <input id="password" 
                   type="password" 
                   name="password" 
                   required 
                   placeholder="Kata Laluan"
                   class="block w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-pdrm-blue/20 focus:border-pdrm-blue transition-all duration-200 sm:text-sm shadow-sm" />
        </div>

        <div class="relative group">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-pdrm-blue transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
            </div>
            <select id="role" 
                    name="role" 
                    class="block w-full pl-11 pr-10 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-gray-700 focus:outline-none focus:bg-white focus:ring-2 focus:ring-pdrm-blue/20 focus:border-pdrm-blue transition-all duration-200 sm:text-sm appearance-none cursor-pointer">
                <option value="" disabled selected>Jawatan</option>
                <option value="admin">Admin</option>
                <option value="penyelia">Penyelia</option>
                <option value="anggota">Anggota</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </div>
        </div>

        <div class="pt-2">
            <button type="submit" 
                    class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-lg shadow-blue-900/30 text-sm font-bold text-white bg-pdrm-blue hover:bg-pdrm-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pdrm-blue transform transition-all duration-200 hover:-translate-y-0.5 active:translate-y-0">
                Log Masuk
            </button>
        </div>
    </form>
@endsection
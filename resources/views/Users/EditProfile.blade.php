@extends('layouts.app')

@section('header')
    <div class="flex items-center gap-2">
        {{-- Back Button --}}
        <a href="{{ route('Users.Profile') }}" class="p-1 -ml-1 text-gray-400 hover:text-gray-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </a>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kemaskini Profil') }}
        </h2>
    </div>
@endsection

@section('content')
<div class="py-6 px-4 max-w-lg mx-auto">

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        
        {{-- FORM ACTION UPDATED --}}
        <form action="{{ route('Users.UpdateProfile', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="p-6 space-y-6">
                
                {{-- Info Alert --}}
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-lg">
                    <div class="flex gap-3">
                        <svg class="w-5 h-5 text-blue-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <p class="text-xs text-blue-800 leading-relaxed">
                            Maklumat sensitif seperti <strong>No. Kad Pengenalan</strong> dan <strong>Nama Penuh</strong> dikunci. Sila hubungi Pegawai Admin jika terdapat kesilapan.
                        </p>
                    </div>
                </div>

                {{-- Read Only Fields (Official Data) --}}
                <div class="grid grid-cols-1 gap-4 bg-gray-50 p-4 rounded-xl border border-gray-100">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Nama Penuh</label>
                        {{-- REAL DATA --}}
                        <p class="text-sm font-bold text-gray-700">{{ $user->name }}</p>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">No. Badan</label>
                            {{-- REAL DATA --}}
                            <p class="text-sm font-bold text-gray-700">{{ $user->no_badan }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">No. KP</label>
                            {{-- REAL DATA --}}
                            <p class="text-sm font-bold text-gray-700">{{ $user->no_ic }}</p>
                        </div>
                    </div>
                    
                    {{-- Jawatan Rasmi (Locked) --}}
                    <div class="pt-2 border-t border-gray-200 mt-2">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Pangkat / Jawatan</label>
                        <div class="flex items-center gap-2">
                            {{-- REAL DATA --}}
                            <span class="text-sm font-bold text-gray-700">
                                {{ $user->pangkat->pangkat_name ?? 'Tiada Pangkat' }}
                            </span>
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                    </div>
                </div>

                {{-- Editable Fields --}}
                <div class="space-y-5">
                    
                    {{-- Phone --}}
                    <div>
                        <label for="no_telefon" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">No. Telefon</label>
                        <div class="relative">
                            {{-- INPUT NAME: no_telefon --}}
                            <input type="text" name="no_telefon" id="no_telefon" value="{{ old('no_telefon', $user->no_telefon) }}" 
                                class="block w-full pl-4 pr-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-blue-900 focus:border-blue-900 text-sm font-medium transition shadow-sm placeholder-gray-300">
                        </div>
                        @error('no_telefon') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Emel Rasmi</label>
                        <div class="relative">
                            {{-- INPUT NAME: email --}}
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" 
                                class="block w-full pl-4 pr-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-blue-900 focus:border-blue-900 text-sm font-medium transition shadow-sm placeholder-gray-300">
                        </div>
                        @error('email') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    {{-- Address --}}
                    <div>
                        <label for="alamat" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Alamat Tetap</label>
                        {{-- INPUT NAME: alamat --}}
                        <textarea name="alamat" id="alamat" rows="4"
                            class="block w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-blue-900 focus:border-blue-900 text-sm font-medium transition shadow-sm placeholder-gray-300 leading-relaxed">{{ old('alamat', $user->alamat) }}</textarea>
                        @error('alamat') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                </div>

            </div>

            {{-- Footer Buttons --}}
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex flex-col gap-3">
                <button type="submit" class="w-full flex justify-center items-center py-3.5 px-4 border border-transparent rounded-xl shadow-lg shadow-blue-900/20 text-sm font-bold text-white bg-[#00205B] hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-900 transition-all active:scale-[0.98]">
                    Simpan Perubahan
                </button>
                
                <a href="{{ route('Users.Profile') }}" class="w-full flex justify-center items-center py-3.5 px-4 border border-gray-200 rounded-xl text-sm font-bold text-gray-600 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200 transition-all active:scale-[0.98]">
                    Batal
                </a>
            </div>

        </form>
    </div>
</div>
@endsection
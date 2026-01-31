@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Kemaskini Anggota') }}
    </h2>
@endsection

@section('content')
<div class="py-6 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto">
    
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-[#00205B]">Kemaskini Profil</h1>
            <p class="text-sm text-gray-500">Mengemaskini maklumat untuk: <span class="font-bold">{{ $user->name }}</span></p>
        </div>
        <a href="{{ route('Admin.ListAnggota') }}" class="text-sm text-gray-600 hover:text-gray-900">&larr; Kembali ke Senarai</a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-indigo-900 px-6 py-4">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-white/10 rounded-lg text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-white">Edit Maklumat</h3>
                    <p class="text-xs text-indigo-200">Sila pastikan maklumat dikemaskini dengan tepat.</p>
                </div>
            </div>
        </div>

        <div class="p-6">
            <form method="POST" action="{{ route('Admin.UpdateUser', $user->id) }}" class="space-y-6">
                @csrf
                {{-- Global Error Check --}}
                @if ($errors->any())
                    <div class="bg-red-50 text-red-700 p-4 rounded-lg text-sm mb-4">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div>
                    <h4 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-blue-600"></span> Maklumat Perkhidmatan
                    </h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        {{-- Role --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Peranan Sistem</label>
                            <select name="role" class="block w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg sm:text-sm">
                                <option value="anggota" {{ old('role', $user->role) == 'anggota' ? 'selected' : '' }}>Anggota</option>
                                <option value="penyelia" {{ old('role', $user->role) == 'penyelia' ? 'selected' : '' }}>Penyelia</option>
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                        </div>

                        {{-- Pangkat --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Pangkat</label>
                            <select name="pangkat_id" class="block w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg sm:text-sm">
                                @foreach($pangkats as $pangkat)
                                    <option value="{{ $pangkat->id }}" {{ old('pangkat_id', $user->pangkat_id) == $pangkat->id ? 'selected' : '' }}>
                                        {{ $pangkat->pangkat_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- No Badan --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nombor Badan</label>
                            <input type="text" name="no_badan" value="{{ old('no_badan', $user->no_badan) }}" class="block w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg sm:text-sm">
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-100 my-2"></div>

                <div>
                    <h4 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-blue-600"></span> Maklumat Peribadi
                    </h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Penuh</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="block w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">No. Kad Pengenalan</label>
                            <input type="text" name="no_ic" value="{{ old('no_ic', $user->no_ic) }}" class="block w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">No. Telefon</label>
                            <input type="text" name="no_telefon" value="{{ old('no_telefon', $user->no_telefon) }}" class="block w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg sm:text-sm">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Emel</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="block w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg sm:text-sm">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Tetap</label>
                            <textarea name="address" rows="3" class="block w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg sm:text-sm">{{ old('address', $user->alamat) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="pt-4 flex items-center justify-end gap-3">
                    <a href="{{ route('Admin.ListAnggota') }}" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">Batal</a>
                    <button type="submit" class="px-5 py-2.5 text-sm font-bold text-white bg-indigo-900 rounded-lg hover:bg-indigo-800 shadow-lg">Kemaskini Maklumat</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Profil Admin') }}
    </h2>
@endsection

@section('content')
<div class="py-6 px-4 max-w-lg mx-auto pb-24">
    
    {{-- Admin Profile Card --}}
    <div class="bg-white rounded-2xl p-6 text-center shadow-sm border border-gray-100 mb-6">
        <div class="w-24 h-24 bg-blue-900 rounded-full mx-auto flex items-center justify-center text-white text-3xl font-bold mb-4 shadow-lg shadow-blue-900/30">
            AD
        </div>
        <h3 class="text-xl font-bold text-gray-900">Tuan Admin</h3>
        <p class="text-sm text-gray-500">Administrator Sistem</p>
        <div class="mt-4 inline-flex items-center px-3 py-1 rounded-full bg-blue-50 text-blue-800 text-xs font-bold uppercase tracking-wider">
            Super Admin
        </div>
    </div>

    {{-- Menu Options --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden divide-y divide-gray-100">
        <button class="w-full flex items-center justify-between p-4 hover:bg-gray-50 transition">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-gray-100 rounded-lg text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </div>
                <span class="text-sm font-medium text-gray-700">Tetapan Akaun</span>
            </div>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        </button>

        {{-- Logout Button --}}

        <form method="POST" action="#" class="w-full">
            @csrf
            <button type="submit" class="w-full flex items-center justify-between p-4 hover:bg-red-50 transition group">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-red-50 rounded-lg text-red-600 group-hover:bg-red-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    </div>
                    <span class="text-sm font-bold text-red-600">Log Keluar</span>
                </div>
            </button>
        </form>
    </div>

</div>
@endsection
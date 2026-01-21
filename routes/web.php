<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function() {
    return view('UserLogin.login');
});

Route::post('/dashboard/admin', function() {
    return view('Dashboard.Admin');
})->name('Dashboard.Admin');

Route::get('/dashboard/admin', function() {
    return view('Dashboard.Admin');
})->name('Dashboard.Admin');

Route::get('/daftar-pengguna', function() {
    return view('Admin.Registration');
})->name('Admin.Registration');

Route::get('/senarai-anggota', function() {
    return view('Admin.ListAnggota');
})->name('Admin.ListAnggota');
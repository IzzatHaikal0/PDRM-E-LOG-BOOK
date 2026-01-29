<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\LogsController;
use App\Http\Controllers\ContactsController;

/*
Route::get('/', function () {
    return view('welcome');
});
*/

// 1. The Login Form Page
Route::get('/', function() {
    return view('UserLogin.login');
})->name('login');

// 2. The Login Logic Controller
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.submit');


Route::get('/rekod/sejarah', [LogsController::class, 'index'])->name('logs.history');

Route::patch('/rekod/tamat/{id}', [LogsController::class, 'updateEndTime'])->name('logs.end_task');




/*
Route::get('/dashboard/admin', function() {
    return view('Dashboard.Admin');
})->name('Dashboard.Admin');

Route::get('/daftar-pengguna', function() {
    return view('Admin.Registration');
})->name('Admin.Registration');

Route::get('/senarai-anggota', function() {
    return view('Admin.ListAnggota');
})->name('Admin.ListAnggota');
*/


/*
|--------------------------------------------------------------------------
| Admin Routes (Prefix: /admin)
|--------------------------------------------------------------------------
*/
//Route::middleware(['auth'])->prefix('admin')->group(function () { // uncomment this line to enable auth middleware
Route::prefix('admin')->group(function () {
    
    Route::get('/dashboard', function() {
        return view('Admin.Dashboard');     // resources/views/Dashboard/Admin.blade.php
    })->name('Admin.Dashboard');

    Route::get('/daftar-pengguna', function() {
        return view('Admin.Registration');
    })->name('Admin.Registration');

    Route::get('/senarai-anggota', function() {
        return view('Admin.ListAnggota');
    })->name('Admin.ListAnggota');
    Route::get('/profil', function() {
        return view('Admin.Profile'); // We will create this file next
    })->name('admin.profile');
    Route::get('/kemaskini-anggota/{id}', function($id) {
        return view('Admin.EditUser');
    })->name('Admin.EditUser');
    Route::get('/tetapan-sistem', function() {
        return view('Admin.Settings');
    })->name('Admin.Settings');
});

/*
|--------------------------------------------------------------------------
| Anggota (User) Routes (Prefix: /anggota)
|--------------------------------------------------------------------------
| 
*/
//Route::middleware(['auth'])->prefix('anggota')->group(function () {   // uncomment this line to enable auth middleware
Route::prefix('anggota')->group(function () {

    // 1. Utama
    Route::get('/dashboard', function() {
        return view('Users.Dashboard');         // resources/views/User/dashboard.blade.php
    })->name('Users.Dashboard');

    // 2. Hubungi (Contacts)
    Route::get('/hubungi', function() {
        return view('Users.Contacts'); 
    })->name('contacts');

    // 3. Rekod (Create Log)
    Route::get('/rekod/baru', function() {
        return view('Users.Logs.Create');
    })->name('logs.create');

    // 4. Sejarah (History)
    Route::get('/rekod/sejarah', function() {
        return view('Users.Logs.History');
    })->name('logs.history');

    // 5. Profil
    Route::get('/profil', function() {
        return view('Users.Profile');
    })->name('profile.show');

    //6.Edit Profile
    Route::get('/profile/ubah', function() {
        return view('Users.EditProfile');
    })->name('Users.EditProfile');

    Route::get('/rekod/sejarah', [LogsController::class, 'index'])->name('logs.history');
    
    Route::get('/hubungi', [ContactsController::class, 'index'])->name('contacts');

    Route::get('/rekod/sejarah/report', function() {
        return view ('Users.Logs.Report');
    })->name('Users.Logs.Report');
    
});


/*
|--------------------------------------------------------------------------
| Penyelia (Supervisor) Routes (Prefix: /penyelia)
|--------------------------------------------------------------------------
*/
Route::prefix('penyelia')->group(function () {

    // 1. Dashboard
    // URL: /penyelia/dashboard
    Route::get('/dashboard', function() {
        return view('Penyelia.Dashboard'); 
    })->name('Penyelia.Dashboard');

    // 2. Sahkan (Verify Task)
    // URL: /penyelia/sahkan-tugasan
    Route::get('/penyelia/sahkan-tugasan', function() {
        return view('Penyelia.VerifyList'); // Matches the file we just created
    })->name('Penyelia.VerifyList');

    // 3. Rekod (Create Log)
    Route::get('/rekod/baru', function() {
        return view('Penyelia.Logs.Create');
    })->name('Penyelia.Logs.Create');

    // 4. Sejarah (History)
    Route::get('/rekod/sejarah', function() {
        return view('Penyelia.Logs.History');
    })->name('Penyelia.Logs.History');

    // 5. Profil
    Route::get('/profil', function() {
        return view('Penyelia.Profile');
    })->name('Penyelia.Profile');

    //6.Edit Profile
    Route::get('/profile/ubah', function() {
        return view('Penyelia.EditProfile');
    })->name('Penyelia.EditProfile');

    Route::get('/rekod/sejarah', [LogsController::class, 'index'])->name('Penyelia.Logs.History');
});


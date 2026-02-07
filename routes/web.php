<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\LogsController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\RegistrationController; 
use App\Http\Controllers\ProfileController;
/*
|--------------------------------------------------------------------------
| 1. Public Routes (Login & Logout)
|--------------------------------------------------------------------------
*/

Route::get('/', function() {
    return view('UserLogin.login');
})->name('login');

Route::post('/login', [LoginController::class, 'authenticate'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::patch('/logs/batch-submit', [App\Http\Controllers\LogsController::class, 'submitBatch'])->name('logs.batch_submit');

/*
|--------------------------------------------------------------------------
| 2. Protected Routes (Require Login & No Back History)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'prevent-back-history'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Admin Routes (Prefix: /admin)
    |--------------------------------------------------------------------------
    */
    Route::prefix('admin')->group(function () {
        
        Route::get('/dashboard', function() {
            return view('Admin.Dashboard');
        })->name('Admin.Dashboard');

        // 1. Show Form
        Route::get('/daftar-pengguna', [RegistrationController::class, 'showForm'])->name('Admin.Registration');
        // 2. Save Data (This was missing)
        Route::post('/daftar-pengguna/simpan', [RegistrationController::class, 'storeManual'])->name('Admin.Registration.Store');


        Route::get('/senarai-anggota', [RegistrationController::class, 'listUsers'])->name('Admin.ListAnggota');

        Route::get('/profil', function() {
            return view('Admin.Profile');
        })->name('admin.profile');

        Route::get('/kemaskini-anggota/{id}', [RegistrationController::class, 'edit'])->name('Admin.EditUser');
        Route::post('/kemaskini-anggota/{id}/simpan', [RegistrationController::class, 'update'])->name('Admin.UpdateUser');

        Route::get('/tetapan-sistem', function() {
            return view('Admin.Settings');
        })->name('Admin.Settings');
    });

    /*
    |--------------------------------------------------------------------------
    | Anggota (User) Routes (Prefix: /anggota)
    |--------------------------------------------------------------------------
    */
    Route::prefix('anggota')->group(function () {

        // 1. Utama
        Route::get('/dashboard', function() {
            return view('Users.Dashboard');
        })->name('Users.Dashboard');

        // 2. Hubungi (Contacts)
        Route::get('/hubungi', [ContactsController::class, 'index'])->name('contacts');

        // 3. Rekod (Create Log)
        Route::get('/rekod/baru', function() {
            return view('Users.Logs.Create');
        })->name('logs.create');

        // 4. Sejarah (History)
        Route::get('/rekod/sejarah', [LogsController::class, 'index'])->name('logs.history');
        Route::get('/rekod/sejarah/report', function() {
            return view ('Users.Logs.Report');
        })->name('Users.Logs.Report');

        // Logic to update end time
        Route::patch('/rekod/tamat/{id}', [LogsController::class, 'updateEndTime'])->name('logs.end_task');

        // 5. Profil
        Route::get('/profil', [ProfileController::class, 'index'])->name('Users.Profile');

        // 6. Edit Profile
        Route::get('/profile/ubah/{id}', [ProfileController::class, 'view_edit_form'])->name('Users.EditProfile');

        Route::put('/profile/ubah/{id}/simpan', [ProfileController::class, 'update_profile'])->name('Users.UpdateProfile');
    });

    /*
    |--------------------------------------------------------------------------
    | Penyelia (Supervisor) Routes (Prefix: /penyelia)
    |--------------------------------------------------------------------------
    */
    Route::prefix('penyelia')->group(function () {

        // 1. Dashboard
        Route::get('/dashboard', function() {
            return view('Penyelia.Dashboard'); 
        })->name('Penyelia.Dashboard');

        // 2. Sahkan (Verify Task)
        Route::get('/sahkan-tugasan', function() {
            return view('Penyelia.VerifyList'); 
        })->name('Penyelia.VerifyList');

        // 3. Rekod (Create Log)
        Route::get('/rekod/baru', function() {
            return view('Penyelia.Logs.Create');
        })->name('Penyelia.Logs.Create');

        // 4. Sejarah (History)
        Route::get('/rekod/sejarah', [LogsController::class, 'index'])->name('Penyelia.Logs.History');
        
        Route::get('/rekod/sejarah/report', function() {
            return view ('Penyelia.Logs.Report');
        })->name('Penyelia.Logs.Report');

        // 5. Profil
        Route::get('/profil', [ProfileController::class, 'index'])->name('Penyelia.Profile');

        // 6. Edit Profile
        Route::get('/profile/ubah', function() {
            return view('Penyelia.EditProfile');
        })->name('Penyelia.EditProfile');
    });

}); // End of Middleware Group
<?php


use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\DB;
//use Illuminate\Support\Facades\Route;

Route::get('/db-test', function () {
    return [
        'host' => config('database.connections.mysql.host'),
        'username' => config('database.connections.mysql.username'),
        'database' => config('database.connections.mysql.database'),
    ];
});

use App\Http\Controllers\PangkatController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\LogsController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\RegistrationController; 
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminSettingController;
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
        
        Route::get('/dashboard', [DashboardController::class, 'getAdminDashboard'])->name('Admin.Dashboard');
        // 1. Show Form
        Route::get('/daftar-pengguna', [RegistrationController::class, 'showForm'])->name('Admin.Registration');
        // 2. Save Data (This was missing)
        Route::post('/daftar-pengguna/simpan', [RegistrationController::class, 'storeManual'])->name('Admin.Registration.Store');
        // NEW BULK ROUTES
        Route::post('/admin/register/bulk', [RegistrationController::class, 'storeBulk'])->name('Admin.Registration.StoreBulk');
        Route::get('/admin/register/template', [RegistrationController::class, 'downloadTemplate'])->name('Admin.Registration.Template');

        Route::get('/senarai-anggota', [RegistrationController::class, 'listUsers'])->name('Admin.ListAnggota');

        Route::get('/profil', function() {return view('Admin.Profile');})->name('admin.profile');
        Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('Admin.Profile.UpdatePassword');

        Route::get('/kemaskini-anggota/{id}', [RegistrationController::class, 'edit'])->name('Admin.EditUser');
        Route::post('/kemaskini-anggota/{id}/simpan', [RegistrationController::class, 'update'])->name('Admin.UpdateUser');
        Route::delete('/padam/{id}', [RegistrationController::class, 'softdelete'])->name('Admin.DeleteUser');

        Route::get('/tetapan-sistem', [AdminSettingController::class, 'getAllSettings'])->name('Admin.Settings');
        
        Route::post('/settings/penugasan', [AdminSettingController::class, 'storePenugasan'])->name('Admin.Settings.StorePenugasan');
        Route::put('/settings/penugasan/{id}', [AdminSettingController::class, 'updatePenugasan'])->name('Admin.Settings.UpdatePenugasan');
        Route::delete('/settings/penugasan/{id}', [AdminSettingController::class, 'deletePenugasan'])->name('Admin.Settings.DeletePenugasan');

        // pangkat
        Route::post('/settings/pangkat', [AdminSettingController::class, 'addNewPangkat'])->name('Admin.Settings.StorePangkat');
        Route::put('/settings/pangkat/{id}', [AdminSettingController::class, 'updatePangkat'])->name('Admin.Settings.UpdatePangkat');
        Route::delete('/settings/pangkat/{id}', [AdminSettingController::class, 'deletePangkat'])->name('Admin.Settings.DeletePangkat');
        Route::post('/admin/settings/pangkat/reorder', [AdminSettingController::class, 'reorderPangkat'])->name('Admin.Settings.ReorderPangkat');

        //kecemasan
        Route::post('/settings/kecemasan',[AdminSettingController::class, 'storeKecemasan'])->name('Admin.Settings.StoreKecemasan');
        Route::post('/settings/kecemasan/{id}',[AdminSettingController::class, 'updateKecemasan'])->name('Admin.Settings.UpdateKecemasan');
        Route::delete('/settings/kecemasan/{id}',[AdminSettingController::class, 'deleteKecemasan'])->name('Admin.Settings.DeleteKecemasan');

    });

    /*
    |--------------------------------------------------------------------------
    | Anggota (User) Routes (Prefix: /anggota)
    |--------------------------------------------------------------------------
    */
    Route::prefix('anggota')->group(function () {

        // Utama
        Route::get('/dashboard', function() {
            return view('Users.Dashboard');
        })->name('Users.Dashboard');

        // Hubungi (Contacts)
        Route::get('/hubungi', [ContactsController::class, 'index'])->name('contacts');

        // Rekod (Create Log)
        Route::post('/rekod/simpan', [LogsController::class, 'store'])->name('logs.store');
        Route::get('/rekod/baru', [LogsController::class, 'create'])->name('logs.create');// Handle form submission

        // Sejarah (History)
        Route::get('/rekod/sejarah', [LogsController::class, 'index'])->name('logs.history');
        Route::get('/rekod/sejarah/report', function() {
            return view ('Users.Logs.Report');
        })->name('Users.Logs.Report');

        // Logic to update end time
        Route::patch('/rekod/tamat/{id}', [LogsController::class, 'updateEndTime'])->name('logs.end_task');

        // Profil
        Route::get('/profil', [ProfileController::class, 'index'])->name('Users.Profile');

        // Edit Profile
        Route::get('/profile/ubah/{id}', [ProfileController::class, 'view_edit_form'])->name('Users.EditProfile');
        Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('Users.Profile.UpdatePassword');

        Route::put('/profile/ubah/{id}/simpan', [ProfileController::class, 'update_profile'])->name('Users.UpdateProfile');

        Route::post('/profile/update-photo/{id}', [ProfileController::class, 'update_photo'])->name('Users.update_photo');

        // EDIT ROUTES
        Route::get('/rekod/ubah/{id}', [LogsController::class, 'edit'])->name('logs.edit');
        Route::put('/rekod/ubah/{id}', [LogsController::class, 'update'])->name('logs.update');
        
        // Route to delete a specific image from an existing log
        Route::delete('/rekod/gambar/{id}', [LogsController::class, 'deleteImage'])->name('logs.delete_image');

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

        // 1. Show Verification List
        Route::get('/sahkan-tugasan', [LogsController::class, 'verifyList'])->name('Penyelia.VerifyList');

        // 2. Process Verification (Single or Batch)
        Route::post('/sahkan-tugasan/simpan', [LogsController::class, 'verifyStore'])->name('Penyelia.VerifyStore');

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

        Route::post('/profile/update-photo/{id}', [ProfileController::class, 'update_photo'])->name('Penyelia.update_photo');
    });

}); 
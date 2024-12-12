<?php


use App\Http\Controllers\DokterController;
use App\Http\Controllers\PasienController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.home');
})->name('home');

Route::get('/pasien/login', [PasienController::class, 'loginForm'])->name('pasien.loginForm');
Route::post('/pasien/login', [PasienController::class, 'loginPasien'])->name('pasien.login');
Route::get('pasien/register', [PasienController::class, 'registerForm'])->name('pasien.registerForm');
Route::post('pasien/register', [PasienController::class, 'store'])->name('pasien.register.store');

Route::get('/dokter/login', [DokterController::class, 'loginForm'])->name('dokter.loginForm');
Route::post('/dokter/login', [DokterController::class, 'loginDokter'])->name('dokter.login');

// Route untuk admin (hanya bisa diakses oleh admin)
// Route::middleware('admin')->group(function () {
//     Route::get('/admin/dashboard', [DokterController::class, 'index'])->name('admin.dashboard');
//     // Tambahkan route lainnya untuk admin
// });

// Route untuk pasien (hanya bisa diakses oleh pasien)
Route::middleware('admin')->group(function () {
    Route::get('/admin/dashboard', [DokterController::class, 'dashboardAdmin'])->name('admin.dashboard');
});

Route::middleware('dokter')->group(function () {
    Route::get('/dokter/dashboard', [DokterController::class, 'dashboard'])->name('dokter.dashboard');
    Route::get('/dokter/poli', [DokterController::class, 'poli'])->name('dokter.poli');
});

Route::middleware('pasien')->group(function () {
    Route::get('/pasien/dashboard', [PasienController::class, 'dashboard'])->name('pasien.dashboard');
    Route::get('/pasien/daftar-periksa', [PasienController::class, 'daftarPeriksa'])->name('pasien.daftar.periksa');
});

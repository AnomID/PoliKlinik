<?php

use App\Http\Controllers\Authentification\AuthController;
use App\Http\Controllers\Authentification\DokterController;
use App\Http\Controllers\Authentification\PasienController;
use App\Http\Controllers\Admin\DokterController as AdminDokterController;
use App\Http\Controllers\Admin\PasienController as AdminPasienController;
use App\Http\Controllers\Admin\PoliController as AdminPoliController;
use App\Http\Controllers\Admin\ObatController as AdminObatController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Dokter\JadwalPeriksaController;
// use App\Http\Controllers\PasienController as ControllersPasienController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', function () {
    return view('pages.home');
})->name('home');

// Pasien Authentication Routes
Route::prefix('pasien')->name('pasien.')->group(function () {
    Route::get('/login', [PasienController::class, 'loginForm'])->name('loginForm');
    Route::post('/login', [PasienController::class, 'loginPasien'])->name('login');
    Route::get('/register', [PasienController::class, 'registerForm'])->name('registerForm');
    Route::post('/register', [PasienController::class, 'store'])->name('register.store');
});

// Dokter Authentication Routes
Route::prefix('dokter')->name('dokter.')->group(function () {
    Route::get('/login', [DokterController::class, 'loginForm'])->name('loginForm');
    Route::post('/login', [DokterController::class, 'loginDokter'])->name('login');
});

// Admin Routes (Protected by 'admin' middleware)
Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'dashboard-admin'])->name('dashboard');
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    // CRUD Routes untuk Dokter
    Route::resource('dokter', AdminDokterController::class);

    // CRUD Routes untuk Pasien
    Route::resource('pasien', AdminPasienController::class);

    // CRUD Routes untuk Poli
    Route::resource('poli', AdminPoliController::class);

    // CRUD Routes untuk Obat
    Route::resource('obat', AdminObatController::class);


});

// Dokter Routes (Protected by 'dokter' middleware)
Route::middleware('dokter')->prefix('dokter')->name('dokter.')->group(function () {
    Route::get('/dashboard', [DokterController::class, 'dashboard'])->name('dashboard');
    Route::get('/poli', [DokterController::class, 'poli'])->name('poli');
    Route::get('/jadwal', [JadwalPeriksaController::class, 'index'])->name('jadwal.index');
    Route::get('/jadwal/create', [JadwalPeriksaController::class, 'create'])->name('jadwal.create');
    Route::post('/jadwal', [JadwalPeriksaController::class, 'store'])->name('jadwal.store');
    Route::get('/jadwal/{jadwalPeriksa}/edit', [JadwalPeriksaController::class, 'edit'])->name('jadwal.edit');
    Route::put('/jadwal/{jadwalPeriksa}', [JadwalPeriksaController::class, 'update'])->name('jadwal.update');
    Route::delete('/jadwal/{jadwalPeriksa}', [JadwalPeriksaController::class, 'destroy'])->name('jadwal.destroy');
});

// Pasien Routes (Protected by 'pasien' middleware)
Route::middleware('pasien')->prefix('pasien')->name('pasien.')->group(function () {
    Route::get('/dashboard', [PasienController::class, 'dashboard'])->name('dashboard');
    Route::get('/daftar-periksa', [PasienController::class, 'daftarPeriksa'])->name('daftar.periksa');

});

// Logout Routes
Route::prefix('logout')->name('logout.')->group(function () {
    Route::get('/admin', [AuthController::class, 'logoutAdmin'])->name('admin');
    Route::get('/dokter', [AuthController::class, 'logoutDokter'])->name('dokter');
    Route::get('/pasien', [AuthController::class, 'logoutPasien'])->name('pasien');
});

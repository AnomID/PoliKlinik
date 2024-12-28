<?php

use App\Http\Controllers\Authentification\AuthController;
use App\Http\Controllers\Authentification\DokterController;
use App\Http\Controllers\Authentification\PasienController;
use App\Http\Controllers\Admin\DokterController as AdminDokterController;
use App\Http\Controllers\Admin\PasienController as AdminPasienController;
use App\Http\Controllers\Admin\PoliController as AdminPoliController;
use App\Http\Controllers\Admin\ObatController as AdminObatController;
use App\Http\Controllers\Admin\RiwayatController as AdminRiwayatController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Dokter\JadwalPeriksaController;
use App\Http\Controllers\Dokter\PeriksaPasienController;
use App\Http\Controllers\Dokter\RiwayatController;
use App\Http\Controllers\Dokter\ProfileController;
use App\Http\Controllers\Pasien\DaftarPoliController;
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
    Route::get('/riwayat', [AdminRiwayatController::class, 'index'])->name('riwayat.index');
    Route::get('/riwayat/{id}', [AdminRiwayatController::class, 'detail'])->name('riwayat.detail');
    // CRUD Routes untuk Poli
    Route::resource('poli', AdminPoliController::class);

    // CRUD Routes untuk Obat
    Route::resource('obat', AdminObatController::class);


});

// Dokter Routes (Protected by 'dokter' middleware)
Route::middleware('dokter')->prefix('dokter')->name('dokter.')->group(function () {
    Route::get('/dashboard', [DokterController::class, 'dashboard'])->name('dashboard');
    Route::get('/poli', [DokterController::class, 'poli'])->name('poli');

    // Jadwal
    Route::resource('jadwal', JadwalPeriksaController::class);
    Route::post('/jadwal{id}', [JadwalPeriksaController::class, 'restore'])->name('jadwal.restore');
    // Route::post('/jadwal', [JadwalPeriksaController::class, 'store'])->name('jadwal.store');

    // Periksa
    Route::get('periksa', [PeriksaPasienController::class, 'index'])->name('periksa.index');
    Route::get('/periksa', [PeriksaPasienController::class, 'index'])->name('periksa.index');
    Route::get('/periksa/create/{id}', [PeriksaPasienController::class, 'create'])->name('periksa.create');
    Route::post('/periksa', [PeriksaPasienController::class, 'store'])->name('periksa.store');

    // Riwayat
    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat.index');
    Route::get('/riwayat/{id}', [RiwayatController::class, 'detail'])->name('riwayat.detail');

    // Profile
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');


});

// Pasien Routes (Protected by 'pasien' middleware)
Route::middleware('pasien')->prefix('pasien')->name('pasien.')->group(function () {
    Route::get('/dashboard', [PasienController::class, 'dashboard'])->name('dashboard');
    Route::get('/daftar-periksa', [PasienController::class, 'daftarPeriksa'])->name('daftar.periksa');
    Route::resource('daftar', DaftarPoliController::class);
    Route::get('daftar/get-jadwal/{poli_id}', [DaftarPoliController::class, 'getJadwalPeriksa'])->name('daftar.get-jadwal');

});
// Logout Routes
Route::prefix('logout')->name('logout.')->group(function () {
    Route::get('/admin', [AuthController::class, 'logoutAdmin'])->name('admin');
    Route::get('/dokter', [AuthController::class, 'logoutDokter'])->name('dokter');
    Route::get('/pasien', [AuthController::class, 'logoutPasien'])->name('pasien');
});
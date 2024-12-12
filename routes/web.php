<?php

use App\Http\Controllers\DokterController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\AuthController;
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
    Route::get('/dashboard', [DokterController::class, 'dashboardAdmin'])->name('dashboard');
    // Add other admin-specific routes here
});

// Dokter Routes (Protected by 'dokter' middleware)
Route::middleware('dokter')->prefix('dokter')->name('dokter.')->group(function () {
    Route::get('/dashboard', [DokterController::class, 'dashboard'])->name('dashboard');
    Route::get('/poli', [DokterController::class, 'poli'])->name('poli');
    // Add other dokter-specific routes here
});

// Pasien Routes (Protected by 'pasien' middleware)
Route::middleware('pasien')->prefix('pasien')->name('pasien.')->group(function () {
    Route::get('/dashboard', [PasienController::class, 'dashboard'])->name('dashboard');
    Route::get('/daftar-periksa', [PasienController::class, 'daftarPeriksa'])->name('daftar.periksa');
    // Add other pasien-specific routes here
});


// Logout Routes
Route::prefix('logout')->name('logout.')->group(function () {
    Route::get('/admin', [AuthController::class, 'logoutAdmin'])->name('admin');
    Route::get('/dokter', [AuthController::class, 'logoutDokter'])->name('dokter');
    Route::get('/pasien', [AuthController::class, 'logoutPasien'])->name('pasien');
});

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\UserController;

// Controller Admin
use App\Http\Controllers\Admin\PenggunaController;

// Controller Pemilik
use App\Http\Controllers\Pemilik\DashboardController as PemilikDashboardController;
use App\Http\Controllers\Pemilik\AnalisisController;
use App\Http\Controllers\Pemilik\BlokController;
use App\Http\Controllers\Pemilik\KebunController;
use App\Http\Controllers\Pemilik\LaporanController as PemilikLaporanController;
use App\Http\Controllers\Pemilik\MonitoringController;

// Controller Pekerja
use App\Http\Controllers\Pekerja\DashboardController as PekerjaDashboardController;
use App\Http\Controllers\Pekerja\HasilPanenController;
use App\Http\Controllers\Pekerja\LaporanController as PekerjaLaporanController;


// ==========================================
// ROUTE PUBLIK
// ==========================================

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [HomeController::class, 'index']);

Route::post('/question/store', [QuestionController::class, 'store'])
    ->name('question.store');

// ==========================================
// ROUTE LOGIN & REGISTER
// ==========================================

Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

// ==========================================
// ROUTE LOGOUT
// ==========================================

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

// ==========================================
// ROUTE PENGGUNA YANG SUDAH LOGIN (UMUM)
// ==========================================

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('pelanggan', PelangganController::class);
    Route::resource('user', UserController::class);
});

// ==========================================
// ROUTE KHUSUS ADMIN
// ==========================================

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/pengguna', [PenggunaController::class, 'index'])->name('pengguna.index');
    });

// ==========================================
// ROUTE KHUSUS PEMILIK KEBUN
// ==========================================

Route::middleware(['auth', 'role:pemilik'])->prefix('pemilik')->name('pemilik.')->group(function () {
    Route::get('/dashboard', [PemilikDashboardController::class, 'index'])->name('dashboard');
    Route::resource('kebun', KebunController::class)->except('show');
    Route::resource('blok', BlokController::class)->except('show');
    Route::get('/monitoring', [MonitoringController::class, 'index'])->name('monitoring');
    Route::get('/analisis', [AnalisisController::class, 'index'])->name('analisis');
    Route::get('/laporan', [PemilikLaporanController::class, 'index'])->name('laporan');
});

// ==========================================
// ROUTE KHUSUS PEKERJA PENCATAT PANEN
// ==========================================
Route::middleware(['auth', 'role:pekerja'])->prefix('pekerja')->name('pekerja.')->group(function () {
    // Menu Dashboard
    Route::get('/dashboard', [PekerjaDashboardController::class, 'index'])->name('dashboard');
    
    // Menu Input & Riwayat (Hasil Panen)
    Route::get('/hasil-panen/create', [HasilPanenController::class, 'create'])->name('hasil-panen.create');
    Route::post('/hasil-panen', [HasilPanenController::class, 'store'])->name('hasil-panen.store');
    Route::get('/hasil-panen', [HasilPanenController::class, 'index'])->name('hasil-panen.index');
    Route::get('/hasil-panen/{id}/edit', [HasilPanenController::class, 'edit'])->name('hasil-panen.edit');
    Route::put('/hasil-panen/{id}', [HasilPanenController::class, 'update'])->name('hasil-panen.update');
    
    // Menu Laporan
    Route::get('/laporan', [PekerjaLaporanController::class, 'index'])->name('laporan');
});
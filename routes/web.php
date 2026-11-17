
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\PenggunaController;

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
// ROUTE LOGIN
// ==========================================

Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.post');
});

// ==========================================
// ROUTE LOGOUT
// ==========================================

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

// ==========================================
// ROUTE PENGGUNA YANG SUDAH LOGIN
// ==========================================

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

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

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/pengguna', [PenggunaController::class, 'index'])
            ->name('pengguna.index');
    });

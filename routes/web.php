<<<<<<< HEAD

<?php

use Illuminate\Support\Facades\Route;
=======
<?php

>>>>>>> 40b295726de6f8408e5b6b58da237cb0ee82619c
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\UserController;
<<<<<<< HEAD
use App\Http\Controllers\Admin\PenggunaController;

// ==========================================
// ROUTE PUBLIK
// ==========================================

=======
use Illuminate\Support\Facades\Route;

// Route Publik (Bisa diakses tanpa login)
>>>>>>> 40b295726de6f8408e5b6b58da237cb0ee82619c
Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [HomeController::class, 'index']);

<<<<<<< HEAD
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

=======
Route::post('question/store', [QuestionController::class, 'store'])
    ->name('question.store');

// Route Guest (Hanya untuk yang belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

// Route Logout
>>>>>>> 40b295726de6f8408e5b6b58da237cb0ee82619c
Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

<<<<<<< HEAD
// ==========================================
// ROUTE PENGGUNA YANG SUDAH LOGIN
// ==========================================

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
=======
// Route Halaman Admin (Wajib Login)
Route::middleware('auth')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])
>>>>>>> 40b295726de6f8408e5b6b58da237cb0ee82619c
        ->name('dashboard');

    Route::resource('pelanggan', PelangganController::class);

    Route::resource('user', UserController::class);
});
<<<<<<< HEAD

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
=======
>>>>>>> 40b295726de6f8408e5b6b58da237cb0ee82619c

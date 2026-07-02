<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProyekController;
use App\Http\Controllers\Admin\PlottingController;
use App\Http\Controllers\Admin\GajiController;
use App\Http\Controllers\Mandor\DashboardController as MandorDashboardController;
use App\Http\Controllers\Mandor\AbsensiController;
use App\Http\Controllers\Tukang\DashboardController as TukangDashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Root Route
|--------------------------------------------------------------------------
| Arahkan ke dashboard sesuai role jika sudah login,
| atau ke halaman login jika belum.
*/

Route::get('/', function () {
    if (auth()->check()) {
        return match (auth()->user()->role) {
            'admin'  => redirect()->route('admin.dashboard'),
            'mandor' => redirect()->route('mandor.dashboard'),
            'tukang' => redirect()->route('tukang.dashboard'),
            default  => redirect()->route('login'),
        };
    }

    return redirect()->route('login');
})->name('home');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| ADMIN Routes
|--------------------------------------------------------------------------
| Prefix   : /admin/...
| Name     : admin....
| Middleware: harus login DAN role = admin
*/
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Rekap Absensi (Admin - read only)
        Route::get('absensis', [\App\Http\Controllers\Admin\AbsensiController::class, 'index'])
            ->name('absensis.index');

        // Kelola Akun (Mandor & Tukang)
        Route::resource('users', UserController::class)->except(['show']);

        // Kelola Proyek
        Route::resource('proyeks', ProyekController::class);

        // Plotting Tukang ke Proyek (+ tarif harian)
        Route::resource('plottings', PlottingController::class)->except(['show']);

        // Rekap & Manajemen Gaji
        Route::get('gajis', [GajiController::class, 'index'])->name('gajis.index');
        Route::post('gajis/generate', [GajiController::class, 'generate'])->name('gajis.generate');
        Route::get('gajis/{gaji}', [GajiController::class, 'show'])->name('gajis.show');
        Route::patch('gajis/{gaji}/bayar', [GajiController::class, 'tandaiDibayar'])->name('gajis.bayar');
    });

/*
|--------------------------------------------------------------------------
| MANDOR Routes
|--------------------------------------------------------------------------
| Prefix   : /mandor/...
| Name     : mandor....
| Middleware: harus login DAN role = mandor
*/
Route::middleware(['auth', 'role:mandor'])
    ->prefix('mandor')
    ->name('mandor.')
    ->group(function () {

        Route::get('/dashboard', [MandorDashboardController::class, 'index'])->name('dashboard');

        // Input & Riwayat Absensi
        Route::get('absensi', [AbsensiController::class, 'index'])->name('absensi.index');
        Route::get('absensi/create', [AbsensiController::class, 'create'])->name('absensi.create');
        Route::post('absensi', [AbsensiController::class, 'store'])->name('absensi.store');
    });

/*
|--------------------------------------------------------------------------
| TUKANG Routes
|--------------------------------------------------------------------------
| Prefix   : /tukang/...
| Name     : tukang....
| Middleware: harus login DAN role = tukang
*/
Route::middleware(['auth', 'role:tukang'])
    ->prefix('tukang')
    ->name('tukang.')
    ->group(function () {

        Route::get('/dashboard', [TukangDashboardController::class, 'index'])->name('dashboard');

        // Riwayat absensi pribadi
        Route::get('absensi', [TukangDashboardController::class, 'absensi'])->name('absensi');

        // Riwayat & detail gaji pribadi
        Route::get('gaji', [TukangDashboardController::class, 'gaji'])->name('gaji');
        Route::get('gaji/{gaji}', [TukangDashboardController::class, 'gajiDetail'])->name('gaji.detail');
    });

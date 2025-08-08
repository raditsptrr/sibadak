<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MapController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Admin\KabupatenKotaController;
use App\Http\Controllers\Admin\DemographicController;
use App\Http\Controllers\Admin\EconomicController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\StatisticController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Auth\AdminLoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Rute Publik (dapat diakses oleh siapa pun)
Route::get('/', [MapController::class, 'index'])->name('map.index');
Route::get('/report/{type}/{indicator}', [ReportController::class, 'show'])->name('report.show');

// Rute untuk Halaman Login Admin (tidak perlu middleware admin)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminLoginController::class, 'login'])->name('login.post');
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');
});

// Rute Group untuk Halaman Admin (dilindungi oleh middleware)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Rute utama dashboard admin
    Route::get('/', [AdminController::class, 'index'])->name('index');
    
    // Rute untuk mengelola data statistik (CRUD)
    Route::get('/statistics', [StatisticController::class, 'index'])->name('statistics.index');
    Route::get('/statistics/create', [StatisticController::class, 'create'])->name('statistics.create');
    Route::post('/statistics', [StatisticController::class, 'store'])->name('statistics.store');
    Route::get('/statistics/{statistic}/edit', [StatisticController::class, 'edit'])->name('statistics.edit');
    Route::put('/statistics/{statistic}', [StatisticController::class, 'update'])->name('statistics.update');
    Route::delete('/statistics/{statistic}', [StatisticController::class, 'destroy'])->name('statistics.destroy');
    
    // Rute untuk form input data
    Route::get('/forms/kabupaten-kota', [KabupatenKotaController::class, 'showForm'])->name('forms.kabupaten_kota');
    Route::post('/forms/kabupaten-kota', [KabupatenKotaController::class, 'store'])->name('forms.kabupaten_kota.store');
    Route::get('/forms/demographic', [DemographicController::class, 'showForm'])->name('forms.demographic');
    Route::post('/forms/demographic', [DemographicController::class, 'store'])->name('forms.demographic.store');
    Route::get('/forms/economic', [EconomicController::class, 'showForm'])->name('forms.economic');
    Route::post('/forms/economic', [EconomicController::class, 'store'])->name('forms.economic.store');
    Route::get('/forms/user', [UserController::class, 'showForm'])->name('forms.user');
    Route::post('/forms/user', [UserController::class, 'store'])->name('forms.user.store');
});

require __DIR__.'/auth.php';

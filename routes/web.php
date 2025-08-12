<?php

use Illuminate\Support\Facades\Route;
// Import Controller Baru & yang Relevan
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DashboardApiController;
use App\Http\Controllers\Admin\MainCategoryController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\IndicatorController;
use App\Http\Controllers\Admin\StatisticValueController;
use App\Http\Controllers\Admin\DataApiController as AdminDataApiController;
use App\Http\Controllers\Admin\Auth\AdminLoginController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\KabupatenKotaController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| File ini mendefinisikan semua route yang dapat diakses melalui browser.
|
*/

// Rute Halaman Utama (Publik)
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Route Baru untuk Halaman Laporan Detail
Route::get('/report/sub-category/{subCategory}', [ReportController::class, 'show'])->name('report.show');

// Route API Internal (diletakkan di web.php agar mendapat session, dll)
Route::prefix('api')->name('api.')->group(function () {
    Route::get('/dashboard-data', [DashboardApiController::class, 'getData'])->name('dashboard.data');
    Route::get('/report-data', [ReportController::class, 'getReportData'])->name('report.data');
});

// Rute untuk user profile (bawaan Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// === GRUP ROUTE ADMIN ===
Route::prefix('admin')->name('admin.')->group(function () {
    
    // Rute Login & Logout Admin (Publik)
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminLoginController::class, 'login'])->name('login.post');
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');

    // Rute yang Dilindungi Middleware Admin
    Route::middleware(['auth', 'admin'])->group(function () {
        
        // Arahkan dashboard admin ke halaman kelola statistik
        Route::get('/', [StatisticValueController::class, 'index'])->name('dashboard');

        // Resourceful Route untuk semua menu Kelola Data
        Route::resource('main-categories', MainCategoryController::class);
        Route::resource('sub-categories', SubCategoryController::class);
        Route::resource('indicators', IndicatorController::class);
        Route::resource('statistics', StatisticValueController::class)->parameters(['statistics' => 'statisticValue']);
        Route::resource('kabupaten-kota', KabupatenKotaController::class)->except(['show']);
        Route::resource('users', UserController::class)->except(['show']);
        
        // Rute untuk API dinamis di form admin
        Route::get('/api/sub-categories', [AdminDataApiController::class, 'getSubCategories'])->name('api.sub_categories');
        Route::get('/api/indicators', [AdminDataApiController::class, 'getIndicators'])->name('api.indicators');
    });
});

// Memuat rute otentikasi bawaan Breeze
require __DIR__.'/auth.php';

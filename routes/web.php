<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MapController;
use App\Http\Controllers\Admin\StatisticController as AdminStatisticController;
use App\Http\Controllers\ReportController; // Import ReportController

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

// Rute utama untuk menampilkan peta
Route::get('/', [MapController::class, 'index']);

// Rute Dashboard (dari Laravel Breeze)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rute Group untuk Admin
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/statistics', [AdminStatisticController::class, 'index'])->name('statistics.index');
    Route::get('/statistics/create', [AdminStatisticController::class, 'create'])->name('statistics.create');
    Route::post('/statistics', [AdminStatisticController::class, 'store'])->name('statistics.store');
    Route::get('/statistics/{statistic}/edit', [AdminStatisticController::class, 'edit'])->name('statistics.edit');
    Route::put('/statistics/{statistic}', [AdminStatisticController::class, 'update'])->name('statistics.update');
    Route::delete('/statistics/{statistic}', [AdminStatisticController::class, 'destroy'])->name('statistics.destroy');
});

// Rute untuk Laporan Statistik (Demografi dan Ekonomi)
// Menggunakan satu method 'show' di ReportController dengan parameter 'type'
Route::get('/report/{type}/{indicator}', [ReportController::class, 'show'])->name('report.show');


require __DIR__.'/auth.php';

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KabupatenKota;
use App\Models\MainCategory;
use App\Models\StatisticValue;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman utama dashboard.
     * Method ini mengambil semua data yang dibutuhkan untuk filter
     * dan menu dinamis, lalu mengirimkannya ke view.
     */
    public function index()
    {
        // Data untuk filter di navbar
        $kabupatenKotas = KabupatenKota::orderBy('name')->get();
        $mainCategories = MainCategory::orderBy('name')->get();
        
        // Mengambil tahun unik dari data yang ada, lalu urutkan dari terbaru
        $years = StatisticValue::select('year')
                                ->distinct()
                                ->orderBy('year', 'desc')
                                ->pluck('year');

        // Data BARU untuk Sidebar Dinamis
        // Mengambil kategori utama beserta relasi sub-kategorinya
        $mainCategoriesWithSubs = MainCategory::with(['subCategories' => function ($query) {
            $query->orderBy('name');
        }])->orderBy('name')->get();

        // Mengirim semua data yang dibutuhkan ke view 'dashboard'
        return view('dashboard', [
            'kabupatenKotas' => $kabupatenKotas,
            'mainCategories' => $mainCategories,
            'years' => $years,
            'mainCategoriesWithSubs' => $mainCategoriesWithSubs, // Data ini untuk sidebar
        ]);
    }
}

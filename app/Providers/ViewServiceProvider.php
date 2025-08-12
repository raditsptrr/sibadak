<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\MainCategory;
use App\Models\KabupatenKota;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Composer ini akan berjalan SETIAP KALI view 'partials.sidebar' dipanggil.
        View::composer('partials.sidebar', function ($view) {
            // Mengambil data untuk menu laporan dinamis
            $mainCategoriesWithSubs = MainCategory::with(['subCategories' => function ($query) {
                $query->orderBy('name');
            }])->orderBy('name')->get();

            // Mengambil data untuk menu dropdown wilayah
            $kabupatenKotas = KabupatenKota::orderBy('name')->get();

            // Mengirimkan data ke view sidebar secara otomatis
            $view->with([
                'mainCategoriesWithSubs' => $mainCategoriesWithSubs,
                'kabupatenKotas' => $kabupatenKotas
            ]);
        });
    }
}

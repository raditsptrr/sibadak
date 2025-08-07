<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::create('demographic_statistics', function (Blueprint $table) {
            $table->id(); // Kolom ID utama
            // Foreign key ke tabel kabupatens_kota
            // onDelete('cascade') berarti jika kabupaten/kota dihapus, data statistik terkait juga dihapus
            $table->foreignId('kab_kota_id')->constrained('kabupatens_kota')->onDelete('cascade');
            $table->integer('year'); // Tahun data statistik

            // Indikator demografi (nullable berarti bisa kosong)
            $table->float('area_sqkm')->nullable(); // Luas wilayah (km²)
            $table->integer('population')->nullable(); // Jumlah penduduk
            $table->float('poverty_rate')->nullable(); // Tingkat kemiskinan (%)
            $table->integer('labor_force')->nullable(); // Jumlah tenaga kerja
            $table->float('open_unemployment_rate')->nullable(); // Tingkat pengangguran terbuka (%)
            $table->float('avg_years_schooling')->nullable(); // Rata-rata lama sekolah (tahun)
            $table->float('literacy_rate')->nullable(); // Tingkat melek huruf (%)
            $table->float('life_expectancy')->nullable(); // Angka harapan hidup (tahun)
            $table->float('infant_mortality_rate')->nullable(); // Angka kematian bayi (per 1000 kelahiran)
            $table->double('avg_consumption_per_capita')->nullable(); // Rata-rata konsumsi per kapita // Rata-rata konsumsi per kapita
            $table->float('social_protection_coverage')->nullable(); // Cakupan perlindungan sosial (%)
            $table->float('housing_adequacy_rate')->nullable(); // Tingkat kecukupan perumahan (%)

            $table->timestamps(); // Kolom created_at dan updated_at

            // Indeks unik untuk memastikan tidak ada data ganda untuk satu kabupaten & tahun
            $table->unique(['kab_kota_id', 'year']);
        });
    }

    /**
     * Balikkan migrasi (rollback).
     */
    public function down(): void
    {
        Schema::dropIfExists('demographic_statistics'); // Hapus tabel jika migrasi dibalikkan
    }
};

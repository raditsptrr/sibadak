<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('economic_statistics', function (Blueprint $table) {
            $table->id(); // Kolom ID utama
            // Foreign key ke tabel kabupatens_kota
            $table->foreignId('kab_kota_id')->constrained('kabupatens_kota')->onDelete('cascade');
            $table->integer('year'); // Tahun data statistik

            // Indikator ekonomi (nullable berarti bisa kosong)
            $table->float('economic_growth_rate')->nullable(); // Pertumbuhan ekonomi (%)
            $table->float('inflation_rate')->nullable(); // Inflasi (%)
            $table->float('investment_value')->nullable(); // Nilai investasi (miliar IDR)
            $table->integer('num_umkm')->nullable(); // Jumlah UMKM
            $table->integer('num_cooperatives')->nullable(); // Jumlah koperasi
            $table->float('grdp')->nullable(); // PDRB (miliar IDR)
            $table->float('agriculture_contribution')->nullable(); // Kontribusi pertanian ke PDRB (%)
            $table->float('forestry_contribution')->nullable(); // Kontribusi kehutanan ke PDRB (%)
            $table->float('fisheries_contribution')->nullable(); // Kontribusi perikanan ke PDRB (%)

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
        Schema::dropIfExists('economic_statistics'); // Hapus tabel jika migrasi dibalikkan
    }
};

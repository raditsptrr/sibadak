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
        Schema::create('kabupatens_kota', function (Blueprint $table) {
            $table->id(); // Kolom ID utama (primary key, auto-increment)
            $table->string('name')->unique(); // Nama kabupaten/kota, harus unik
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Balikkan migrasi (rollback).
     */
    public function down(): void
    {
        Schema::dropIfExists('kabupatens_kota'); // Hapus tabel jika migrasi dibalikkan
    }
};

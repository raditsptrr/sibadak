<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('statistic_values', function (Blueprint $table) {
            $table->id();
            // Pastikan baris ini persis seperti ini
            $table->foreignId('kab_kota_id')->constrained('kabupatens_kota')->onDelete('cascade');
            $table->foreignId('indicator_id')->constrained('indicators')->onDelete('cascade');
            $table->year('year');
            $table->double('value');
            $table->timestamps();

            $table->unique(['kab_kota_id', 'indicator_id', 'year']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statistic_values');
    }
};
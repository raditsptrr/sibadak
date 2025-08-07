<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemographicStatistic extends Model
{
    use HasFactory;

    // Kolom yang bisa diisi secara massal
    protected $fillable = [
        'kab_kota_id',
        'year',
        'area_sqkm',
        'population',
        'poverty_rate',
        'labor_force',
        'open_unemployment_rate',
        'avg_years_schooling',
        'literacy_rate',
        'life_expectancy',
        'infant_mortality_rate',
        'avg_consumption_per_capita',
        'social_protection_coverage',
        'housing_adequacy_rate',
    ];

    /**
     * Relasi ke KabupatenKota.
     * Sebuah DemographicStatistic dimiliki oleh satu KabupatenKota.
     */
    public function kabupatenKota()
    {
        return $this->belongsTo(KabupatenKota::class, 'kab_kota_id');
    }
}

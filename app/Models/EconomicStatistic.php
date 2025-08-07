<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EconomicStatistic extends Model
{
    use HasFactory;

    // Kolom yang bisa diisi secara massal
    protected $fillable = [
        'kab_kota_id',
        'year',
        'economic_growth_rate',
        'inflation_rate',
        'investment_value',
        'num_umkm',
        'num_cooperatives',
        'grdp',
        'agriculture_contribution',
        'forestry_contribution',
        'fisheries_contribution',
    ];

    /**
     * Relasi ke KabupatenKota.
     * Sebuah EconomicStatistic dimiliki oleh satu KabupatenKota.
     */
    public function kabupatenKota()
    {
        return $this->belongsTo(KabupatenKota::class, 'kab_kota_id');
    }
}

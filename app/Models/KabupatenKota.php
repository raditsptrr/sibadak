<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KabupatenKota extends Model
{
    use HasFactory;

    // Nama tabel jika tidak sesuai konvensi Laravel (plural dari nama model)
    // Dalam kasus ini, kita menggunakan 'kabupatens_kota'
    protected $table = 'kabupatens_kota';

    // Kolom yang bisa diisi secara massal (mass assignable)
    protected $fillable = [
        'name',
    ];

    /**
     * Relasi ke data statistik demografi.
     * Sebuah KabupatenKota bisa memiliki banyak DemographicStatistic.
     */
    public function demographicStatistics()
    {
        return $this->hasMany(DemographicStatistic::class, 'kab_kota_id');
    }

    /**
     * Relasi ke data statistik ekonomi.
     * Sebuah KabupatenKota bisa memiliki banyak EconomicStatistic.
     */
    public function economicStatistics()
    {
        return $this->hasMany(EconomicStatistic::class, 'kab_kota_id');
    }
}

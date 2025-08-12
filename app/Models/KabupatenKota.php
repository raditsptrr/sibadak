<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KabupatenKota extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model.
     *
     * @var string
     */
    protected $table = 'kabupatens_kota';

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Mendefinisikan relasi one-to-many ke StatisticValue.
     * Satu kabupaten/kota memiliki banyak nilai statistik.
     */
    public function statisticValues(): HasMany
    {
        return $this->hasMany(StatisticValue::class, 'kab_kota_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Indicator extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model.
     *
     * @var string
     */
    protected $table = 'indicators';

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array
     */
    protected $fillable = [
        'sub_category_id',
        'name',
        'unit',
    ];

    /**
     * Menonaktifkan timestamps jika tidak ada di tabel.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Mendefinisikan relasi many-to-one ke SubCategory.
     * Satu indikator dimiliki oleh satu sub kategori.
     */
    public function subCategory(): BelongsTo
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }

    /**
     * Mendefinisikan relasi one-to-many ke StatisticValue.
     * Satu indikator memiliki banyak nilai statistik.
     */
    public function statisticValues(): HasMany
    {
        return $this->hasMany(StatisticValue::class, 'indicator_id');
    }
}
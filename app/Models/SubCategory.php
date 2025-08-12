<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubCategory extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model.
     *
     * @var string
     */
    protected $table = 'sub_categories';

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array
     */
    protected $fillable = [
        'main_category_id',
        'name',
    ];

    /**
     * Menonaktifkan timestamps jika tidak ada di tabel.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Mendefinisikan relasi many-to-one ke MainCategory.
     * Satu sub kategori dimiliki oleh satu kategori utama.
     */
    public function mainCategory(): BelongsTo
    {
        return $this->belongsTo(MainCategory::class, 'main_category_id');
    }

    /**
     * Mendefinisikan relasi one-to-many ke Indicator.
     * Satu sub kategori memiliki banyak indikator.
     */
    public function indicators(): HasMany
    {
        return $this->hasMany(Indicator::class, 'sub_category_id');
    }
}

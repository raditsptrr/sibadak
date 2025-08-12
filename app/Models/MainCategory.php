<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MainCategory extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model.
     *
     * @var string
     */
    protected $table = 'main_categories';

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Menonaktifkan timestamps (created_at, updated_at) jika tidak ada di tabel.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Mendefinisikan relasi one-to-many ke SubCategory.
     * Satu kategori utama memiliki banyak sub kategori.
     */
    public function subCategories(): HasMany
    {
        return $this->hasMany(SubCategory::class, 'main_category_id');
    }
}
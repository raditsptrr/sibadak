<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MainCategory;
use App\Models\SubCategory;
use App\Models\Indicator;

class CategoryIndicatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Struktur data hierarkis yang telah direvisi dan diperbarui
        $data = [
            'Demografi' => [
                'Kependudukan' => [
                    ['name' => 'Luas Wilayah', 'unit' => 'km²'],
                    ['name' => 'Jumlah Penduduk', 'unit' => 'jiwa'],
                ],
                'Pendidikan' => [
                    ['name' => 'Rata-rata Lama Sekolah', 'unit' => 'tahun'],
                    ['name' => 'Tingkat Melek Huruf', 'unit' => '%'],
                    ['name' => 'Banyaknya Sekolah SD', 'unit' => 'unit'],
                    ['name' => 'Banyaknya Sekolah SMP', 'unit' => 'unit'],
                    ['name' => 'Banyaknya Sekolah SMA/SMK', 'unit' => 'unit'],
                ],
                'Kesehatan' => [
                    ['name' => 'Angka Harapan Hidup', 'unit' => 'tahun'],
                    ['name' => 'Angka Kematian Bayi', 'unit' => 'per 1000 kelahiran'],
                    ['name' => 'Banyaknya Fasilitas Kesehatan', 'unit' => 'unit'],
                    ['name' => 'Jumlah Kasus Penyakit Menular Tertentu', 'unit' => 'kasus'],
                ],
                'Kesejahteraan Sosial' => [
                    ['name' => 'Tingkat Kemiskinan', 'unit' => '%'],
                    ['name' => 'Cakupan Perlindungan Sosial', 'unit' => '%'],
                ],
                'Tenaga Kerja' => [
                    ['name' => 'Jumlah Angkatan Kerja', 'unit' => 'orang'],
                    ['name' => 'Tingkat Pengangguran Terbuka', 'unit' => '%'],
                ],
                'Perumahan' => [
                    ['name' => 'Tingkat Kecukupan Perumahan', 'unit' => '%'],
                ],
                'Konsumsi dan Pendapatan' => [
                    ['name' => 'Rata-rata Konsumsi per Kapita', 'unit' => 'Rupiah'],
                ]
            ],
            'Ekonomi' => [
                'Makro Ekonomi' => [
                    ['name' => 'Pertumbuhan Ekonomi', 'unit' => '%'],
                    ['name' => 'Tingkat Inflasi', 'unit' => '%'],
                    ['name' => 'PDRB (Produk Domestik Regional Bruto)', 'unit' => 'miliar IDR'],
                ],
                'Investasi dan Usaha' => [
                    ['name' => 'Nilai Investasi', 'unit' => 'miliar IDR'],
                    ['name' => 'Jumlah UMKM', 'unit' => 'unit'],
                    ['name' => 'Jumlah Koperasi', 'unit' => 'unit'],
                ],
                'Sektor Ekonomi' => [
                    ['name' => 'Kontribusi Pertanian', 'unit' => '%'],
                    ['name' => 'Kontribusi Kehutanan', 'unit' => '%'],
                    ['name' => 'Kontribusi Perikanan', 'unit' => '%'],
                ]
            ]
        ];

        // Looping untuk memasukkan data ke database
        foreach ($data as $mainCategoryName => $subCategories) {
            // 1. Buat atau cari Kategori Utama
            $mainCategory = MainCategory::updateOrCreate(['name' => $mainCategoryName]);

            foreach ($subCategories as $subCategoryName => $indicators) {
                // 2. Buat atau cari Sub Kategori
                $subCategory = SubCategory::updateOrCreate(
                    [
                        'main_category_id' => $mainCategory->id,
                        'name' => $subCategoryName
                    ]
                );

                foreach ($indicators as $indicatorData) {
                    // 3. Buat atau cari Indikator
                    Indicator::updateOrCreate(
                        [
                            'sub_category_id' => $subCategory->id,
                            'name' => $indicatorData['name']
                        ],
                        [
                            'unit' => $indicatorData['unit']
                        ]
                    );
                }
            }
        }
    }
}

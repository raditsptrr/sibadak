<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\KabupatenKota; // Pastikan model di-import

class KabupatenKotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Daftar 9 wilayah Bakorwil 3
        $daerah = [
            'Kabupaten Blitar',
            'Kabupaten Malang',
            'Kabupaten Pasuruan',
            'Kabupaten Sidoarjo',
            'Kota Batu',
            'Kota Blitar',
            'Kota Malang',
            'Kota Pasuruan',
            'Kota Surabaya',
        ];

        // Looping untuk memasukkan setiap daerah ke dalam database
        foreach ($daerah as $namaDaerah) {
            // Menggunakan updateOrCreate untuk mencegah duplikasi data
            // jika seeder dijalankan lebih dari sekali.
            KabupatenKota::updateOrCreate(
                ['name' => $namaDaerah] // Kondisi untuk mencari data
            );
        }
    }
}

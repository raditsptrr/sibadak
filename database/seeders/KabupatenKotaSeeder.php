<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\KabupatenKota; // Pastikan ini di-import

class KabupatenKotaSeeder extends Seeder
{
    /**
     * Jalankan seeder database.
     */
    public function run(): void
    {
        $kabKotas = [
            'Kabupaten Blitar',
            'Kota Blitar',
            'Kabupaten Malang',
            'Kota Malang',
            'Kota Batu',
            'Kabupaten Pasuruan',
            'Kota Pasuruan',
            'Kabupaten Sidoarjo',
            'Kota Surabaya',
        ];

        // Menggunakan firstOrCreate untuk menghindari duplikasi jika seeder dijalankan lebih dari sekali
        foreach ($kabKotas as $name) {
            KabupatenKota::firstOrCreate(['name' => $name]);
        }
    }
}

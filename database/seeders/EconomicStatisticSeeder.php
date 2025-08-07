<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\KabupatenKota; // Pastikan ini di-import
use App\Models\EconomicStatistic; // Pastikan ini di-import

class EconomicStatisticSeeder extends Seeder
{
    /**
     * Jalankan seeder database.
     */
    public function run(): void
    {
        // Data dummy untuk statistik ekonomi
        $data = [
            // Data untuk Kabupaten Blitar (tahun 2023 & 2022)
            ['Kabupaten Blitar', 2023, 5.0, 3.0, 1000, 25000, 150, 50000, 30.0, 5.0, 2.0],
            ['Kabupaten Blitar', 2022, 4.8, 3.2, 950, 24000, 145, 48000, 29.0, 4.8, 1.9],

            // Data untuk Kota Blitar (tahun 2023 & 2022)
            ['Kota Blitar', 2023, 6.5, 2.5, 1500, 5000, 20, 10000, 2.0, 0.5, 0.2],
            ['Kota Blitar', 2022, 6.2, 2.8, 1400, 4800, 18, 9800, 1.8, 0.4, 0.1],

            // Data untuk Kabupaten Malang (tahun 2023 & 2022)
            ['Kabupaten Malang', 2023, 5.2, 3.1, 1200, 30000, 180, 60000, 35.0, 6.0, 2.5],
            ['Kabupaten Malang', 2022, 5.0, 3.3, 1150, 29000, 175, 58000, 34.0, 5.8, 2.4],

            // Data untuk Kota Malang (tahun 2023 & 2022)
            ['Kota Malang', 2023, 7.0, 2.0, 2000, 8000, 30, 15000, 1.0, 0.2, 0.1],
            ['Kota Malang', 2022, 6.8, 2.2, 1900, 7800, 28, 14500, 0.9, 0.1, 0.1],

            // Data untuk Kota Batu (tahun 2023 & 2022)
            ['Kota Batu', 2023, 6.0, 2.8, 1300, 6000, 25, 12000, 5.0, 1.0, 0.5],
            ['Kota Batu', 2022, 5.8, 3.0, 1250, 5800, 23, 11500, 4.8, 0.9, 0.4],

            // Data untuk Kabupaten Pasuruan (tahun 2023 & 2022)
            ['Kabupaten Pasuruan', 2023, 4.5, 3.5, 900, 20000, 120, 40000, 28.0, 4.0, 1.5],
            ['Kabupaten Pasuruan', 2022, 4.3, 3.7, 850, 19000, 115, 38000, 27.0, 3.8, 1.4],

            // Data untuk Kota Pasuruan (tahun 2023 & 2022)
            ['Kota Pasuruan', 2023, 5.5, 3.0, 1100, 4000, 15, 8000, 1.5, 0.3, 0.1],
            ['Kota Pasuruan', 2022, 5.3, 3.2, 1050, 3800, 14, 7800, 1.4, 0.2, 0.1],

            // Data untuk Kabupaten Sidoarjo (tahun 2023 & 2022)
            ['Kabupaten Sidoarjo', 2023, 6.8, 2.3, 1800, 40000, 200, 80000, 10.0, 2.0, 1.0],
            ['Kabupaten Sidoarjo', 2022, 6.5, 2.5, 1700, 38000, 190, 78000, 9.5, 1.8, 0.9],

            // Data untuk Kota Surabaya (tahun 2023 & 2022)
            ['Kota Surabaya', 2023, 8.0, 1.8, 2500, 10000, 50, 20000, 0.5, 0.1, 0.05],
            ['Kota Surabaya', 2022, 7.8, 2.0, 2400, 9800, 48, 19500, 0.4, 0.1, 0.04],
        ];

        foreach ($data as $item) {
            $kabKota = KabupatenKota::where('name', $item[0])->first();
            if ($kabKota) {
                EconomicStatistic::firstOrCreate(
                    ['kab_kota_id' => $kabKota->id, 'year' => $item[1]],
                    [
                        'economic_growth_rate' => $item[2],
                        'inflation_rate' => $item[3],
                        'investment_value' => $item[4],
                        'num_umkm' => $item[5],
                        'num_cooperatives' => $item[6],
                        'grdp' => $item[7],
                        'agriculture_contribution' => $item[8],
                        'forestry_contribution' => $item[9],
                        'fisheries_contribution' => $item[10],
                    ]
                );
            }
        }
    }
}

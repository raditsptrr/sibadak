<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\KabupatenKota; // Pastikan ini di-import
use App\Models\DemographicStatistic; // Pastikan ini di-import

class DemographicStatisticSeeder extends Seeder
{
    /**
     * Jalankan seeder database.
     */
    public function run(): void
    {
        // Data dummy untuk statistik demografi
        $data = [
            // Data untuk Kabupaten Blitar (tahun 2023 & 2022)
            ['Kabupaten Blitar', 2023, 1588.79, 1150000, 10.5, 550000, 4.2, 8.5, 95.0, 72.5, 15.0, 1500000, 80.0, 75.0],
            ['Kabupaten Blitar', 2022, 1588.79, 1140000, 11.0, 540000, 4.5, 8.3, 94.5, 72.0, 16.0, 1450000, 78.0, 73.0],

            // Data untuk Kota Blitar (tahun 2023 & 2022)
            ['Kota Blitar', 2023, 32.57, 135000, 7.8, 65000, 3.5, 10.0, 98.0, 74.0, 10.0, 2500000, 85.0, 80.0],
            ['Kota Blitar', 2022, 32.57, 134000, 8.0, 64000, 3.8, 9.8, 97.5, 73.5, 10.5, 2400000, 83.0, 78.0],

            // Data untuk Kabupaten Malang (tahun 2023 & 2022)
            ['Kabupaten Malang', 2023, 3534.86, 2650000, 8.13, 1300000, 5.48, 9.0, 96.0, 73.0, 14.0, 1800000, 70.0, 70.0],
            ['Kabupaten Malang', 2022, 3534.86, 2630000, 8.5, 1280000, 5.8, 8.8, 95.5, 72.5, 15.0, 1750000, 68.0, 68.0],

            // Data untuk Kota Malang (tahun 2023 & 2022)
            ['Kota Malang', 2023, 110.06, 850000, 4.5, 400000, 6.1, 12.0, 99.0, 75.0, 8.0, 3500000, 90.0, 85.0],
            ['Kota Malang', 2022, 110.06, 840000, 4.8, 390000, 6.5, 11.8, 98.5, 74.5, 8.5, 3400000, 88.0, 83.0],

            // Data untuk Kota Batu (tahun 2023 & 2022)
            ['Kota Batu', 2023, 202.30, 210000, 6.2, 100000, 7.0, 9.5, 97.0, 73.8, 12.0, 2200000, 78.0, 72.0],
            ['Kota Batu', 2022, 202.30, 208000, 6.5, 98000, 7.2, 9.3, 96.5, 73.3, 12.5, 2100000, 76.0, 70.0],

            // Data untuk Kabupaten Pasuruan (tahun 2023 & 2022)
            ['Kabupaten Pasuruan', 2023, 1474.00, 1650000, 9.0, 800000, 5.0, 8.0, 93.0, 71.0, 18.0, 1600000, 65.0, 60.0],
            ['Kabupaten Pasuruan', 2022, 1474.00, 1630000, 9.3, 790000, 5.3, 7.8, 92.5, 70.5, 19.0, 1550000, 63.0, 58.0],

            // Data untuk Kota Pasuruan (tahun 2023 & 2022)
            ['Kota Pasuruan', 2023, 35.38, 200000, 8.5, 95000, 4.8, 9.0, 95.0, 72.0, 13.0, 2000000, 75.0, 65.0],
            ['Kota Pasuruan', 2022, 35.38, 198000, 8.8, 93000, 5.1, 8.8, 94.5, 71.5, 13.5, 1950000, 73.0, 63.0],

            // Data untuk Kabupaten Sidoarjo (tahun 2023 & 2022)
            ['Kabupaten Sidoarjo', 2023, 897.77, 2300000, 6.0, 1100000, 5.5, 10.5, 98.5, 74.5, 9.0, 2800000, 88.0, 82.0],
            ['Kabupaten Sidoarjo', 2022, 897.77, 2280000, 6.3, 1080000, 5.8, 10.3, 98.0, 74.0, 9.5, 2700000, 86.0, 80.0],

            // Data untuk Kota Surabaya (tahun 2023 & 2022)
            ['Kota Surabaya', 2023, 350.54, 3000000, 3.0, 1500000, 4.0, 11.5, 99.5, 76.0, 7.0, 4500000, 95.0, 90.0],
            ['Kota Surabaya', 2022, 350.54, 2980000, 3.2, 1480000, 4.3, 11.3, 99.0, 75.5, 7.5, 4400000, 93.0, 88.0],
        ];

        foreach ($data as $item) {
            $kabKota = KabupatenKota::where('name', $item[0])->first();
            if ($kabKota) {
                DemographicStatistic::firstOrCreate(
                    ['kab_kota_id' => $kabKota->id, 'year' => $item[1]],
                    [
                        'area_sqkm' => $item[2],
                        'population' => $item[3],
                        'poverty_rate' => $item[4],
                        'labor_force' => $item[5],
                        'open_unemployment_rate' => $item[6],
                        'avg_years_schooling' => $item[7],
                        'literacy_rate' => $item[8],
                        'life_expectancy' => $item[9],
                        'infant_mortality_rate' => $item[10],
                        'avg_consumption_per_capita' => $item[11],
                        'social_protection_coverage' => $item[12],
                        'housing_adequacy_rate' => $item[13],
                    ]
                );
            }
        }
    }
}

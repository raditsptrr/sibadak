<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\KabupatenKota;
use App\Models\Indicator;
use App\Models\StatisticValue;

class StatisticValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Panggil fungsi untuk membuat data yang pasti ada (untuk demo)
        $this->createGuaranteedData();

        // Mendefinisikan semua variabel SEBELUM digunakan dalam loop
        $kabupatenKotas = KabupatenKota::all();
        $indicators = Indicator::all();
        $years = range(2020, 2023); // Data acak sampai 2023 saja

        // Looping untuk membuat data acak
        foreach ($kabupatenKotas as $kabupaten) {
            // Lewati Kota Malang untuk data acak, karena sudah diisi data pasti
            if ($kabupaten->name === 'Kota Malang') {
                continue;
            }
            foreach ($years as $year) {
                foreach ($indicators as $indicator) {
                    StatisticValue::updateOrCreate(
                        [
                            'kab_kota_id' => $kabupaten->id,
                            'indicator_id' => $indicator->id,
                            'year' => $year,
                        ],
                        ['value' => $this->generateRealisticValue($indicator)]
                    );
                }
            }
        }
    }

    /**
     * Fungsi baru untuk membuat data yang pasti ada untuk demo.
     * Fokus pada Kota Malang Tahun 2024.
     */
    private function createGuaranteedData(): void
    {
        $kotaMalang = KabupatenKota::where('name', 'Kota Malang')->first();
        $year = 2024;

        if (!$kotaMalang) {
            return; // Jika Kota Malang tidak ditemukan, hentikan.
        }

        $indicators = Indicator::all();

        foreach ($indicators as $indicator) {
            StatisticValue::updateOrCreate(
                [
                    'kab_kota_id' => $kotaMalang->id,
                    'indicator_id' => $indicator->id,
                    'year' => $year,
                ],
                ['value' => $this->getGuaranteedValue($indicator)]
            );
        }
    }

    /**
     * Fungsi helper untuk memberikan nilai pasti, bukan acak.
     */
    private function getGuaranteedValue(Indicator $indicator): float
    {
        if (str_contains($indicator->name, 'Penduduk')) return 895321;
        if (str_contains($indicator->name, 'Kemiskinan')) return 4.6;
        if (str_contains($indicator->name, 'Pengangguran')) return 7.8;
        if (str_contains($indicator->name, 'Sekolah SD')) return 290;
        if (str_contains($indicator->name, 'Fasilitas Kesehatan')) return 150;
        if (str_contains($indicator->name, 'Pertumbuhan Ekonomi')) return 5.75;
        if (str_contains($indicator->name, 'Inflasi')) return 3.1;
        if (str_contains($indicator->name, 'UMKM')) return 65432;
        
        switch ($indicator->unit) {
            case '%': return 10.5;
            case 'jiwa': return 500000;
            case 'orang': return 25000;
            case 'unit': return 100;
            case 'tahun': return 10.2;
            case 'km²': return 110.06;
            case 'miliar IDR': return 15000;
            default: return 50;
        }
    }

    /**
     * Fungsi helper untuk membuat nilai acak (tetap digunakan untuk data lain).
     */
    private function generateRealisticValue(Indicator $indicator): float
    {
        switch ($indicator->unit) {
            case '%': return round(mt_rand(100, 1500) / 100, 2);
            case 'jiwa':
            case 'orang':
                if (str_contains($indicator->name, 'Penduduk')) return mt_rand(200000, 2500000);
                return mt_rand(5000, 250000);
            case 'unit':
                if (str_contains($indicator->name, 'UMKM')) return mt_rand(10000, 150000);
                return mt_rand(10, 500);
            case 'tahun':
                if (str_contains($indicator->name, 'Harapan Hidup')) return round(mt_rand(6500, 7500) / 100, 2);
                return round(mt_rand(700, 1300) / 100, 2);
            case 'km²': return mt_rand(100, 3000);
            case 'miliar IDR': return mt_rand(1000, 50000);
            case 'Rupiah': return mt_rand(500000, 1500000);
            case 'per 1000 kelahiran': return round(mt_rand(500, 3000) / 100, 2);
            default: return mt_rand(1, 1000);
        }
    }
}

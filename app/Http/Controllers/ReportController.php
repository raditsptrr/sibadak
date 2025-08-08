<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DemographicStatistic;
use App\Models\EconomicStatistic;
use App\Models\KabupatenKota;
use Illuminate\Support\Facades\File; // Import kelas File

class ReportController extends Controller
{
    // Mapping indikator ke label yang lebih mudah dibaca
    private $indicatorLabels = [
        'demographic' => [
            'area_sqkm' => 'Luas Wilayah',
            'population' => 'Jumlah Penduduk',
            'poverty_rate' => 'Tingkat Kemiskinan',
            'labor_force' => 'Tenaga Kerja',
            'open_unemployment_rate' => 'Tingkat Pengangguran Terbuka',
            'avg_years_schooling' => 'Rata-rata Lama Sekolah',
            'literacy_rate' => 'Tingkat Melek Huruf',
            'life_expectancy' => 'Angka Harapan Hidup',
            'infant_mortality_rate' => 'Angka Kematian Bayi',
            'avg_consumption_per_capita' => 'Rata-rata Konsumsi per Kapita',
            'social_protection_coverage' => 'Cakupan Perlindungan Sosial',
            'housing_adequacy_rate' => 'Tingkat Kecukupan Perumahan',
        ],
        'economic' => [
            'economic_growth_rate' => 'Pertumbuhan Ekonomi',
            'inflation_rate' => 'Inflasi',
            'investment_value' => 'Nilai Investasi',
            'num_umkm' => 'Jumlah UMKM',
            'num_cooperatives' => 'Jumlah Koperasi',
            'grdp' => 'PDRB',
            'agriculture_contribution' => 'Kontribusi Pertanian',
            'forestry_contribution' => 'Kontribusi Kehutanan',
            'fisheries_contribution' => 'Kontribusi Perikanan',
        ]
    ];
    
    // Unit untuk setiap indikator (untuk tampilan tabel)
    private $indicatorUnits = [
        'demographic' => [
            'area_sqkm' => 'km²',
            'population' => 'jiwa',
            'poverty_rate' => '%',
            'labor_force' => 'orang',
            'open_unemployment_rate' => '%',
            'avg_years_schooling' => 'tahun',
            'literacy_rate' => '%',
            'life_expectancy' => 'tahun',
            'infant_mortality_rate' => 'per 1000 kelahiran',
            'avg_consumption_per_capita' => 'IDR', // Sesuaikan jika ada unit spesifik
            'social_protection_coverage' => '%',
            'housing_adequacy_rate' => '%',
        ],
        'economic' => [
            'economic_growth_rate' => '%',
            'inflation_rate' => '%',
            'investment_value' => 'Miliar IDR',
            'num_umkm' => '', // Tanpa unit spesifik
            'num_cooperatives' => '', // Tanpa unit spesifik
            'grdp' => 'Miliar IDR',
            'agriculture_contribution' => '%',
            'forestry_contribution' => '%',
            'fisheries_contribution' => '%',
        ]
    ];


    public function show(Request $request, $type, $indicator)
    {
        // Validasi tipe laporan dan indikator
        if (!array_key_exists($type, $this->indicatorLabels) || !array_key_exists($indicator, $this->indicatorLabels[$type])) {
            abort(404, 'Tipe laporan atau indikator tidak ditemukan.');
        }

        // Ambil semua tahun unik dari kedua tabel statistik untuk dropdown filter
        $demographicYears = DemographicStatistic::select('year')->distinct()->pluck('year');
        $economicYears = EconomicStatistic::select('year')->distinct()->pluck('year');
        $availableYears = $demographicYears->merge($economicYears)->unique()->sortDesc()->values();

        // Tentukan tahun default: jika ada di query, gunakan itu. Jika tidak, gunakan tahun terbaru dari database.
        $defaultYear = $availableYears->first();
        $year = $request->query('year', $defaultYear);

        $indicatorLabel = $this->indicatorLabels[$type][$indicator];
        $indicatorUnit = $this->indicatorUnits[$type][$indicator] ?? '';

        $kabKotas = KabupatenKota::orderBy('name')->get();

        $model = null;
        if ($type === 'demographic') {
            $model = new DemographicStatistic();
        } elseif ($type === 'economic') {
            $model = new EconomicStatistic();
        }

        if (!$model || !in_array($indicator, $model->getFillable())) {
            abort(404, 'Indikator tidak valid atau model tidak ditemukan.');
        }

        $rawData = $model->where('year', $year)
                         ->with('kabupatenKota')
                         ->get();

        $reportData = [];
        foreach ($kabKotas as $kabKota) {
            $item = $rawData->firstWhere('kabupatenKota.name', $kabKota->name);
            $value = $item ? $item->$indicator : null;

            $reportData[] = [
                'kab_kota_name' => $kabKota->name,
                'value' => $value,
            ];
        }
        
        // --- Bagian baru untuk memuat deskripsi dari JSON ---
        $description = '';
        $jsonPath = resource_path('data/indicator_descriptions.json'); // Path ke file JSON
        if (File::exists($jsonPath)) {
            $jsonContent = File::get($jsonPath);
            $descriptions = json_decode($jsonContent, true);
            $description = $descriptions[$type][$indicator] ?? 'Deskripsi tidak tersedia.';
        }
        // --- Akhir bagian baru ---

        $viewName = 'report.index';
        return view($viewName, compact('type', 'indicator', 'indicatorLabel', 'indicatorUnit', 'year', 'reportData', 'kabKotas', 'availableYears', 'description'));
    }
}

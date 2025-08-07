<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DemographicStatistic; // Import model DemographicStatistic
use App\Models\EconomicStatistic;    // Import model EconomicStatistic
use App\Models\KabupatenKota;       // Import model KabupatenKota
use Illuminate\Http\Request;

class StatisticController extends Controller
{
    /**
     * Mengambil daftar data statistik berdasarkan tahun.
     * Tidak terlalu relevan untuk use case peta kita yang fokus per kab/kota,
     * tapi bisa dipertahankan untuk kebutuhan lain.
     */
    public function index(Request $request)
    {
        $year = $request->query('year', date('Y')); // Default tahun saat ini

        $demographics = DemographicStatistic::where('year', $year)
                                            ->with('kabupatenKota') // Load relasi kabupatenKota
                                            ->get();
        $economics = EconomicStatistic::where('year', $year)
                                         ->with('kabupatenKota') // Load relasi kabupatenKota
                                         ->get();

        return response()->json([
            'demographics' => $demographics,
            'economics' => $economics,
        ]);
    }

    /**
     * Mengambil data statistik (demografi dan ekonomi) untuk kabupaten/kota tertentu dan tahun.
     */
    public function show($kab_kota_name, Request $request)
    {
        $year = $request->query('year', date('Y')); // Default tahun saat ini

        // Cari ID Kabupaten/Kota berdasarkan nama
        $kabKota = KabupatenKota::where('name', $kab_kota_name)->first();

        if (!$kabKota) {
            return response()->json(['message' => 'Kabupaten/Kota tidak ditemukan'], 404);
        }

        // Ambil data demografi
        $demographic = DemographicStatistic::where('kab_kota_id', $kabKota->id)
                                          ->where('year', $year)
                                          ->first();

        // Ambil data ekonomi
        $economic = EconomicStatistic::where('kab_kota_id', $kabKota->id)
                                     ->where('year', $year)
                                     ->first();

        // Siapkan respons
        $response = [
            'kab_kota_name' => $kabKota->name,
            'year' => (int)$year, // Pastikan tahun dalam format integer
            'demographic_data' => $demographic,
            'economic_data' => $economic,
        ];

        return response()->json($response);
    }
}

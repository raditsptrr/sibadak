<?php

namespace App\Http\Controllers;

use App\Models\Indicator;
use App\Models\KabupatenKota;
use App\Models\MainCategory;
use App\Models\StatisticValue;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Menampilkan halaman laporan untuk Sub Kategori tertentu.
     */
    public function show(SubCategory $subCategory)
    {
        $indicators = Indicator::where('sub_category_id', $subCategory->id)->orderBy('name')->get();
        $years = StatisticValue::select('year')->distinct()->orderBy('year', 'desc')->pluck('year');
        $mainCategoriesWithSubs = MainCategory::with(['subCategories' => function ($query) {
            $query->orderBy('name');
        }])->orderBy('name')->get();

        return view('report.index', compact(
            'subCategory', 
            'indicators', 
            'years', 
            'mainCategoriesWithSubs'
        ));
    }

    /**
     * Menyediakan data untuk API di halaman laporan.
     */
    public function getReportData(Request $request)
    {
        $request->validate([
            'year' => 'required|integer',
            'indicator_id' => 'required|integer|exists:indicators,id',
        ]);

        $statistics = StatisticValue::where('indicator_id', $request->indicator_id)
            ->where('year', $request->year)
            ->get(); // Ambil hasilnya dulu

        // =================================================================
        // PERBAIKAN DI SINI: Cek apakah koleksi $statistics kosong
        // =================================================================
        if ($statistics->isEmpty()) {
            // Jika tidak ada data, kirim respons 404 (Not Found)
            return response()->json(['message' => 'Data tidak ditemukan untuk filter yang dipilih.'], 404);
        }

        // Jika data ada, lanjutkan proses seperti biasa
        $kabupatenKotas = KabupatenKota::orderBy('name')->get();
        $indicator = Indicator::findOrFail($request->indicator_id);
        
        // Gunakan ->keyBy() setelah memastikan data tidak kosong
        $statisticsByKey = $statistics->keyBy('kab_kota_id');

        $reportData = $kabupatenKotas->map(function ($kabKota) use ($statisticsByKey) {
            $value = $statisticsByKey->get($kabKota->id)->value ?? null;
            return [
                'kab_kota_name' => $kabKota->name,
                'value' => $value,
            ];
        });

        return response()->json([
            'indicator' => $indicator,
            'report_data' => $reportData,
        ]);
    }
}

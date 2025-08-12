<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StatisticValue;

class DashboardApiController extends Controller
{
    /**
     * Mengambil dan memformat data statistik untuk dashboard.
     */
    public function getData(Request $request)
    {
        // Validasi input filter dari frontend
        $request->validate([
            'year' => 'required|integer',
            'main_category_id' => 'required|integer|exists:main_categories,id',
            'kab_kota_id' => 'required|integer|exists:kabupatens_kota,id',
        ]);

        // Query dasar untuk mengambil data
        $statistics = StatisticValue::query()
            // Eager load relasi untuk performa dan info lengkap
            ->with([
                'indicator:id,name,unit,sub_category_id', 
                'indicator.subCategory:id,name', // Tidak perlu main_category_id di sini
                'kabupatenKota:id,name'
            ])
            ->where('year', $request->year)
            ->where('kab_kota_id', $request->kab_kota_id)
            // Filter berdasarkan Main Category yang dipilih
            ->whereHas('indicator.subCategory', function ($q) use ($request) {
                $q->where('main_category_id', $request->main_category_id);
            })
            ->get();

        if ($statistics->isEmpty()) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        // Format data agar mudah diolah oleh JavaScript
        $formattedData = $statistics->map(function ($item) {
            // Pemeriksaan untuk mencegah error jika relasi tidak ada
            if (!$item->indicator || !$item->indicator->subCategory || !$item->kabupatenKota) {
                return null;
            }
            return [
                'kab_kota_name' => $item->kabupatenKota->name,
                'sub_category_name' => $item->indicator->subCategory->name,
                'indicator_name' => $item->indicator->name,
                'value' => $item->value,
                'unit' => $item->indicator->unit,
            ];
        })->filter(); // ->filter() akan menghapus nilai null

        // Kelompokkan data berdasarkan Sub Kategori untuk Chart
        $groupedBySubCategory = $formattedData->groupBy('sub_category_name');

        return response()->json([
            'all_data' => $formattedData,
            'chart_data' => $groupedBySubCategory
        ]);
    }
}

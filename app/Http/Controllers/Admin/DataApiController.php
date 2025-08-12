<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubCategory;
use App\Models\Indicator;

class DataApiController extends Controller
{
    /**
     * Mengambil daftar Sub Kategori berdasarkan Main Category ID.
     */
    public function getSubCategories(Request $request)
    {
        $data = SubCategory::where('main_category_id', $request->main_category_id)
            ->orderBy('name')->get();
        return response()->json($data);
    }

    /**
     * Mengambil daftar Indikator berdasarkan Sub Category ID.
     */
    public function getIndicators(Request $request)
    {
        $data = Indicator::where('sub_category_id', $request->sub_category_id)
            ->orderBy('name')->get();
        return response()->json($data);
    }
}

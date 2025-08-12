<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Indicator;
use App\Models\MainCategory;
use Illuminate\Http\Request;

class IndicatorController extends Controller
{
    public function index()
    {
        // FIX: Mengganti latest() dengan orderBy('name')
        $indicators = Indicator::with('subCategory.mainCategory')->orderBy('name')->paginate(10);
        return view('admin.indicators.index', compact('indicators'));
    }

    public function create()
    {
        $mainCategories = MainCategory::orderBy('name')->get();
        return view('admin.indicators.create', compact('mainCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sub_category_id' => 'required|exists:sub_categories,id',
            'name' => 'required|string|unique:indicators,name|max:255',
            'unit' => 'required|string|max:50',
        ]);
        Indicator::create($request->all());
        return redirect()->route('admin.indicators.index')->with('success', 'Indikator berhasil ditambahkan.');
    }

    public function edit(Indicator $indicator)
    {
        $indicator->load('subCategory');
        $mainCategories = MainCategory::orderBy('name')->get();
        return view('admin.indicators.edit', compact('indicator', 'mainCategories'));
    }

    public function update(Request $request, Indicator $indicator)
    {
        $request->validate([
            'sub_category_id' => 'required|exists:sub_categories,id',
            'name' => 'required|string|unique:indicators,name,' . $indicator->id . '|max:255',
            'unit' => 'required|string|max:50',
        ]);
        $indicator->update($request->all());
        return redirect()->route('admin.indicators.index')->with('success', 'Indikator berhasil diperbarui.');
    }

    public function destroy(Indicator $indicator)
    {
        $indicator->delete();
        return redirect()->route('admin.indicators.index')->with('success', 'Indikator berhasil dihapus.');
    }
}
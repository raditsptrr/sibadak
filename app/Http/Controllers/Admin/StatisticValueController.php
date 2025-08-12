<?php
// File: app/Http/Controllers/Admin/StatisticValueController.php (Revisi)
// Controller ini sudah ada, kita hanya merevisi isinya

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StatisticValue;
use App\Models\KabupatenKota;
use App\Models\MainCategory;
use Illuminate\Http\Request;

class StatisticValueController extends Controller
{
    public function index(Request $request)
    {
        $query = StatisticValue::with(['kabupatenKota', 'indicator.subCategory.mainCategory']);
        if ($request->filled('kab_kota_id')) {
            $query->where('kab_kota_id', $request->kab_kota_id);
        }
        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }
        $statisticValues = $query->latest()->paginate(20);
        $kabupatenKotas = KabupatenKota::orderBy('name')->get();
        $years = range(date('Y'), 2020);
        return view('admin.statistics.index', compact('statisticValues', 'kabupatenKotas', 'years'));
    }

    public function create()
    {
        $kabupatenKotas = KabupatenKota::orderBy('name')->get();
        $mainCategories = MainCategory::orderBy('name')->get();
        $years = range(date('Y'), 2020);
        return view('admin.statistics.create', compact('kabupatenKotas', 'mainCategories', 'years'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kab_kota_id' => 'required|exists:kabupatens_kota,id',
            'indicator_id' => 'required|exists:indicators,id',
            'year' => 'required|integer|min:2000',
            'value' => 'required|numeric',
        ]);
        StatisticValue::updateOrCreate(
            [
                'kab_kota_id' => $request->kab_kota_id,
                'indicator_id' => $request->indicator_id,
                'year' => $request->year,
            ],
            ['value' => $request->value]
        );
        return redirect()->route('admin.statistics.index')->with('success', 'Data statistik berhasil disimpan.');
    }

    public function edit(StatisticValue $statisticValue)
    {
        $statisticValue->load('indicator.subCategory');
        $kabupatenKotas = KabupatenKota::orderBy('name')->get();
        $mainCategories = MainCategory::orderBy('name')->get();
        $years = range(date('Y'), 2020);
        return view('admin.statistics.edit', compact('statisticValue', 'kabupatenKotas', 'mainCategories', 'years'));
    }

    public function update(Request $request, StatisticValue $statisticValue)
    {
        $request->validate(['value' => 'required|numeric']);
        $statisticValue->update(['value' => $request->value]);
        return redirect()->route('admin.statistics.index')->with('success', 'Data statistik berhasil diperbarui.');
    }

    public function destroy(StatisticValue $statisticValue)
    {
        $statisticValue->delete();
        return redirect()->route('admin.statistics.index')->with('success', 'Data statistik berhasil dihapus.');
    }
}

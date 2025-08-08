<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DemographicStatistic;
use App\Models\KabupatenKota;

class DemographicController extends Controller
{
    // Tampilkan form untuk menambah data Demografi
    public function showForm()
    {
        $kabKotas = KabupatenKota::orderBy('name')->get();
        return view('admin.forms.demographic', compact('kabKotas'));
    }
    
    // Metode untuk menyimpan data dari form
    public function store(Request $request)
    {
        $request->validate([
            'kab_kota_id' => 'required|integer|exists:kabupatens_kota,id',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'area_sqkm' => 'nullable|numeric|min:0',
            'population' => 'nullable|integer|min:0',
            'poverty_rate' => 'nullable|numeric|min:0|max:100',
            'labor_force' => 'nullable|integer|min:0',
            'open_unemployment_rate' => 'nullable|numeric|min:0|max:100',
            'avg_years_schooling' => 'nullable|numeric|min:0',
            'literacy_rate' => 'nullable|numeric|min:0|max:100',
            'life_expectancy' => 'nullable|numeric|min:0',
            'infant_mortality_rate' => 'nullable|numeric|min:0',
            'avg_consumption_per_capita' => 'nullable|numeric|min:0',
            'social_protection_coverage' => 'nullable|numeric|min:0|max:100',
            'housing_adequacy_rate' => 'nullable|numeric|min:0|max:100',
        ]);

        DemographicStatistic::create($request->all());

        return redirect()->route('admin.forms.demographic')->with('success', 'Data Demografi berhasil ditambahkan!');
    }
}

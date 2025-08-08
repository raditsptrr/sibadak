<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EconomicStatistic;
use App\Models\KabupatenKota;

class EconomicController extends Controller
{
    // Tampilkan form untuk menambah data Ekonomi
    public function showForm()
    {
        $kabKotas = KabupatenKota::orderBy('name')->get();
        return view('admin.forms.economic', compact('kabKotas'));
    }

    // Metode untuk menyimpan data dari form
    public function store(Request $request)
    {
        $request->validate([
            'kab_kota_id' => 'required|integer|exists:kabupatens_kota,id',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'economic_growth_rate' => 'nullable|numeric',
            'inflation_rate' => 'nullable|numeric|min:0',
            'investment_value' => 'nullable|numeric|min:0',
            'num_umkm' => 'nullable|integer|min:0',
            'num_cooperatives' => 'nullable|integer|min:0',
            'grdp' => 'nullable|numeric|min:0',
            'agriculture_contribution' => 'nullable|numeric|min:0|max:100',
            'forestry_contribution' => 'nullable|numeric|min:0|max:100',
            'fisheries_contribution' => 'nullable|numeric|min:0|max:100',
        ]);

        EconomicStatistic::create($request->all());

        return redirect()->route('admin.forms.economic')->with('success', 'Data Ekonomi berhasil ditambahkan!');
    }
}

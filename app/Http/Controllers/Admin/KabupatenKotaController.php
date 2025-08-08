<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KabupatenKota;

class KabupatenKotaController extends Controller
{
    // Tampilkan form untuk menambah data Kabupaten/Kota
    public function showForm()
    {
        $kabKotas = KabupatenKota::orderBy('name')->get();
        return view('admin.forms.kabupaten_kota', compact('kabKotas'));
    }

    // Metode untuk menyimpan data dari form
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|unique:kabupatens_kota,name|max:255',
        ]);

        // Simpan data ke database
        KabupatenKota::create([
            'name' => $request->input('name'),
        ]);

        return redirect()->route('admin.forms.kabupaten_kota')->with('success', 'Kabupaten/Kota berhasil ditambahkan!');
    }
}

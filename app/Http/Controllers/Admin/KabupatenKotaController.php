<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KabupatenKota;
use Illuminate\Http\Request;

class KabupatenKotaController extends Controller
{
    /**
     * Menampilkan daftar semua kabupaten/kota.
     */
    public function index()
    {
        $kabupatenKotas = KabupatenKota::orderBy('name')->paginate(10);
        return view('admin.kabupaten_kota.index', compact('kabupatenKotas'));
    }

    /**
     * Menampilkan form untuk membuat kabupaten/kota baru.
     */
    public function create()
    {
        return view('admin.kabupaten_kota.create');
    }

    /**
     * Menyimpan kabupaten/kota baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|unique:kabupatens_kota,name|max:255']);
        KabupatenKota::create($request->all());
        return redirect()->route('admin.kabupaten-kota.index')->with('success', 'Kabupaten/Kota berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit kabupaten/kota.
     * Laravel secara otomatis akan menemukan model berdasarkan ID dari URL.
     */
    public function edit(KabupatenKota $kabupatenKotum)
    {
        // Variabel otomatis di-binding oleh Laravel, kita ganti namanya agar konsisten
        return view('admin.kabupaten_kota.edit', ['kabupatenKota' => $kabupatenKotum]);
    }

    /**
     * Memperbarui kabupaten/kota di database.
     */
    public function update(Request $request, KabupatenKota $kabupatenKotum)
    {
        $request->validate(['name' => 'required|string|unique:kabupatens_kota,name,' . $kabupatenKotum->id . '|max:255']);
        $kabupatenKotum->update($request->all());
        return redirect()->route('admin.kabupaten-kota.index')->with('success', 'Kabupaten/Kota berhasil diperbarui.');
    }

    /**
     * Menghapus kabupaten/kota dari database.
     */
    public function destroy(KabupatenKota $kabupatenKotum)
    {
        $kabupatenKotum->delete();
        return redirect()->route('admin.kabupaten-kota.index')->with('success', 'Kabupaten/Kota berhasil dihapus.');
    }
}

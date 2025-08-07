<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KabupatenKota; // Import model KabupatenKota

class MapController extends Controller
{
    public function index()
    {
        // Ambil semua daftar kabupaten/kota dari database
        $kabKotas = KabupatenKota::orderBy('name')->get();
        return view('map.index', compact('kabKotas'));
    }
}

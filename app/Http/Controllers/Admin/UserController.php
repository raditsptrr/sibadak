<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\KabupatenKota;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Tampilkan form untuk menambah data User.
     * Mengambil data kabupaten/kota untuk sidebar.
     *
     * @return \Illuminate\View\View
     */
    public function showForm()
    {
        // Variabel ini diperlukan untuk sidebar
        $kabKotas = KabupatenKota::orderBy('name')->get();
        return view('admin.forms.user', compact('kabKotas'));
    }
    
    /**
     * Metode untuk menyimpan data dari form.
     * Melakukan validasi, hashing password, dan menyimpan user baru.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:user,admin',
        ]);
        
        // Buat user baru di database
        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')), // Gunakan Hash::make() untuk mengamankan password
            'role' => $request->input('role'),
        ]);
        
        // Redirect kembali ke halaman form dengan pesan sukses
        return redirect()->route('admin.forms.user')->with('success', 'User berhasil ditambahkan!');
    }
}

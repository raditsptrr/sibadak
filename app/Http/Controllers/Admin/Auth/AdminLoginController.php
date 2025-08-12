<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    /**
     * Tampilkan form login admin.
     */
    public function showLoginForm()
    {
        // Jika sudah login sebagai admin, langsung redirect
        if (Auth::check() && Auth::user()->role === 'admin') {
            // Kode yang benar
        return redirect()->intended(route('dashboard'));
        }
        return view('auth.login'); // Menggunakan view login bawaan Breeze
    }

    /**
     * Tangani proses login admin.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            // Periksa peran setelah otentikasi berhasil
            if (Auth::user()->role === 'admin') {
                $request->session()->regenerate();
                // Kode yang benar
return redirect()->intended(route('dashboard')); // Mengarahkan admin ke halaman utama
            }

            // Jika otentikasi berhasil tapi bukan admin, logout dan beri pesan error
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return back()->withErrors(['email' => 'Informasi yang diberikan salah, atau Anda bukan admin.']);
        }

        // Jika otentikasi gagal, kembali dengan pesan error
        return back()->withErrors([
            'email' => 'Informasi yang diberikan salah, atau Anda bukan admin.',
        ])->onlyInput('email');
    }

    /**
     * Tangani proses logout admin.
     */
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}

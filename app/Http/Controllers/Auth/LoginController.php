<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // 1. Validasi Input Login
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        // 2. Ambil parameter 'remember' dari checkbox (bernilai true/false)
        $remember = $request->boolean('remember');

        // 3. Percobaan Autentikasi
        if (Auth::attempt($credentials, $remember)) {
            // Regenerasi session keamanan mencegah Session Fixation
            $request->session()->regenerate();

            $user = Auth::user();

            // 4. Pembagian Kunci Akses (Redirect Berdasarkan Role)
            if (in_array($user->role, ['petugas', 'superadmin'])) {
                return redirect()->intended(route('dashboard'))
                                 ->with('success', 'Selamat datang kembali, Petugas!');
            }

            // Jika role: pelajar atau non_pelajar, arahkan ke Home / Rak Buku
            return redirect()->intended(route('home'))
                             ->with('success', 'Berhasil masuk! Selamat membaca kembali.');
        }

        // Jika gagal, kembalikan dengan pesan error kedalam input email
        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    // Pembuatan fungsi Logout sekalian agar sistem lengkap
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Anda telah berhasil keluar sistem.');
    }
}
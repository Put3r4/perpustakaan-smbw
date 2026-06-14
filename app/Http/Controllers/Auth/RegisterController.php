<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\AnggotaPelajar;
use App\Models\AnggotaNonPelajar;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // 1. Validasi Dasar User & Pilihan Role
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:pelajar,non_pelajar'],
        ]);

        // 2. Validasi Tambahan Berdasarkan Tipe Anggota
        if ($request->role === 'pelajar') {
            $request->validate([
                'nim_nis' => ['required', 'string', 'max:30'],
                'asal_sekolah' => ['required', 'string', 'max:100'],
            ]);
        } else {
            $request->validate([
                'pekerjaan' => ['required', 'string', 'max:100'],
            ]);
        }

        // 3. Eksekusi Database Transaction
        DB::transaction(function () use ($request) {
            // Pembuatan User Akun
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ]);

            $no_anggota = 'AGT-' . strtoupper($request->role[0]) . '-' . time();

            // Pengisian data ke tabel spesifik sesuai role pilihan
            if ($request->role === 'pelajar') {
                AnggotaPelajar::create([
                    'user_id' => $user->id,
                    'no_anggota' => $no_anggota,
                    'nim_nis' => $request->nim_nis,
                    'nama_anggota' => $request->name,
                    'asal_sekolah' => $request->asal_sekolah,
                    'tgl_daftar' => now(),
                    'tanggal_lahir' => null,
                    'alamat' => '-',
                    'kode_pos' => null,
                    'no_telp1' => '-',
                    'no_telp2' => null,
                    'nama_ortu' => '-',
                    'alamat_ortu' => '-',
                    'no_telp_ortu' => '-',

                
                ]);
            } else {
                AnggotaNonPelajar::create([
                    'user_id'       => $user->id,
                    'no_anggota'    => $no_anggota,
                    'nik'           => '-',
                    'nama_anggota'  => $request->name,
                    'pekerjaan'     => $request->pekerjaan ?? '-',
                    'ttl'           => '-',
                    'alamat'        => '-',
                    'kode_pos'      => '-',
                    'no_telp1'      => '-',
                    'no_telp2'      => null,
                    'tgl_daftar'    => now()->toDateString(),
                ]);
            }

            // Pembuatan Notifikasi Sesuai Kebutuhan Bisnis
            Notification::create([
                'user_id' => $user->id,
                'title' => 'Akun Berhasil Dibuat!',
                'message' => 'Selamat datang di Perpustakaan Kota Sumbawa. Yuk, lihat koleksi buku terbaru kami di menu Rak Buku dan nikmati kemudahan membaca!',
                'is_read' => false,
            ]);

            // Login otomatis setelah sukses mendaftar
            Auth::login($user);
        });

        // Redirect langsung ke halaman utama/home dengan pesan sukses
        return redirect()->route('home')->with('success', 'Registrasi sukses! Silakan cek notifikasi akun baru Anda.');
    }
}
<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Buku;
use App\Models\VisitorLog;
use App\Models\AnggotaNonPelajar;
use App\Models\AnggotaPelajar;
use App\Models\BookView;
use App\Models\Petugas;
use App\Models\PetugasShift;
use App\Models\SystemSetting;
use App\Models\TransaksiPelajar;
use App\Models\TransaksiNonPelajar;
use App\Models\Notification; 
use App\Http\Controllers\Auth\RegisterController;

// ==========================================
// HALAMAN UTAMA DASHBOARD
// ==========================================
Route::get('/', function () {
    // 1. Data Statistik Utama
    $stats = [
        'buku'             => Buku::count(),
        'anggota'          => User::whereIn('role', ['pelajar', 'non_pelajar'])->count(),
        'kunjungan' => VisitorLog::whereDate('created_at', now()->toDateString())->count(),
        'tersedia'         => Buku::where('status', 'tersedia')->count(),
    ];

    // 2. Data Buku Terpopuler (Untuk Baris 37 di home.blade.php)
    $popularBooks = Buku::orderBy('total_dipinjam', 'desc')
                        ->take(5)
                        ->get();

    // 3. Data Pengaturan Sistem 
    try {
        $settings = SystemSetting::pluck('value_setting', 'key')->toArray();
    } catch (\Exception $e) {
        $settings = [];
    }

    // Fallback/Proteksi: Jika data di database kosong, gunakan nilai default agar web tidak pecah
    if (empty($settings)) {
        $settings = [
            'nama_perpustakaan' => 'Perpustakaan Kota Sumbawa',
            'alamat'            => 'Jl. Raya Sumbawa',
            'email'             => 'perpustakaan@sumbawa.go.id',
        ];
    }

    // Kirim seluruh variabel ke view home
    return view('home', compact('stats', 'popularBooks', 'settings'));
})->name('home');

// ==========================================
// RUTE RAK BUKU PUBLIK
// ==========================================
Route::get('/rak-buku', function () { 
    return view('buku.index'); 
})->name('buku.index');

// ==========================================
// RUTE ANGGOTA (PELAJAR & NON-PELAJAR)
// ==========================================
Route::middleware(['auth', 'roles:pelajar,non_pelajar'])->group(function () {
    Route::get('/profil-saya', function () { return view('anggota.profile'); })->name('profile.index');
    Route::get('/peminjaman-saya', function () { return view('transaksi.history'); })->name('peminjaman.index');
});

// ==========================================
// RUTE INTERNAL MANAGEMENT (PETUGAS / ADMIN)
// ==========================================
Route::middleware(['auth', 'roles:superadmin,petugas'])->prefix('dashboard')->group(function () {
    Route::get('/', function () { return view('dashboard.index'); })->name('dashboard');
});

// ==========================================
// MODULAR ROUTING FILES
// ==========================================
require __DIR__.'/auth.php';
require __DIR__.'/anggota.php';
require __DIR__.'/buku.php';
require __DIR__.'/transaksi.php';
require __DIR__.'/kunjungan.php';
require __DIR__.'/laporan.php';
require __DIR__.'/export.php';
require __DIR__.'/pengaturan.php';
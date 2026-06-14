<?php

use App\Http\Controllers\Buku\BukuController;
use App\Models\AnggotaNonPelajar;
use App\Models\AnggotaPelajar;
use App\Models\Buku;
use App\Models\SystemSetting;
use App\Models\User;
use App\Models\VisitorLog;

// ==========================================
// HALAMAN UTAMA
// ==========================================
Route::get('/', function () {

    $stats = [
        'buku'      => Buku::count(),
        'anggota'   => User::whereIn('role', ['pelajar', 'non_pelajar'])->count(),
        'kunjungan' => VisitorLog::whereDate('created_at', now()->toDateString())->count(),
        'tersedia'  => Buku::where('status', 'tersedia')->count(),
    ];

    $popularBooks = Buku::orderByDesc('total_dipinjam')
        ->take(5)
        ->get();

    try {
        $settings = SystemSetting::pluck('value_setting', 'key')->toArray();
    } catch (\Exception $e) {
        $settings = [];
    }

    if (empty($settings)) {
        $settings = [
            'nama_perpustakaan' => 'Perpustakaan Kota Sumbawa',
            'alamat'            => 'Jl. Raya Sumbawa',
            'email'             => 'perpustakaan@sumbawa.go.id',
        ];
    }

    return view('home', compact(
        'stats',
        'popularBooks',
        'settings'
    ));

})->name('home');

use Illuminate\Support\Facades\Route;

// ==========================================
// RAK BUKU PUBLIK
// ==========================================
Route::get('/rak-buku', [BukuController::class, 'index'])
    ->name('buku.index');

// ==========================================
// AREA ANGGOTA
// ==========================================
Route::middleware(['auth'])->group(function () {

    Route::get('/profil-saya', function () {
        return view('anggota.profile');
    })->name('profile.index');

    Route::get('/peminjaman-saya', function () {
        return view('transaksi.history');
    })->name('peminjaman.index');

});

// ==========================================
// DASHBOARD
// ==========================================
Route::middleware(['auth'])
    ->prefix('dashboard')
    ->group(function () {

        Route::get('/', function () {

            $stats = [
                'anggotaPelajar'    => class_exists(AnggotaPelajar::class)  ?AnggotaPelajar::count() : 0,
                'anggotaNonPelajar' => class_exists(AnggotaNonPelajar::class)  ?AnggotaNonPelajar::count() : 0,
                'buku'              => Buku::count(),
                'kunjunganHariIni'  => VisitorLog::whereDate('created_at', now()->toDateString())->count(),
                'stokTersedia'      => 0,
                'peminjamanAktif'   => 0,
                'terlambat'         => 0,
            ];

            $latestTransactions = [];

            $popularBooks = Buku::orderByDesc('total_dipinjam')
                ->take(5)
                ->get();

            $todayShifts = collect();

            return view('dashboard.index', compact(
                'stats',
                'latestTransactions',
                'popularBooks',
                'todayShifts'
            ));

        })->name('dashboard');

    });

// ==========================================
// FILE ROUTE LAINNYA
// ==========================================
require __DIR__ . '/auth.php';
require __DIR__ . '/anggota.php';
require __DIR__ . '/buku.php';
require __DIR__ . '/transaksi.php';
require __DIR__ . '/kunjungan.php';
require __DIR__ . '/laporan.php';
require __DIR__ . '/export.php';
require __DIR__ . '/pengaturan.php';

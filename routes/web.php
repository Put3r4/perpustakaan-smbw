<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Buku\BukuController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\HomeController;

// ==========================================
// HALAMAN UTAMA (PUBLIC)
// ==========================================
Route::get('/', HomeController::class)->name('home');

// ==========================================
// RUTE RAK BUKU PUBLIK
// ==========================================
Route::get('/rak-buku', [BukuController::class, 'rakBuku'])->name('rak.index');

// ==========================================
// RUTE KATEGORI BUKU PUBLIK
// ==========================================
Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');

// ==========================================
// RUTE ANGGOTA (PELAJAR & NON-PELAJAR)
// ==========================================
Route::middleware(['auth', 'roles:pelajar,non_pelajar'])->group(function () {
    Route::get('/profil-saya', [DashboardController::class, 'profilAnggota'])->name('profile.index');
    Route::get('/peminjaman-saya', [DashboardController::class, 'peminjamanSaya'])->name('peminjaman.index');
});

// ==========================================
// RUTE INTERNAL MANAGEMENT (PETUGAS / SUPERADMIN)
// ==========================================
Route::middleware(['auth', 'roles:superadmin,petugas'])->prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
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
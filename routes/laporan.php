<?php

use App\Http\Controllers\Laporan\LaporanBukuController;
use App\Http\Controllers\Laporan\LaporanDendaController;
use App\Http\Controllers\Laporan\LaporanKeanggotaanController;
use App\Http\Controllers\Laporan\LaporanPeminjamanController;
use App\Http\Controllers\Laporan\LaporanPengembalianController;
use Illuminate\Support\Facades\Route;

Route::prefix('laporan')->name('laporan.')->group(function (): void {
    Route::get('/peminjaman', [LaporanPeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('/pengembalian', [LaporanPengembalianController::class, 'index'])->name('pengembalian.index');
    Route::get('/buku', [LaporanBukuController::class, 'index'])->name('buku.index');
    Route::get('/denda', [LaporanDendaController::class, 'index'])->name('denda.index');
    Route::get('/keanggotaan', [LaporanKeanggotaanController::class, 'index'])->name('keanggotaan.index');
});

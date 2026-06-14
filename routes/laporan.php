<?php

use App\Http\Controllers\Laporan\LaporanBukuController;
use App\Http\Controllers\Laporan\LaporanDendaController;
use App\Http\Controllers\Laporan\LaporanKeanggotaanController;
use App\Http\Controllers\Laporan\LaporanPeminjamanController;
use App\Http\Controllers\Laporan\LaporanPengembalianController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('laporan')->name('laporan.')->group(function (): void {

    // ==========================================
    // LAPORAN BUKU
    // ==========================================
    Route::get('/buku', [LaporanBukuController::class, 'index'])->name('buku.index');
    Route::get('/buku/excel', [LaporanBukuController::class, 'exportExcel'])->name('buku.excel');
    Route::get('/buku/pdf', [LaporanBukuController::class, 'exportPdf'])->name('buku.pdf');

    // ==========================================
    // LAPORAN KEANGGOTAAN
    // ==========================================
    Route::get('/keanggotaan', [LaporanKeanggotaanController::class, 'index'])->name('keanggotaan.index');
    Route::get('/keanggotaan/excel', [LaporanKeanggotaanController::class, 'exportExcel'])->name('keanggotaan.excel');
    Route::get('/keanggotaan/pdf', [LaporanKeanggotaanController::class, 'exportPdf'])->name('keanggotaan.pdf');

    // ==========================================
    // LAPORAN PEMINJAMAN
    // ==========================================
    Route::get('/peminjaman', [LaporanPeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('/peminjaman/excel', [LaporanPeminjamanController::class, 'exportExcel'])->name('peminjaman.excel');
    Route::get('/peminjaman/pdf', [LaporanPeminjamanController::class, 'exportPdf'])->name('peminjaman.pdf');

    // ==========================================
    // LAPORAN PENGEMBALIAN
    // ==========================================
    Route::get('/pengembalian', [LaporanPengembalianController::class, 'index'])->name('pengembalian.index');
    Route::get('/pengembalian/excel', [LaporanPengembalianController::class, 'exportExcel'])->name('pengembalian.excel');
    Route::get('/pengembalian/pdf', [LaporanPengembalianController::class, 'exportPdf'])->name('pengembalian.pdf');

    // ==========================================
    // LAPORAN DENDA
    // ==========================================
    Route::get('/denda', [LaporanDendaController::class, 'index'])->name('denda.index');
    Route::get('/denda/excel', [LaporanDendaController::class, 'exportExcel'])->name('denda.excel');
    Route::get('/denda/pdf', [LaporanDendaController::class, 'exportPdf'])->name('denda.pdf');
});

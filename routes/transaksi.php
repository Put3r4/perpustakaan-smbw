<?php

use App\Http\Controllers\Transaksi\DendaController;
use App\Http\Controllers\Transaksi\PeminjamanController;
use App\Http\Controllers\Transaksi\PengembalianController;
use Illuminate\Support\Facades\Route;

Route::prefix('transaksi')->name('transaksi.')->group(function (): void {
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('/pengembalian', [PengembalianController::class, 'index'])->name('pengembalian.index');
    Route::get('/denda', [DendaController::class, 'index'])->name('denda.index');
});

<?php

use App\Http\Controllers\Transaksi\DendaController;
use App\Http\Controllers\Transaksi\PeminjamanController;
use App\Http\Controllers\Transaksi\PengembalianController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])
    ->prefix('dashboard/transaksi')
    ->name('transaksi.')
    ->group(function (): void {

        // ==========================================
        // PEMINJAMAN
        // ==========================================
        Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
        Route::get('/peminjaman/create', [PeminjamanController::class, 'create'])->name('peminjaman.create');
        Route::post('/peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');
        Route::get('/peminjaman/{type}/{id}', [PeminjamanController::class, 'show'])->name('peminjaman.show');
        Route::delete('/peminjaman/{type}/{id}', [PeminjamanController::class, 'destroy'])->name('peminjaman.destroy');

        // ==========================================
        // PENGEMBALIAN
        // ==========================================
        Route::get('/pengembalian', [PengembalianController::class, 'index'])->name('pengembalian.index');
        Route::get('/pengembalian/{type}/{id}', [PengembalianController::class, 'process'])->name('pengembalian.process');
        Route::post('/pengembalian/{type}/{id}', [PengembalianController::class, 'store'])->name('pengembalian.store');

        // ==========================================
        // DENDA
        // ==========================================
        Route::get('/denda', [DendaController::class, 'index'])->name('denda.index');
        Route::post('/denda/{type}/{id}/toggle', [DendaController::class, 'toggleStatus'])->name('denda.toggle');
    });

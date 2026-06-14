<?php

use App\Http\Controllers\Buku\BukuController;
use App\Http\Controllers\Buku\KategoriBukuController;
use App\Http\Controllers\Buku\RakBukuController;
use Illuminate\Support\Facades\Route;

Route::prefix('buku')->name('buku.')->group(function (): void {
    Route::get('/', [BukuController::class, 'index'])->name('index');
    Route::get('/kategori', [KategoriBukuController::class, 'index'])->name('kategori.index');
    Route::get('/rak', [RakBukuController::class, 'index'])->name('rak.index');
});

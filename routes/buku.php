<?php

use App\Http\Controllers\Buku\BukuController;
use App\Http\Controllers\Buku\KategoriBukuController;
use App\Http\Controllers\Buku\RakBukuController;
use Illuminate\Support\Facades\Route;

Route::prefix('buku')->name('buku.')->group(function (): void {

    Route::get('/', [BukuController::class, 'index'])->name('index');

    Route::get('/create', [BukuController::class, 'create'])->name('create');
    Route::post('/', [BukuController::class, 'store'])->name('store');

    Route::get('/{buku}', [BukuController::class, 'show'])->name('show');

    Route::get('/{buku}/edit', [BukuController::class, 'edit'])->name('edit');

    Route::put('/{buku}', [BukuController::class, 'update'])->name('update');
    Route::delete('/{buku}', [BukuController::class, 'destroy'])->name('destroy');

    Route::get('/kategori', [KategoriBukuController::class, 'index'])
        ->name('kategori.index');

    Route::get('/rak', [RakBukuController::class, 'index'])
        ->name('rak.index');
});

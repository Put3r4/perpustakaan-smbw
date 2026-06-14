<?php

use App\Http\Controllers\Anggota\AnggotaNonPelajarController;
use App\Http\Controllers\Anggota\AnggotaPelajarController;
use Illuminate\Support\Facades\Route;

Route::prefix('anggota')->name('anggota.')->group(function (): void {
    Route::get('/pelajar', [AnggotaPelajarController::class, 'index'])->name('pelajar.index');
    Route::get('/non-pelajar', [AnggotaNonPelajarController::class, 'index'])->name('non-pelajar.index');
});

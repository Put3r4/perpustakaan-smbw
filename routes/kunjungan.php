<?php

use App\Http\Controllers\Kunjungan\CheckInController;
use Illuminate\Support\Facades\Route;

Route::prefix('kunjungan')->name('kunjungan.')->group(function (): void {
    Route::get('/check-in', [CheckInController::class, 'index'])->name('check-in.index');
});

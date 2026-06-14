<?php

use App\Http\Controllers\Pengaturan\ProfileController;
use Illuminate\Support\Facades\Route;

Route::prefix('pengaturan')->name('pengaturan.')->group(function (): void {
    Route::get('/profil', [ProfileController::class, 'index'])->name('profil.index');
});

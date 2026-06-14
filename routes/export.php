<?php

use App\Http\Controllers\Export\ExcelController;
use App\Http\Controllers\Export\PdfController;
use Illuminate\Support\Facades\Route;

Route::prefix('export')->name('export.')->group(function (): void {
    Route::get('/pdf', PdfController::class)->name('pdf');
    Route::get('/excel', ExcelController::class)->name('excel');
});

<?php

use App\Http\Controllers\Api\BookCatalogController;
use App\Http\Controllers\Api\LibraryStatsController;
use Illuminate\Support\Facades\Route;

Route::get('/stats', LibraryStatsController::class)->name('api.stats');
Route::get('/books', [BookCatalogController::class, 'index'])->name('api.books.index');

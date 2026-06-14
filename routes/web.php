<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/dashboard', DashboardController::class)->name('dashboard');

require __DIR__.'/auth.php';
require __DIR__.'/anggota.php';
require __DIR__.'/buku.php';
require __DIR__.'/transaksi.php';
require __DIR__.'/kunjungan.php';
require __DIR__.'/laporan.php';
require __DIR__.'/export.php';
require __DIR__.'/pengaturan.php';

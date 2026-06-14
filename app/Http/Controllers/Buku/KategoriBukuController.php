<?php

namespace App\Http\Controllers\Buku;

use App\Http\Controllers\Concerns\RendersDashboardPage;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class KategoriBukuController extends Controller
{
    use RendersDashboardPage;

    public function index(): View
    {
        return $this->dashboardPage('Kategori Buku', 'Kelola klasifikasi dan subjek buku untuk memudahkan pencarian katalog.');
    }
}

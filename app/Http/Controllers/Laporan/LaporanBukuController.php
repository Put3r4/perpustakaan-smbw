<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Concerns\RendersDashboardPage;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class LaporanBukuController extends Controller
{
    use RendersDashboardPage;

    public function index(): View
    {
        return $this->dashboardPage('Laporan Buku', 'Analisis koleksi, stok tersedia, buku populer, dan buku rusak.');
    }
}

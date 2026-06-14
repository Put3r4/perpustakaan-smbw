<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Concerns\RendersDashboardPage;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class LaporanPengembalianController extends Controller
{
    use RendersDashboardPage;

    public function index(): View
    {
        return $this->dashboardPage('Laporan Pengembalian', 'Rekap pengembalian, keterlambatan, dan durasi pinjam.');
    }
}

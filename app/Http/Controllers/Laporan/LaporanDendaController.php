<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Concerns\RendersDashboardPage;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class LaporanDendaController extends Controller
{
    use RendersDashboardPage;

    public function index(): View
    {
        return $this->dashboardPage('Laporan Denda', 'Rekap denda belum lunas dan pembayaran denda.');
    }
}

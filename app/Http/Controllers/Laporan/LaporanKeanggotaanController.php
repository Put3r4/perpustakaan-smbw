<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Concerns\RendersDashboardPage;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class LaporanKeanggotaanController extends Controller
{
    use RendersDashboardPage;

    public function index(): View
    {
        return $this->dashboardPage('Laporan Keanggotaan', 'Rekap pertumbuhan anggota pelajar dan non pelajar.');
    }
}

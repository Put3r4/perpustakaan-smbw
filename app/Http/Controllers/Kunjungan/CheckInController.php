<?php

namespace App\Http\Controllers\Kunjungan;

use App\Http\Controllers\Concerns\RendersDashboardPage;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class CheckInController extends Controller
{
    use RendersDashboardPage;

    public function index(): View
    {
        return $this->dashboardPage('Check-In Pengunjung', 'Catat kunjungan harian anggota pelajar dan non pelajar.');
    }
}

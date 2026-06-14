<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Concerns\RendersDashboardPage;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class AnggotaNonPelajarController extends Controller
{
    use RendersDashboardPage;

    public function index(): View
    {
        return $this->dashboardPage('Anggota Non Pelajar', 'Kelola anggota umum, data pekerjaan, dan identitas kependudukan.');
    }
}

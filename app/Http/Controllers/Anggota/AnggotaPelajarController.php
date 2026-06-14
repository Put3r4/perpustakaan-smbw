<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Concerns\RendersDashboardPage;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class AnggotaPelajarController extends Controller
{
    use RendersDashboardPage;

    public function index(): View
    {
        return $this->dashboardPage('Anggota Pelajar', 'Kelola profil anggota kategori pelajar, nomor anggota, dan identitas sekolah.');
    }
}

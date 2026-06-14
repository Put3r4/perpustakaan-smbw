<?php

namespace App\Http\Controllers\Buku;

use App\Http\Controllers\Concerns\RendersDashboardPage;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class RakBukuController extends Controller
{
    use RendersDashboardPage;

    public function index(): View
    {
        return $this->dashboardPage('Rak Buku', 'Susun lokasi fisik koleksi agar petugas mudah menemukan eksemplar.');
    }
}

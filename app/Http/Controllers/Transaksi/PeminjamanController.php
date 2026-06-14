<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Concerns\RendersDashboardPage;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class PeminjamanController extends Controller
{
    use RendersDashboardPage;

    public function index(): View
    {
        return $this->dashboardPage('Peminjaman', 'Catat transaksi peminjaman buku pelajar dan non pelajar.');
    }
}

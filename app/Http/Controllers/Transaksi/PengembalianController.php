<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Concerns\RendersDashboardPage;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class PengembalianController extends Controller
{
    use RendersDashboardPage;

    public function index(): View
    {
        return $this->dashboardPage('Pengembalian', 'Proses pengembalian buku, status keterlambatan, dan pembaruan stok.');
    }
}

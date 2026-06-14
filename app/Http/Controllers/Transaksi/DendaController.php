<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Concerns\RendersDashboardPage;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class DendaController extends Controller
{
    use RendersDashboardPage;

    public function index(): View
    {
        return $this->dashboardPage('Denda', 'Pantau tagihan keterlambatan dan status pembayaran denda.');
    }
}

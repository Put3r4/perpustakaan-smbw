<?php

namespace App\Http\Controllers\Pengaturan;

use App\Http\Controllers\Concerns\RendersDashboardPage;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class ProfileController extends Controller
{
    use RendersDashboardPage;

    public function index(): View
    {
        return $this->dashboardPage('Profil', 'Kelola informasi akun petugas dan preferensi pengguna.');
    }
}

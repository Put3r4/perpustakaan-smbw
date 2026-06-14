<?php

namespace App\Http\Controllers;

use App\Models\AnggotaNonPelajar;
use App\Models\AnggotaPelajar;
use App\Models\Buku;
use App\Models\SystemSetting;
use App\Models\VisitorLog;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        return view('home', [
            'stats' => [
                'buku' => Buku::count(),
                'anggota' => AnggotaPelajar::count() + AnggotaNonPelajar::count(),
                'kunjungan' => VisitorLog::whereDate('checkin_at', today())->count(),
                'tersedia' => Buku::where('status', 'tersedia')->sum('stok_tersedia'),
            ],
            'popularBooks' => Buku::select('id', 'kode_buku', 'judul', 'pengarang', 'stok_tersedia', 'total_dilihat', 'total_dipinjam', 'status')
                ->orderByDesc('total_dilihat')
                ->orderByDesc('total_dipinjam')
                ->limit(6)
                ->get(),
            'latestBooks' => Buku::select('id', 'kode_buku', 'judul', 'pengarang', 'tahun_terbit', 'status')
                ->latest()
                ->limit(5)
                ->get(),
            'settings' => SystemSetting::pluck('value_setting', 'key_setting'),
        ]);
    }
}

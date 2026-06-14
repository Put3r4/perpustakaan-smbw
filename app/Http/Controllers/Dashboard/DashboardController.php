<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\AnggotaNonPelajar;
use App\Models\AnggotaPelajar;
use App\Models\Buku;
use App\Models\PetugasShift;
use App\Models\TransaksiNonPelajar;
use App\Models\TransaksiPelajar;
use App\Models\VisitorLog;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $latestStudentLoans = TransaksiPelajar::with(['anggota:id,nama_anggota', 'buku:id,judul'])
            ->select('id', 'kode_transaksi', 'no_anggota_p', 'buku_id', 'status', 'tgl_pinjam', 'created_at')
            ->latest()
            ->limit(5)
            ->get()
            ->map(fn (TransaksiPelajar $transaction): array => [
                'kode' => $transaction->kode_transaksi,
                'anggota' => $transaction->anggota?->nama_anggota ?? '-',
                'buku' => $transaction->buku?->judul ?? '-',
                'status' => $transaction->status,
                'tanggal' => $transaction->tgl_pinjam,
                'created_at' => $transaction->created_at,
            ]);

        $latestPublicLoans = TransaksiNonPelajar::with(['anggota:id,nama_anggota', 'buku:id,judul'])
            ->select('id', 'kode_transaksi', 'no_anggota_np', 'buku_id', 'status', 'tgl_pinjam', 'created_at')
            ->latest()
            ->limit(5)
            ->get()
            ->map(fn (TransaksiNonPelajar $transaction): array => [
                'kode' => $transaction->kode_transaksi,
                'anggota' => $transaction->anggota?->nama_anggota ?? '-',
                'buku' => $transaction->buku?->judul ?? '-',
                'status' => $transaction->status,
                'tanggal' => $transaction->tgl_pinjam,
                'created_at' => $transaction->created_at,
            ]);

        return view('dashboard.index', [
            'stats' => [
                'anggotaPelajar' => AnggotaPelajar::count(),
                'anggotaNonPelajar' => AnggotaNonPelajar::count(),
                'buku' => Buku::count(),
                'stokTersedia' => Buku::where('status', 'tersedia')->sum('stok_tersedia'),
                'peminjamanAktif' => TransaksiPelajar::where('status', 'dipinjam')->count()
                    + TransaksiNonPelajar::where('status', 'dipinjam')->count(),
                'terlambat' => TransaksiPelajar::where('status', 'terlambat')->count()
                    + TransaksiNonPelajar::where('status', 'terlambat')->count(),
                'kunjunganHariIni' => VisitorLog::whereDate('checkin_at', today())->count(),
            ],
            'popularBooks' => Buku::select('id', 'kode_buku', 'judul', 'stok_tersedia', 'total_dilihat', 'total_dipinjam', 'status')
                ->orderByDesc('total_dipinjam')
                ->orderByDesc('total_dilihat')
                ->limit(5)
                ->get(),
            'latestTransactions' => Collection::make()
                ->merge($latestStudentLoans)
                ->merge($latestPublicLoans)
                ->sortByDesc('created_at')
                ->take(6)
                ->values(),
            'todayShifts' => PetugasShift::with('petugas:id,nama_petugas,jabatan')
                ->select('id', 'petugas_id', 'tanggal', 'jam_mulai', 'jam_selesai')
                ->whereDate('tanggal', today())
                ->orderBy('jam_mulai')
                ->get(),
        ]);
    }
}

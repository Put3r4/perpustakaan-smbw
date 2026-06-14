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
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Dashboard utama untuk Petugas/Superadmin
     */
    public function index(): View
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

    /**
     * Halaman profil untuk anggota (pelajar & non-pelajar)
     */
    public function profilAnggota(): View
    {
        $user = Auth::user();
        
        // Ambil data anggota berdasarkan role
        $anggota = null;
        if ($user->role === 'pelajar') {
            $anggota = AnggotaPelajar::where('user_id', $user->id)->first();
        } elseif ($user->role === 'non_pelajar') {
            $anggota = AnggotaNonPelajar::where('user_id', $user->id)->first();
        }

        return view('anggota.profile', compact('user', 'anggota'));
    }

    /**
     * Halaman riwayat peminjaman untuk anggota (pelajar & non-pelajar)
     */
    public function peminjamanSaya(): View
    {
        $user = Auth::user();
        $peminjaman = collect();

        // Ambil data peminjaman berdasarkan role
        if ($user->role === 'pelajar') {
            $anggota = AnggotaPelajar::where('user_id', $user->id)->first();
            if ($anggota) {
                $peminjaman = TransaksiPelajar::with('buku:id,judul,pengarang')
                    ->where('no_anggota_p', $anggota->no_anggota)
                    ->orderBy('created_at', 'desc')
                    ->get();
            }
        } elseif ($user->role === 'non_pelajar') {
            $anggota = AnggotaNonPelajar::where('user_id', $user->id)->first();
            if ($anggota) {
                $peminjaman = TransaksiNonPelajar::with('buku:id,judul,pengarang')
                    ->where('no_anggota_np', $anggota->no_anggota)
                    ->orderBy('created_at', 'desc')
                    ->get();
            }
        }

        return view('transaksi.history', compact('peminjaman'));
    }
}

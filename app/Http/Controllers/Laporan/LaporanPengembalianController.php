<?php

namespace App\Http\Controllers\Laporan;

use App\Exports\PengembalianExport;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class LaporanPengembalianController extends Controller
{
    public function index()
    {
        $search = request('search');
        $jenis  = request('jenis');

        // Pelajar - status dikembalikan
        $pelajar = DB::table('transaksi_pelajar as tp')
            ->join('anggota_pelajar as ap', 'tp.no_anggota_p', '=', 'ap.id')
            ->join('buku as b', 'tp.buku_id', '=', 'b.id')
            ->select(
                'tp.kode_transaksi',
                'ap.no_anggota',
                'ap.nama_anggota',
                DB::raw("'Pelajar' as jenis_anggota"),
                'b.judul as judul_buku',
                'tp.tgl_pinjam',
                'tp.tgl_kembali',
                'tp.denda',
                'tp.status_denda'
            )
            ->where('tp.status', 'dikembalikan')
            ->when($search, fn($q) => $q->where(function ($q2) use ($search) {
                $q2->where('ap.nama_anggota', 'like', "%{$search}%")
                    ->orWhere('b.judul', 'like', "%{$search}%")
                    ->orWhere('tp.kode_transaksi', 'like', "%{$search}%");
            }));

        // Non Pelajar - status dikembalikan
        $nonPelajar = DB::table('transaksi_non_pelajar as tnp')
            ->join('anggota_non_pelajar as anp', 'tnp.no_anggota_np', '=', 'anp.id')
            ->join('buku as b', 'tnp.buku_id', '=', 'b.id')
            ->select(
                'tnp.kode_transaksi',
                'anp.no_anggota',
                'anp.nama_anggota',
                DB::raw("'Non Pelajar' as jenis_anggota"),
                'b.judul as judul_buku',
                'tnp.tgl_pinjam',
                'tnp.tgl_kembali',
                'tnp.denda',
                'tnp.status_denda'
            )
            ->where('tnp.status', 'dikembalikan')
            ->when($search, fn($q) => $q->where(function ($q2) use ($search) {
                $q2->where('anp.nama_anggota', 'like', "%{$search}%")
                    ->orWhere('b.judul', 'like', "%{$search}%")
                    ->orWhere('tnp.kode_transaksi', 'like', "%{$search}%");
            }));

        if ($jenis === 'pelajar') {
            $data = $pelajar->orderBy('tgl_kembali', 'desc')->paginate(15)->withQueryString();
        } elseif ($jenis === 'non_pelajar') {
            $data = $nonPelajar->orderBy('tgl_kembali', 'desc')->paginate(15)->withQueryString();
        } else {
            $data = $pelajar->union($nonPelajar)
                ->orderBy('tgl_kembali', 'desc')
                ->paginate(15)
                ->withQueryString();
        }

        return view('laporan.pengembalian.index', compact('data', 'search', 'jenis'));
    }

    public function exportExcel()
    {
        $filename = 'Laporan-Pengembalian-' . now()->format('Ymd-His') . '.xlsx';
        return Excel::download(new PengembalianExport(), $filename);
    }

    public function exportPdf()
    {
        $pelajar = DB::table('transaksi_pelajar as tp')
            ->join('anggota_pelajar as ap', 'tp.no_anggota_p', '=', 'ap.id')
            ->join('buku as b', 'tp.buku_id', '=', 'b.id')
            ->select(
                'tp.kode_transaksi',
                'ap.no_anggota',
                'ap.nama_anggota',
                DB::raw("'Pelajar' as jenis_anggota"),
                'b.judul as judul_buku',
                'tp.tgl_pinjam',
                'tp.tgl_kembali',
                'tp.denda',
                'tp.status_denda'
            )
            ->where('tp.status', 'dikembalikan');

        $data = DB::table('transaksi_non_pelajar as tnp')
            ->join('anggota_non_pelajar as anp', 'tnp.no_anggota_np', '=', 'anp.id')
            ->join('buku as b', 'tnp.buku_id', '=', 'b.id')
            ->select(
                'tnp.kode_transaksi',
                'anp.no_anggota',
                'anp.nama_anggota',
                DB::raw("'Non Pelajar' as jenis_anggota"),
                'b.judul as judul_buku',
                'tnp.tgl_pinjam',
                'tnp.tgl_kembali',
                'tnp.denda',
                'tnp.status_denda'
            )
            ->where('tnp.status', 'dikembalikan')
            ->union($pelajar)
            ->orderBy('tgl_kembali', 'desc')
            ->get();

        $pdf = Pdf::loadView('laporan.pdf.pengembalian', [
            'data'        => $data,
            'dicetak_pada' => now()->format('d/m/Y H:i'),
        ])->setPaper('a4', 'landscape');

        return $pdf->download('Laporan-Pengembalian-' . now()->format('Ymd-His') . '.pdf');
    }
}

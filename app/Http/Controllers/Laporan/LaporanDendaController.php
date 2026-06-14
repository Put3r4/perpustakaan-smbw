<?php

namespace App\Http\Controllers\Laporan;

use App\Exports\DendaExport;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class LaporanDendaController extends Controller
{
    public function index()
    {
        $search = request('search');
        $jenis  = request('jenis');
        $status_denda = request('status_denda');

        // Pelajar - memiliki denda > 0
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
                'tp.tgl_jatuh_tempo',
                'tp.tgl_kembali',
                'tp.denda',
                'tp.status_denda'
            )
            ->where('tp.denda', '>', 0)
            ->when($status_denda && in_array($status_denda, ['lunas', 'belum_lunas']), fn($q) => $q->where('tp.status_denda', $status_denda))
            ->when($search, fn($q) => $q->where(function ($q2) use ($search) {
                $q2->where('ap.nama_anggota', 'like', "%{$search}%")
                    ->orWhere('b.judul', 'like', "%{$search}%")
                    ->orWhere('tp.kode_transaksi', 'like', "%{$search}%");
            }));

        // Non Pelajar - memiliki denda > 0
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
                'tnp.tgl_jatuh_tempo',
                'tnp.tgl_kembali',
                'tnp.denda',
                'tnp.status_denda'
            )
            ->where('tnp.denda', '>', 0)
            ->when($status_denda && in_array($status_denda, ['lunas', 'belum_lunas']), fn($q) => $q->where('tnp.status_denda', $status_denda))
            ->when($search, fn($q) => $q->where(function ($q2) use ($search) {
                $q2->where('anp.nama_anggota', 'like', "%{$search}%")
                    ->orWhere('b.judul', 'like', "%{$search}%")
                    ->orWhere('tnp.kode_transaksi', 'like', "%{$search}%");
            }));

        if ($jenis === 'pelajar') {
            $data = $pelajar->orderBy('denda', 'desc')->paginate(15)->withQueryString();
        } elseif ($jenis === 'non_pelajar') {
            $data = $nonPelajar->orderBy('denda', 'desc')->paginate(15)->withQueryString();
        } else {
            $data = $pelajar->union($nonPelajar)
                ->orderBy('denda', 'desc')
                ->paginate(15)
                ->withQueryString();
        }

        return view('laporan.denda.index', compact('data', 'search', 'jenis', 'status_denda'));
    }

    public function exportExcel()
    {
        $filename = 'Laporan-Denda-' . now()->format('Ymd-His') . '.xlsx';
        return Excel::download(new DendaExport(), $filename);
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
                'tp.tgl_jatuh_tempo',
                'tp.tgl_kembali',
                'tp.denda',
                'tp.status_denda'
            )
            ->where('tp.denda', '>', 0);

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
                'tnp.tgl_jatuh_tempo',
                'tnp.tgl_kembali',
                'tnp.denda',
                'tnp.status_denda'
            )
            ->where('tnp.denda', '>', 0)
            ->union($pelajar)
            ->orderBy('denda', 'desc')
            ->get();

        $pdf = Pdf::loadView('laporan.pdf.denda', [
            'data'        => $data,
            'dicetak_pada' => now()->format('d/m/Y H:i'),
        ])->setPaper('a4', 'landscape');

        return $pdf->download('Laporan-Denda-' . now()->format('Ymd-His') . '.pdf');
    }
}

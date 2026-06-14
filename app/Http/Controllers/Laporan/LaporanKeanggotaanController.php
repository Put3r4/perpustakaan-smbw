<?php

namespace App\Http\Controllers\Laporan;

use App\Exports\KeanggotaanExport;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class LaporanKeanggotaanController extends Controller
{
    public function index()
    {
        $search = request('search');
        $jenis  = request('jenis'); // 'pelajar' atau 'non_pelajar'

        // Pelajar
        $pelajar = DB::table('anggota_pelajar')
            ->select(
                'no_anggota',
                'nim_nis as identitas',
                'nama_anggota',
                DB::raw("'Pelajar' as jenis"),
                'asal_sekolah as instansi',
                'no_telp1',
                'tgl_daftar'
            )
            ->when($search, fn($q) => $q->where(function ($q2) use ($search) {
                $q2->where('nama_anggota', 'like', "%{$search}%")
                    ->orWhere('no_anggota', 'like', "%{$search}%");
            }));

        // Non Pelajar
        $nonPelajar = DB::table('anggota_non_pelajar')
            ->select(
                'no_anggota',
                'nik as identitas',
                'nama_anggota',
                DB::raw("'Non Pelajar' as jenis"),
                'pekerjaan as instansi',
                'no_telp1',
                'tgl_daftar'
            )
            ->when($search, fn($q) => $q->where(function ($q2) use ($search) {
                $q2->where('nama_anggota', 'like', "%{$search}%")
                    ->orWhere('no_anggota', 'like', "%{$search}%");
            }));

        // Filter jenis anggota
        if ($jenis === 'pelajar') {
            $anggota = $pelajar->orderBy('tgl_daftar', 'desc')->paginate(15)->withQueryString();
        } elseif ($jenis === 'non_pelajar') {
            $anggota = $nonPelajar->orderBy('tgl_daftar', 'desc')->paginate(15)->withQueryString();
        } else {
            $anggota = $pelajar->union($nonPelajar)
                ->orderBy('tgl_daftar', 'desc')
                ->paginate(15)
                ->withQueryString();
        }

        return view('laporan.keanggotaan.index', compact('anggota', 'search', 'jenis'));
    }

    public function exportExcel()
    {
        $filename = 'Laporan-Keanggotaan-' . now()->format('Ymd-His') . '.xlsx';
        return Excel::download(new KeanggotaanExport(), $filename);
    }

    public function exportPdf()
    {
        $pelajar = DB::table('anggota_pelajar')
            ->select(
                'no_anggota',
                'nim_nis as identitas',
                'nama_anggota',
                DB::raw("'Pelajar' as jenis"),
                'asal_sekolah as instansi',
                'no_telp1',
                'tgl_daftar'
            );

        $anggota = DB::table('anggota_non_pelajar')
            ->select(
                'no_anggota',
                'nik as identitas',
                'nama_anggota',
                DB::raw("'Non Pelajar' as jenis"),
                'pekerjaan as instansi',
                'no_telp1',
                'tgl_daftar'
            )
            ->union($pelajar)
            ->orderBy('tgl_daftar', 'desc')
            ->get();

        $pdf = Pdf::loadView('laporan.pdf.keanggotaan', [
            'anggota'     => $anggota,
            'dicetak_pada' => now()->format('d/m/Y H:i'),
        ])->setPaper('a4', 'landscape');

        return $pdf->download('Laporan-Keanggotaan-' . now()->format('Ymd-His') . '.pdf');
    }
}

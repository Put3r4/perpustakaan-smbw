<?php

namespace App\Http\Controllers\Laporan;

use App\Exports\BukuExport;
use App\Http\Controllers\Controller;
use App\Models\Buku;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class LaporanBukuController extends Controller
{
    public function index()
    {
        $query = Buku::with('rak')
            ->select(
                'id', 'kode_buku', 'no_udc', 'judul',
                'pengarang', 'penerbit', 'tahun_terbit',
                'jumlah_eksemplar', 'stok_tersedia', 'status', 'rak_id'
            );

        // Filter pencarian
        if (request('search')) {
            $search = request('search');
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                    ->orWhere('pengarang', 'like', "%{$search}%")
                    ->orWhere('kode_buku', 'like', "%{$search}%");
            });
        }

        // Filter status
        if (request('status') && in_array(request('status'), ['tersedia', 'habis', 'rusak'])) {
            $query->where('status', request('status'));
        }

        $buku = $query->orderBy('judul')->paginate(15)->withQueryString();

        return view('laporan.buku.index', compact('buku'));
    }

    public function exportExcel()
    {
        $filename = 'Laporan-Buku-' . now()->format('Ymd-His') . '.xlsx';
        return Excel::download(new BukuExport(), $filename);
    }

    public function exportPdf()
    {
        $buku = Buku::with('rak')
            ->orderBy('judul')
            ->get();

        $pdf = Pdf::loadView('laporan.pdf.buku', [
            'buku'        => $buku,
            'tanggal'     => now()->translatedFormat('d F Y'),
            'dicetak_pada' => now()->format('d/m/Y H:i'),
        ])->setPaper('a4', 'landscape');

        return $pdf->download('Laporan-Buku-' . now()->format('Ymd-His') . '.pdf');
    }
}

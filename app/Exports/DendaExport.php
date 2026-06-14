<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DendaExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    public function collection()
    {
        // Denda dari transaksi pelajar
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

        // Denda dari transaksi non pelajar
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
            ->where('tnp.denda', '>', 0);

        return $pelajar->union($nonPelajar)
            ->orderBy('denda', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Kode Transaksi',
            'No. Anggota',
            'Nama Anggota',
            'Jenis Anggota',
            'Judul Buku',
            'Tgl. Pinjam',
            'Tgl. Jatuh Tempo',
            'Tgl. Kembali',
            'Nominal Denda (Rp)',
            'Status Denda',
        ];
    }

    public function map($row): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $row->kode_transaksi,
            $row->no_anggota,
            $row->nama_anggota,
            $row->jenis_anggota,
            $row->judul_buku,
            $row->tgl_pinjam,
            $row->tgl_jatuh_tempo,
            $row->tgl_kembali ?? '-',
            number_format($row->denda, 0, ',', '.'),
            $row->status_denda === 'lunas' ? 'Lunas' : 'Belum Lunas',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font'      => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill'      => ['fillType' => 'solid', 'startColor' => ['rgb' => '1E3A5F']],
                'alignment' => ['horizontal' => 'center'],
            ],
        ];
    }
}

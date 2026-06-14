<?php

namespace App\Exports;

use App\Models\Buku;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BukuExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    public function collection()
    {
        return Buku::with('rak')
            ->select(
                'id', 'kode_buku', 'no_udc', 'no_reg', 'judul',
                'pengarang', 'penerbit', 'tahun_terbit', 'kota_terbit',
                'bahasa', 'isbn', 'jumlah_eksemplar', 'stok_tersedia',
                'status', 'rak_id'
            )
            ->orderBy('judul')
            ->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Kode Buku',
            'No. UDC',
            'No. Reg',
            'Judul Buku',
            'Pengarang',
            'Penerbit',
            'Tahun Terbit',
            'Kota Terbit',
            'Bahasa',
            'ISBN',
            'Jumlah Eksemplar',
            'Stok Tersedia',
            'Lokasi Rak',
            'Status',
        ];
    }

    public function map($buku): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $buku->kode_buku,
            $buku->no_udc ?? '-',
            $buku->no_reg ?? '-',
            $buku->judul,
            $buku->pengarang,
            $buku->penerbit,
            $buku->tahun_terbit,
            $buku->kota_terbit,
            $buku->bahasa,
            $buku->isbn ?? '-',
            $buku->jumlah_eksemplar,
            $buku->stok_tersedia,
            $buku->rak ? $buku->rak->nama_rak : '-',
            ucfirst($buku->status),
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

<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class KeanggotaanExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    public function collection()
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

        $nonPelajar = DB::table('anggota_non_pelajar')
            ->select(
                'no_anggota',
                'nik as identitas',
                'nama_anggota',
                DB::raw("'Non Pelajar' as jenis"),
                'pekerjaan as instansi',
                'no_telp1',
                'tgl_daftar'
            );

        return $pelajar->union($nonPelajar)
            ->orderBy('tgl_daftar', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'No. Anggota',
            'NIM/NIS / NIK',
            'Nama Anggota',
            'Jenis Anggota',
            'Asal Sekolah / Pekerjaan',
            'No. Telepon',
            'Tanggal Daftar',
        ];
    }

    public function map($row): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $row->no_anggota,
            $row->identitas,
            $row->nama_anggota,
            $row->jenis,
            $row->instansi ?? '-',
            $row->no_telp1,
            $row->tgl_daftar,
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

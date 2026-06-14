<?php

namespace App\Exports;

use App\Models\VisitorLog;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class VisitorStatisticExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    public function collection()
    {
        return VisitorLog::with('member')
            ->orderBy('checkin_at', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Anggota',
            'Tipe Anggota',
            'No. Anggota',
            'Check-In',
            'Check-Out',
            'Durasi Kunjungan (Menit)'
        ];
    }

    public function map($row): array
    {
        static $no = 0;
        $no++;

        $tipe = $row->member_type === \App\Models\AnggotaPelajar::class ? 'Pelajar' : 'Non Pelajar';
        $nama = $row->member?->nama_anggota ?? 'Tidak Ditemukan';
        $noAnggota = $row->member?->no_anggota ?? '-';

        return [
            $no,
            $nama,
            $tipe,
            $noAnggota,
            $row->checkin_at ? \Carbon\Carbon::parse($row->checkin_at)->format('d/m/Y H:i') : '-',
            $row->checkout_at ? \Carbon\Carbon::parse($row->checkout_at)->format('d/m/Y H:i') : '-',
            $row->durasi_kunjungan ?? '-',
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

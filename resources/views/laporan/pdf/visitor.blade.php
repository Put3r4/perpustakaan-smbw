<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Statistik Pengunjung - Perpustakaan Kota Sumbawa</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 9px; color: #1e293b; }

        /* KOP SURAT */
        .kop { display: flex; align-items: center; border-bottom: 3px solid #1E3A5F; padding-bottom: 10px; margin-bottom: 12px; }
        .kop-logo { width: 55px; height: 55px; background: #1E3A5F; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-right: 14px; flex-shrink: 0; }
        .kop-logo span { color: #ffffff; font-size: 18px; font-weight: 900; }
        .kop-text h1 { font-size: 14px; font-weight: 900; color: #1E3A5F; text-transform: uppercase; letter-spacing: 0.5px; }
        .kop-text p { font-size: 8px; color: #475569; margin-top: 2px; }
        .kop-text .judul-laporan { font-size: 11px; font-weight: 700; color: #0f172a; margin-top: 4px; }

        /* INFO CETAK */
        .info-cetak { display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 8px; color: #64748b; }

        /* TABEL */
        table { width: 100%; border-collapse: collapse; margin-top: 6px; }
        thead th { background: #1E3A5F; color: #ffffff; padding: 6px 7px; text-align: left; font-size: 8px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.3px; }
        tbody tr:nth-child(even) { background: #f8fafc; }
        tbody tr:nth-child(odd) { background: #ffffff; }
        tbody td { padding: 5px 7px; border-bottom: 1px solid #e2e8f0; font-size: 8px; color: #334155; vertical-align: top; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .badge-pelajar    { background: #d1fae5; color: #065f46; padding: 1px 5px; border-radius: 4px; font-size: 7px; font-weight: 700; }
        .badge-nonpelajar { background: #e0f2fe; color: #0369a1; padding: 1px 5px; border-radius: 4px; font-size: 7px; font-weight: 700; }

        /* FOOTER */
        .footer { margin-top: 14px; text-align: right; font-size: 7px; color: #94a3b8; }
    </style>
</head>
<body>

    {{-- KOP SURAT --}}
    <div class="kop">
        <div class="kop-logo"><span>PK</span></div>
        <div class="kop-text">
            <h1>Perpustakaan Kota Sumbawa</h1>
            <p>Sistem Informasi Manajemen Perpustakaan</p>
            <p class="judul-laporan">Laporan Statistik Kunjungan Pengunjung</p>
        </div>
    </div>

    {{-- INFO CETAK --}}
    <div class="info-cetak">
        <span>Total Kunjungan: <strong>{{ $logs->count() }}</strong> kali</span>
        <span>Tanggal Cetak: <strong>{{ $dicetak_pada }}</strong></span>
    </div>

    {{-- TABEL --}}
    <table>
        <thead>
            <tr>
                <th style="width:5%">No</th>
                <th style="width:25%">Nama Anggota</th>
                <th style="width:15%">Tipe Anggota</th>
                <th style="width:15%">No. Anggota</th>
                <th style="width:18%">Check-In</th>
                <th style="width:12%">Check-Out</th>
                <th style="width:10%" class="text-center">Durasi (Mnt)</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($logs as $no => $item)
                <tr>
                    <td class="text-center">{{ $no + 1 }}</td>
                    <td>{{ $item->member?->nama_anggota ?? 'Tidak Ditemukan' }}</td>
                    <td>
                        @if ($item->member_type === 'App\Models\AnggotaPelajar')
                            <span class="badge-pelajar">Pelajar</span>
                        @else
                            <span class="badge-nonpelajar">Non Pelajar</span>
                        @endif
                    </td>
                    <td>{{ $item->member?->no_anggota ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->checkin_at)->format('d/m/Y H:i') }}</td>
                    <td>{{ $item->checkout_at ? \Carbon\Carbon::parse($item->checkout_at)->format('d/m/Y H:i') : '-' }}</td>
                    <td class="text-center">{{ $item->durasi_kunjungan ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center" style="padding: 15px; color: #94a3b8;">
                        Tidak ada data kunjungan.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dokumen ini dicetak otomatis oleh Sistem Informasi Perpustakaan Kota Sumbawa &mdash; {{ $dicetak_pada }}
    </div>

</body>
</html>

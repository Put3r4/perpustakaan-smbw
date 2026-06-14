<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Buku - Perpustakaan Kota Sumbawa</title>
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
        .badge-tersedia { background: #d1fae5; color: #065f46; padding: 1px 5px; border-radius: 4px; font-size: 7px; font-weight: 700; }
        .badge-habis    { background: #fef3c7; color: #92400e; padding: 1px 5px; border-radius: 4px; font-size: 7px; font-weight: 700; }
        .badge-rusak    { background: #fee2e2; color: #991b1b; padding: 1px 5px; border-radius: 4px; font-size: 7px; font-weight: 700; }

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
            <p class="judul-laporan">Laporan Data Buku Koleksi Perpustakaan</p>
        </div>
    </div>

    {{-- INFO CETAK --}}
    <div class="info-cetak">
        <span>Total Data: <strong>{{ $buku->count() }}</strong> buku</span>
        <span>Tanggal Cetak: <strong>{{ $dicetak_pada }}</strong></span>
    </div>

    {{-- TABEL --}}
    <table>
        <thead>
            <tr>
                <th style="width:3%">No</th>
                <th style="width:9%">Kode Buku</th>
                <th style="width:22%">Judul Buku</th>
                <th style="width:14%">Pengarang</th>
                <th style="width:13%">Penerbit</th>
                <th style="width:5%" class="text-center">Tahun</th>
                <th style="width:6%" class="text-center">Eks</th>
                <th style="width:5%" class="text-center">Stok</th>
                <th style="width:13%">Lokasi Rak</th>
                <th style="width:7%" class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($buku as $no => $item)
                <tr>
                    <td class="text-center">{{ $no + 1 }}</td>
                    <td style="font-family: monospace; font-size:7px;">{{ $item->kode_buku }}</td>
                    <td>{{ $item->judul }}</td>
                    <td>{{ $item->pengarang }}</td>
                    <td>{{ $item->penerbit }}</td>
                    <td class="text-center">{{ $item->tahun_terbit }}</td>
                    <td class="text-center">{{ $item->jumlah_eksemplar }}</td>
                    <td class="text-center"><strong>{{ $item->stok_tersedia }}</strong></td>
                    <td>{{ $item->rak ? $item->rak->nama_rak : '-' }}</td>
                    <td class="text-center">
                        @if ($item->status === 'tersedia')
                            <span class="badge-tersedia">Tersedia</span>
                        @elseif ($item->status === 'habis')
                            <span class="badge-habis">Habis</span>
                        @else
                            <span class="badge-rusak">Rusak</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="text-center" style="padding: 15px; color: #94a3b8;">
                        Tidak ada data buku.
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

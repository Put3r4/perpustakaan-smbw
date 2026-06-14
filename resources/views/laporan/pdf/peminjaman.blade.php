<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Peminjaman - Perpustakaan Kota Sumbawa</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 9px; color: #1e293b; }
        .kop { display: flex; align-items: center; border-bottom: 3px solid #1E3A5F; padding-bottom: 10px; margin-bottom: 12px; }
        .kop-logo { width: 55px; height: 55px; background: #1E3A5F; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-right: 14px; flex-shrink: 0; }
        .kop-logo span { color: #ffffff; font-size: 18px; font-weight: 900; }
        .kop-text h1 { font-size: 14px; font-weight: 900; color: #1E3A5F; text-transform: uppercase; letter-spacing: 0.5px; }
        .kop-text p { font-size: 8px; color: #475569; margin-top: 2px; }
        .kop-text .judul-laporan { font-size: 11px; font-weight: 700; color: #0f172a; margin-top: 4px; }
        .info-cetak { display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 8px; color: #64748b; }
        table { width: 100%; border-collapse: collapse; margin-top: 6px; }
        thead th { background: #1E3A5F; color: #ffffff; padding: 6px 7px; text-align: left; font-size: 8px; font-weight: 700; text-transform: uppercase; }
        tbody tr:nth-child(even) { background: #f8fafc; }
        tbody tr:nth-child(odd)  { background: #ffffff; }
        tbody td { padding: 5px 7px; border-bottom: 1px solid #e2e8f0; font-size: 8px; color: #334155; vertical-align: top; }
        .text-center { text-align: center; }
        .badge-pelajar  { background: #dbeafe; color: #1e40af; padding: 1px 4px; border-radius: 3px; font-size: 7px; font-weight: 700; }
        .badge-nonpelajar { background: #ede9fe; color: #5b21b6; padding: 1px 4px; border-radius: 3px; font-size: 7px; font-weight: 700; }
        .badge-dipinjam { background: #fef3c7; color: #92400e; padding: 1px 4px; border-radius: 3px; font-size: 7px; font-weight: 700; }
        .badge-terlambat { background: #fee2e2; color: #991b1b; padding: 1px 4px; border-radius: 3px; font-size: 7px; font-weight: 700; }
        .terlambat-td { color: #dc2626; font-weight: 700; }
        .footer { margin-top: 14px; text-align: right; font-size: 7px; color: #94a3b8; }
    </style>
</head>
<body>

    <div class="kop">
        <div class="kop-logo"><span>PK</span></div>
        <div class="kop-text">
            <h1>Perpustakaan Kota Sumbawa</h1>
            <p>Sistem Informasi Manajemen Perpustakaan</p>
            <p class="judul-laporan">Laporan Peminjaman Buku (Aktif)</p>
        </div>
    </div>

    <div class="info-cetak">
        <span>Total Peminjaman Aktif: <strong>{{ $data->count() }}</strong> transaksi</span>
        <span>Tanggal Cetak: <strong>{{ $dicetak_pada }}</strong></span>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width:3%">No</th>
                <th style="width:12%">Kode Transaksi</th>
                <th style="width:10%">No. Anggota</th>
                <th style="width:18%">Nama Anggota</th>
                <th style="width:8%" class="text-center">Jenis</th>
                <th style="width:24%">Judul Buku</th>
                <th style="width:8%">Tgl. Pinjam</th>
                <th style="width:9%">Tgl. Jatuh Tempo</th>
                <th style="width:8%" class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data as $no => $item)
                <tr>
                    <td class="text-center">{{ $no + 1 }}</td>
                    <td style="font-family:monospace; font-size:7px;">{{ $item->kode_transaksi }}</td>
                    <td style="font-family:monospace; font-size:7px;">{{ $item->no_anggota }}</td>
                    <td>{{ $item->nama_anggota }}</td>
                    <td class="text-center">
                        @if ($item->jenis_anggota === 'Pelajar')
                            <span class="badge-pelajar">Pelajar</span>
                        @else
                            <span class="badge-nonpelajar">Non Pelajar</span>
                        @endif
                    </td>
                    <td>{{ $item->judul_buku }}</td>
                    <td>{{ $item->tgl_pinjam ? \Carbon\Carbon::parse($item->tgl_pinjam)->format('d/m/Y') : '-' }}</td>
                    <td class="{{ $item->status === 'terlambat' ? 'terlambat-td' : '' }}">
                        {{ $item->tgl_jatuh_tempo ? \Carbon\Carbon::parse($item->tgl_jatuh_tempo)->format('d/m/Y') : '-' }}
                    </td>
                    <td class="text-center">
                        @if ($item->status === 'dipinjam')
                            <span class="badge-dipinjam">Dipinjam</span>
                        @else
                            <span class="badge-terlambat">Terlambat</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center" style="padding:15px; color:#94a3b8;">
                        Tidak ada data peminjaman aktif.
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

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keanggotaan - Perpustakaan Kota Sumbawa</title>
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
        .badge-pelajar  { background: #dbeafe; color: #1e40af; padding: 1px 5px; border-radius: 4px; font-size: 7px; font-weight: 700; }
        .badge-nonpelajar { background: #ede9fe; color: #5b21b6; padding: 1px 5px; border-radius: 4px; font-size: 7px; font-weight: 700; }
        .footer { margin-top: 14px; text-align: right; font-size: 7px; color: #94a3b8; }
    </style>
</head>
<body>

    <div class="kop">
        <div class="kop-logo"><span>PK</span></div>
        <div class="kop-text">
            <h1>Perpustakaan Kota Sumbawa</h1>
            <p>Sistem Informasi Manajemen Perpustakaan</p>
            <p class="judul-laporan">Laporan Data Keanggotaan Perpustakaan</p>
        </div>
    </div>

    <div class="info-cetak">
        <span>Total Anggota: <strong>{{ $anggota->count() }}</strong> orang</span>
        <span>Tanggal Cetak: <strong>{{ $dicetak_pada }}</strong></span>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width:3%">No</th>
                <th style="width:12%">No. Anggota</th>
                <th style="width:14%">NIM/NIS / NIK</th>
                <th style="width:20%">Nama Anggota</th>
                <th style="width:9%" class="text-center">Jenis</th>
                <th style="width:22%">Asal Sekolah / Pekerjaan</th>
                <th style="width:11%">No. Telepon</th>
                <th style="width:9%">Tgl. Daftar</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($anggota as $no => $item)
                <tr>
                    <td class="text-center">{{ $no + 1 }}</td>
                    <td style="font-family: monospace; font-size:7px;">{{ $item->no_anggota }}</td>
                    <td style="font-family: monospace; font-size:7px;">{{ $item->identitas }}</td>
                    <td>{{ $item->nama_anggota }}</td>
                    <td class="text-center">
                        @if ($item->jenis === 'Pelajar')
                            <span class="badge-pelajar">Pelajar</span>
                        @else
                            <span class="badge-nonpelajar">Non Pelajar</span>
                        @endif
                    </td>
                    <td>{{ $item->instansi ?? '-' }}</td>
                    <td>{{ $item->no_telp1 }}</td>
                    <td>{{ $item->tgl_daftar ? \Carbon\Carbon::parse($item->tgl_daftar)->format('d/m/Y') : '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center" style="padding:15px; color:#94a3b8;">
                        Tidak ada data anggota.
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

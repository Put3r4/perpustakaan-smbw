<x-layouts.dashboard title="Detail Anggota Pelajar">

<div class="max-w-4xl mx-auto bg-white rounded-xl border border-slate-200 shadow-sm">

    <div class="border-b border-slate-200 px-6 py-4 flex items-center justify-between">
        <div>
            <h2 class="text-lg font-semibold text-slate-800">{{ $anggota->nama_anggota }}</h2>
            <p class="text-sm text-slate-500">No. Anggota: {{ $anggota->no_anggota }}</p>
        </div>
        <a href="{{ route('anggota.pelajar.index') }}"
           class="px-4 py-2 rounded-lg border border-slate-300 text-sm">
            Kembali
        </a>
    </div>

    <dl class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
        <div><dt class="text-slate-500">NIM/NIS</dt><dd class="font-medium">{{ $anggota->nim_nis }}</dd></div>
        <div><dt class="text-slate-500">Asal Sekolah</dt><dd class="font-medium">{{ $anggota->asal_sekolah }}</dd></div>
        <div><dt class="text-slate-500">Tanggal Lahir</dt><dd class="font-medium">{{ optional($anggota->tanggal_lahir)->format('d/m/Y') ?? '-' }}</dd></div>
        <div><dt class="text-slate-500">Tanggal Daftar</dt><dd class="font-medium">{{ optional($anggota->tgl_daftar)->format('d/m/Y') }}</dd></div>
        <div><dt class="text-slate-500">Email</dt><dd class="font-medium">{{ $anggota->user?->email ?? '-' }}</dd></div>
        <div><dt class="text-slate-500">Telepon 1</dt><dd class="font-medium">{{ $anggota->no_telp1 }}</dd></div>
        <div><dt class="text-slate-500">Telepon 2</dt><dd class="font-medium">{{ $anggota->no_telp2 ?? '-' }}</dd></div>
        <div><dt class="text-slate-500">Kode Pos</dt><dd class="font-medium">{{ $anggota->kode_pos ?? '-' }}</dd></div>
        <div class="md:col-span-2"><dt class="text-slate-500">Alamat</dt><dd class="font-medium">{{ $anggota->alamat }}</dd></div>
        <div><dt class="text-slate-500">Nama Orang Tua</dt><dd class="font-medium">{{ $anggota->nama_ortu }}</dd></div>
        <div><dt class="text-slate-500">Telepon Orang Tua</dt><dd class="font-medium">{{ $anggota->no_telp_ortu }}</dd></div>
        <div class="md:col-span-2"><dt class="text-slate-500">Alamat Orang Tua</dt><dd class="font-medium">{{ $anggota->alamat_ortu }}</dd></div>
    </dl>

    <div class="border-t px-6 py-4">
        <a href="{{ route('anggota.pelajar.edit', $anggota) }}"
           class="inline-block px-4 py-2 rounded-lg bg-yellow-500 text-white text-sm">
            Edit Data
        </a>
    </div>

</div>

</x-layouts.dashboard>

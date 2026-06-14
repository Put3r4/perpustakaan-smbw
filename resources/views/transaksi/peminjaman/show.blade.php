<x-layouts.dashboard title="Detail Peminjaman">

    <div class="mb-4 flex items-center gap-2 text-sm text-slate-500">
        <a href="{{ route('transaksi.peminjaman.index') }}" class="hover:text-emerald-700">Peminjaman</a>
        <span>/</span>
        <span class="text-slate-700">Detail Transaksi</span>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

        {{-- INFORMASI TRANSAKSI --}}
        <div class="lg:col-span-2 space-y-5">
            <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
                <div class="mb-4 flex items-start justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Kode Transaksi</p>
                        <h2 class="mt-1 font-mono text-xl font-bold text-slate-900">{{ $transaksi->kode_transaksi }}</h2>
                    </div>
                    <div>
                        @if ($transaksi->status === 'dipinjam')
                            <span class="rounded-full bg-blue-100 px-3 py-1 text-sm font-semibold text-blue-700">Dipinjam</span>
                        @elseif ($transaksi->status === 'terlambat')
                            <span class="rounded-full bg-red-100 px-3 py-1 text-sm font-semibold text-red-700">Terlambat</span>
                        @else
                            <span class="rounded-full bg-emerald-100 px-3 py-1 text-sm font-semibold text-emerald-700">Dikembalikan</span>
                        @endif
                    </div>
                </div>

                <dl class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <dt class="text-slate-500">Tanggal Pinjam</dt>
                        <dd class="mt-0.5 font-medium">{{ \Carbon\Carbon::parse($transaksi->tgl_pinjam)->format('d F Y') }}</dd>
                    </div>
                    <div>
                        <dt class="text-slate-500">Jatuh Tempo</dt>
                        <dd class="mt-0.5 font-medium {{ now()->toDateString() > $transaksi->tgl_jatuh_tempo && $transaksi->status !== 'dikembalikan' ? 'text-red-600' : '' }}">
                            {{ \Carbon\Carbon::parse($transaksi->tgl_jatuh_tempo)->format('d F Y') }}
                        </dd>
                    </div>
                    @if ($transaksi->tgl_kembali)
                        <div>
                            <dt class="text-slate-500">Tanggal Kembali</dt>
                            <dd class="mt-0.5 font-medium">{{ \Carbon\Carbon::parse($transaksi->tgl_kembali)->format('d F Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-slate-500">Denda</dt>
                            <dd class="mt-0.5 font-medium {{ $transaksi->denda > 0 ? 'text-red-600' : 'text-emerald-600' }}">
                                Rp {{ number_format($transaksi->denda, 0, ',', '.') }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-slate-500">Status Pembayaran Denda</dt>
                            <dd class="mt-0.5">
                                @if ($transaksi->status_denda === 'lunas')
                                    <span class="rounded-full bg-emerald-100 px-2 py-0.5 text-xs font-medium text-emerald-700">Lunas</span>
                                @else
                                    <span class="rounded-full bg-orange-100 px-2 py-0.5 text-xs font-medium text-orange-700">Belum Lunas</span>
                                @endif
                            </dd>
                        </div>
                    @endif
                </dl>
            </div>
        </div>

        {{-- SIDEBAR: BUKU & ANGGOTA --}}
        <div class="space-y-4">
            {{-- Buku --}}
            <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                <p class="mb-3 text-xs font-semibold uppercase tracking-wide text-slate-400">Buku</p>
                <p class="font-semibold text-slate-900">{{ $transaksi->buku?->judul ?? '-' }}</p>
                <p class="text-sm text-slate-500">{{ $transaksi->buku?->pengarang ?? '' }}</p>
                <p class="mt-1 font-mono text-xs text-slate-400">{{ $transaksi->buku?->kode_buku ?? '' }}</p>
            </div>

            {{-- Anggota --}}
            <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                <p class="mb-3 text-xs font-semibold uppercase tracking-wide text-slate-400">Anggota</p>
                <p class="font-semibold text-slate-900">{{ $transaksi->anggota?->nama_anggota ?? '-' }}</p>
                <p class="font-mono text-xs text-slate-400">{{ $transaksi->anggota?->no_anggota ?? '' }}</p>
                <p class="mt-1 text-xs text-slate-500 capitalize">{{ $type === 'pelajar' ? 'Pelajar' : 'Non Pelajar' }}</p>
            </div>

            {{-- Petugas --}}
            <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                <p class="mb-3 text-xs font-semibold uppercase tracking-wide text-slate-400">Petugas</p>
                <div class="text-sm">
                    <p class="text-slate-500">Pinjam:</p>
                    <p class="font-medium">{{ $transaksi->petugasP?->nama_petugas ?? '-' }}</p>
                </div>
                @if ($transaksi->petugasK)
                    <div class="mt-2 text-sm">
                        <p class="text-slate-500">Kembali:</p>
                        <p class="font-medium">{{ $transaksi->petugasK->nama_petugas }}</p>
                    </div>
                @endif
            </div>

            {{-- Aksi --}}
            <div class="flex flex-col gap-2">
                @if ($transaksi->status !== 'dikembalikan')
                    <a href="{{ route('transaksi.pengembalian.process', ['type' => $type, 'id' => $transaksi->id]) }}"
                       class="block rounded-lg bg-emerald-600 px-4 py-2 text-center text-sm font-medium text-white hover:bg-emerald-700">
                        Proses Pengembalian
                    </a>
                @endif
                <a href="{{ route('transaksi.peminjaman.index') }}"
                   class="block rounded-lg border border-slate-300 px-4 py-2 text-center text-sm font-medium text-slate-700 hover:bg-slate-50">
                    Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>

</x-layouts.dashboard>

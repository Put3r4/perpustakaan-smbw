<x-layouts.dashboard title="Laporan Pengembalian">

    <div class="space-y-5">

        {{-- HEADER --}}
        <section class="rounded-md border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-wide text-emerald-700">Laporan</p>
                    <h2 class="mt-1 text-2xl font-semibold text-slate-950">Laporan Pengembalian</h2>
                    <p class="mt-1 text-sm text-slate-500">Data buku yang sudah dikembalikan oleh anggota perpustakaan.</p>
                </div>
                <div class="flex flex-wrap items-center gap-2">
                    <a href="{{ route('laporan.pengembalian.excel') }}"
                       class="flex items-center gap-2 rounded-lg bg-green-600 px-4 py-2 text-sm font-semibold text-white hover:bg-green-700">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Export Excel
                    </a>
                    <a href="{{ route('laporan.pengembalian.pdf') }}"
                       class="flex items-center gap-2 rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                        Export PDF
                    </a>
                </div>
            </div>
        </section>

        {{-- FILTER --}}
        <section class="rounded-md border border-slate-200 bg-white p-5 shadow-sm">
            <form method="GET" action="{{ route('laporan.pengembalian.index') }}" class="flex flex-col gap-3 sm:flex-row sm:items-end">
                <div class="flex-1">
                    <label class="mb-1 block text-xs font-semibold text-slate-500 uppercase tracking-wide">Cari</label>
                    <input type="text" name="search" value="{{ $search ?? '' }}"
                           placeholder="Nama anggota, judul buku, kode transaksi..."
                           class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500">
                </div>
                <div class="w-full sm:w-40">
                    <label class="mb-1 block text-xs font-semibold text-slate-500 uppercase tracking-wide">Jenis Anggota</label>
                    <select name="jenis" class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-emerald-500 focus:outline-none">
                        <option value="">Semua</option>
                        <option value="pelajar" {{ ($jenis ?? '') === 'pelajar' ? 'selected' : '' }}>Pelajar</option>
                        <option value="non_pelajar" {{ ($jenis ?? '') === 'non_pelajar' ? 'selected' : '' }}>Non Pelajar</option>
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit"
                            class="rounded-md bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">
                        Filter
                    </button>
                    <a href="{{ route('laporan.pengembalian.index') }}"
                       class="rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-50">
                        Reset
                    </a>
                </div>
            </form>
        </section>

        {{-- TABEL --}}
        <section class="rounded-md border border-slate-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                        <tr>
                            <th class="px-5 py-3">No</th>
                            <th class="px-5 py-3">Kode Transaksi</th>
                            <th class="px-5 py-3">No. Anggota</th>
                            <th class="px-5 py-3">Nama Anggota</th>
                            <th class="px-5 py-3 text-center">Jenis</th>
                            <th class="px-5 py-3">Judul Buku</th>
                            <th class="px-5 py-3">Tgl. Pinjam</th>
                            <th class="px-5 py-3">Tgl. Kembali</th>
                            <th class="px-5 py-3 text-right">Denda (Rp)</th>
                            <th class="px-5 py-3 text-center">Status Denda</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($data as $item)
                            <tr class="hover:bg-slate-50">
                                <td class="px-5 py-4 font-medium text-slate-950">
                                    {{ $data->firstItem() + $loop->index }}
                                </td>
                                <td class="px-5 py-4 font-mono text-xs text-slate-700">{{ $item->kode_transaksi }}</td>
                                <td class="px-5 py-4 font-mono text-xs text-slate-600">{{ $item->no_anggota }}</td>
                                <td class="px-5 py-4 font-medium text-slate-950">{{ $item->nama_anggota }}</td>
                                <td class="px-5 py-4 text-center">
                                    @if ($item->jenis_anggota === 'Pelajar')
                                        <span class="inline-flex rounded-full bg-blue-100 px-2 py-0.5 text-xs font-semibold text-blue-700">Pelajar</span>
                                    @else
                                        <span class="inline-flex rounded-full bg-purple-100 px-2 py-0.5 text-xs font-semibold text-purple-700">Non Pelajar</span>
                                    @endif
                                </td>
                                <td class="px-5 py-4 text-slate-700 max-w-xs">{{ $item->judul_buku }}</td>
                                <td class="px-5 py-4 text-slate-600">
                                    {{ $item->tgl_pinjam ? \Carbon\Carbon::parse($item->tgl_pinjam)->format('d/m/Y') : '-' }}
                                </td>
                                <td class="px-5 py-4 text-slate-600">
                                    {{ $item->tgl_kembali ? \Carbon\Carbon::parse($item->tgl_kembali)->format('d/m/Y') : '-' }}
                                </td>
                                <td class="px-5 py-4 text-right font-semibold {{ $item->denda > 0 ? 'text-red-600' : 'text-slate-500' }}">
                                    {{ $item->denda > 0 ? 'Rp ' . number_format($item->denda, 0, ',', '.') : '-' }}
                                </td>
                                <td class="px-5 py-4 text-center">
                                    @if ($item->status_denda === 'lunas')
                                        <span class="inline-flex rounded-full bg-emerald-100 px-2 py-0.5 text-xs font-semibold text-emerald-700">Lunas</span>
                                    @else
                                        <span class="inline-flex rounded-full bg-red-100 px-2 py-0.5 text-xs font-semibold text-red-700">Belum Lunas</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="px-5 py-10 text-center text-slate-500">
                                    Tidak ada data pengembalian yang ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION --}}
            <div class="border-t border-slate-200 px-5 py-4">
                <div class="flex items-center justify-between">
                    <p class="text-xs text-slate-500">
                        Menampilkan {{ $data->firstItem() ?? 0 }}–{{ $data->lastItem() ?? 0 }}
                        dari {{ $data->total() }} data
                    </p>
                    {{ $data->links() }}
                </div>
            </div>
        </section>

    </div>

</x-layouts.dashboard>

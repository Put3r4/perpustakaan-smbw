<x-layouts.dashboard title="Laporan Buku">

    <div class="space-y-5">

        {{-- HEADER --}}
        <section class="rounded-md border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-wide text-emerald-700">Laporan</p>
                    <h2 class="mt-1 text-2xl font-semibold text-slate-950">Laporan Buku</h2>
                    <p class="mt-1 text-sm text-slate-500">Data koleksi buku perpustakaan beserta lokasi rak dan stok tersedia.</p>
                </div>
                <div class="flex flex-wrap items-center gap-2">
                    <a href="{{ route('laporan.buku.excel') }}"
                       class="flex items-center gap-2 rounded-lg bg-green-600 px-4 py-2 text-sm font-semibold text-white hover:bg-green-700">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Export Excel
                    </a>
                    <a href="{{ route('laporan.buku.pdf') }}"
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
            <form method="GET" action="{{ route('laporan.buku.index') }}" class="flex flex-col gap-3 sm:flex-row sm:items-end">
                <div class="flex-1">
                    <label class="mb-1 block text-xs font-semibold text-slate-500 uppercase tracking-wide">Cari Buku</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Judul, pengarang, kode buku..."
                           class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500">
                </div>
                <div class="w-full sm:w-40">
                    <label class="mb-1 block text-xs font-semibold text-slate-500 uppercase tracking-wide">Status</label>
                    <select name="status" class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-emerald-500 focus:outline-none">
                        <option value="">Semua Status</option>
                        <option value="tersedia" {{ request('status') === 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="habis" {{ request('status') === 'habis' ? 'selected' : '' }}>Habis</option>
                        <option value="rusak" {{ request('status') === 'rusak' ? 'selected' : '' }}>Rusak</option>
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit"
                            class="rounded-md bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">
                        Filter
                    </button>
                    <a href="{{ route('laporan.buku.index') }}"
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
                            <th class="px-5 py-3">Kode Buku</th>
                            <th class="px-5 py-3">Judul Buku</th>
                            <th class="px-5 py-3">Pengarang</th>
                            <th class="px-5 py-3">Penerbit</th>
                            <th class="px-5 py-3">Tahun</th>
                            <th class="px-5 py-3 text-center">Eksemplar</th>
                            <th class="px-5 py-3 text-center">Stok</th>
                            <th class="px-5 py-3">Lokasi Rak</th>
                            <th class="px-5 py-3 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($buku as $item)
                            <tr class="hover:bg-slate-50">
                                <td class="px-5 py-4 font-medium text-slate-950">
                                    {{ $buku->firstItem() + $loop->index }}
                                </td>
                                <td class="px-5 py-4 font-mono text-xs text-slate-700">{{ $item->kode_buku }}</td>
                                <td class="px-5 py-4 font-medium text-slate-950 max-w-xs">{{ $item->judul }}</td>
                                <td class="px-5 py-4 text-slate-700">{{ $item->pengarang }}</td>
                                <td class="px-5 py-4 text-slate-600">{{ $item->penerbit }}</td>
                                <td class="px-5 py-4 text-slate-600">{{ $item->tahun_terbit }}</td>
                                <td class="px-5 py-4 text-center font-semibold text-slate-950">{{ $item->jumlah_eksemplar }}</td>
                                <td class="px-5 py-4 text-center">
                                    <span class="font-semibold {{ $item->stok_tersedia > 0 ? 'text-emerald-700' : 'text-red-600' }}">
                                        {{ $item->stok_tersedia }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-slate-600">{{ $item->rak ? $item->rak->nama_rak : '-' }}</td>
                                <td class="px-5 py-4 text-center">
                                    @if ($item->status === 'tersedia')
                                        <span class="inline-flex rounded-full bg-emerald-100 px-2 py-0.5 text-xs font-semibold text-emerald-700">Tersedia</span>
                                    @elseif ($item->status === 'habis')
                                        <span class="inline-flex rounded-full bg-amber-100 px-2 py-0.5 text-xs font-semibold text-amber-700">Habis</span>
                                    @else
                                        <span class="inline-flex rounded-full bg-red-100 px-2 py-0.5 text-xs font-semibold text-red-700">Rusak</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="px-5 py-10 text-center text-slate-500">
                                    Tidak ada data buku yang ditemukan.
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
                        Menampilkan {{ $buku->firstItem() ?? 0 }}–{{ $buku->lastItem() ?? 0 }}
                        dari {{ $buku->total() }} data
                    </p>
                    {{ $buku->links() }}
                </div>
            </div>

        </section>

    </div>

</x-layouts.dashboard>

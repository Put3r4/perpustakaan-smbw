<x-layouts.dashboard title="Laporan Keanggotaan">

    <div class="space-y-5">

        {{-- HEADER --}}
        <section class="rounded-md border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-wide text-emerald-700">Laporan</p>
                    <h2 class="mt-1 text-2xl font-semibold text-slate-950">Laporan Keanggotaan</h2>
                    <p class="mt-1 text-sm text-slate-500">Data gabungan anggota pelajar dan non pelajar perpustakaan.</p>
                </div>
                <div class="flex flex-wrap items-center gap-2">
                    <a href="{{ route('laporan.keanggotaan.excel') }}"
                       class="flex items-center gap-2 rounded-lg bg-green-600 px-4 py-2 text-sm font-semibold text-white hover:bg-green-700">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Export Excel
                    </a>
                    <a href="{{ route('laporan.keanggotaan.pdf') }}"
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
            <form method="GET" action="{{ route('laporan.keanggotaan.index') }}" class="flex flex-col gap-3 sm:flex-row sm:items-end">
                <div class="flex-1">
                    <label class="mb-1 block text-xs font-semibold text-slate-500 uppercase tracking-wide">Cari Anggota</label>
                    <input type="text" name="search" value="{{ $search ?? '' }}"
                           placeholder="Nama anggota atau nomor anggota..."
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
                    <a href="{{ route('laporan.keanggotaan.index') }}"
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
                            <th class="px-5 py-3">No. Anggota</th>
                            <th class="px-5 py-3">NIM/NIS / NIK</th>
                            <th class="px-5 py-3">Nama Anggota</th>
                            <th class="px-5 py-3 text-center">Jenis</th>
                            <th class="px-5 py-3">Asal Sekolah / Pekerjaan</th>
                            <th class="px-5 py-3">No. Telepon</th>
                            <th class="px-5 py-3">Tgl. Daftar</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($anggota as $item)
                            <tr class="hover:bg-slate-50">
                                <td class="px-5 py-4 font-medium text-slate-950">
                                    {{ $anggota->firstItem() + $loop->index }}
                                </td>
                                <td class="px-5 py-4 font-mono text-xs text-slate-700">{{ $item->no_anggota }}</td>
                                <td class="px-5 py-4 font-mono text-xs text-slate-600">{{ $item->identitas }}</td>
                                <td class="px-5 py-4 font-medium text-slate-950">{{ $item->nama_anggota }}</td>
                                <td class="px-5 py-4 text-center">
                                    @if ($item->jenis === 'Pelajar')
                                        <span class="inline-flex rounded-full bg-blue-100 px-2 py-0.5 text-xs font-semibold text-blue-700">Pelajar</span>
                                    @else
                                        <span class="inline-flex rounded-full bg-purple-100 px-2 py-0.5 text-xs font-semibold text-purple-700">Non Pelajar</span>
                                    @endif
                                </td>
                                <td class="px-5 py-4 text-slate-700">{{ $item->instansi ?? '-' }}</td>
                                <td class="px-5 py-4 text-slate-600">{{ $item->no_telp1 }}</td>
                                <td class="px-5 py-4 text-slate-600">
                                    {{ $item->tgl_daftar ? \Carbon\Carbon::parse($item->tgl_daftar)->format('d/m/Y') : '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-5 py-10 text-center text-slate-500">
                                    Tidak ada data anggota yang ditemukan.
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
                        Menampilkan {{ $anggota->firstItem() ?? 0 }}–{{ $anggota->lastItem() ?? 0 }}
                        dari {{ $anggota->total() }} data
                    </p>
                    {{ $anggota->links() }}
                </div>
            </div>
        </section>

    </div>

</x-layouts.dashboard>

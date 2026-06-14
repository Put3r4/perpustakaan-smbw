<x-layouts.dashboard title="Daftar Denda">

    @if (session('success'))
        <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            {{ session('error') }}
        </div>
    @endif

    <div class="mb-4 flex items-start justify-between">
        <div>
            <h2 class="text-lg font-semibold text-slate-900">Manajemen Denda Keterlambatan</h2>
            <p class="text-sm text-slate-500">Pantau tagihan denda dan update status pembayaran. Denda dihitung Rp500/hari keterlambatan.</p>
        </div>
        {{-- Summary stats --}}
        <div class="hidden gap-4 sm:flex">
            @php
                $totalBelumLunasPelajar = $dendaPelajar->where('status_denda', 'belum_lunas')->sum('denda');
                $totalBelumLunasNonPelajar = $dendaNonPelajar->where('status_denda', 'belum_lunas')->sum('denda');
            @endphp
            <div class="rounded-lg border border-orange-200 bg-orange-50 px-4 py-2 text-center">
                <p class="text-xs text-orange-600">Total Belum Lunas</p>
                <p class="font-bold text-orange-700">Rp {{ number_format($totalBelumLunasPelajar + $totalBelumLunasNonPelajar, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    {{-- TAB NAVIGATION --}}
    <div x-data="{ tab: 'pelajar' }" class="space-y-4">
        <div class="flex gap-2 border-b border-slate-200">
            <button @click="tab = 'pelajar'"
                    :class="tab === 'pelajar' ? 'border-emerald-600 text-emerald-700' : 'border-transparent text-slate-500 hover:text-slate-700'"
                    class="border-b-2 px-4 py-2 text-sm font-medium transition-colors">
                Pelajar
                <span class="ml-1 rounded-full bg-slate-100 px-2 py-0.5 text-xs text-slate-600">{{ $dendaPelajar->total() }}</span>
            </button>
            <button @click="tab = 'non_pelajar'"
                    :class="tab === 'non_pelajar' ? 'border-emerald-600 text-emerald-700' : 'border-transparent text-slate-500 hover:text-slate-700'"
                    class="border-b-2 px-4 py-2 text-sm font-medium transition-colors">
                Non Pelajar
                <span class="ml-1 rounded-full bg-slate-100 px-2 py-0.5 text-xs text-slate-600">{{ $dendaNonPelajar->total() }}</span>
            </button>
        </div>

        {{-- PELAJAR --}}
        <div x-show="tab === 'pelajar'" class="rounded-lg border border-slate-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                        <tr>
                            <th class="px-5 py-3">Kode Transaksi</th>
                            <th class="px-5 py-3">Anggota</th>
                            <th class="px-5 py-3">Buku</th>
                            <th class="px-5 py-3">Tgl Kembali</th>
                            <th class="px-5 py-3">Jatuh Tempo</th>
                            <th class="px-5 py-3">Denda</th>
                            <th class="px-5 py-3">Status</th>
                            <th class="px-5 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($dendaPelajar as $item)
                            <tr class="hover:bg-slate-50">
                                <td class="px-5 py-3 font-mono text-xs text-slate-600">{{ $item->kode_transaksi }}</td>
                                <td class="px-5 py-3">
                                    <div class="font-medium">{{ $item->anggota?->nama_anggota ?? '-' }}</div>
                                    <div class="text-xs text-slate-400">{{ $item->anggota?->no_anggota ?? '' }}</div>
                                </td>
                                <td class="px-5 py-3">{{ Str::limit($item->buku?->judul, 25) }}</td>
                                <td class="px-5 py-3">{{ $item->tgl_kembali ? \Carbon\Carbon::parse($item->tgl_kembali)->format('d/m/Y') : '-' }}</td>
                                <td class="px-5 py-3">{{ \Carbon\Carbon::parse($item->tgl_jatuh_tempo)->format('d/m/Y') }}</td>
                                <td class="px-5 py-3 font-semibold text-red-600">
                                    Rp {{ number_format($item->denda, 0, ',', '.') }}
                                </td>
                                <td class="px-5 py-3">
                                    @if ($item->status_denda === 'lunas')
                                        <span class="rounded-full bg-emerald-100 px-2 py-0.5 text-xs font-medium text-emerald-700">Lunas</span>
                                    @else
                                        <span class="rounded-full bg-orange-100 px-2 py-0.5 text-xs font-medium text-orange-700">Belum Lunas</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3">
                                    <form method="POST" action="{{ route('transaksi.denda.toggle', ['type' => 'pelajar', 'id' => $item->id]) }}">
                                        @csrf
                                        <button type="submit"
                                                class="rounded-md border border-slate-300 px-3 py-1 text-xs font-medium text-slate-700 hover:bg-slate-50">
                                            @if ($item->status_denda === 'lunas')
                                                Tandai Belum Lunas
                                            @else
                                                Tandai Lunas
                                            @endif
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-5 py-10 text-center text-slate-400">Tidak ada denda untuk anggota pelajar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($dendaPelajar->hasPages())
                <div class="border-t px-5 py-4">{{ $dendaPelajar->links() }}</div>
            @endif
        </div>

        {{-- NON PELAJAR --}}
        <div x-show="tab === 'non_pelajar'" class="rounded-lg border border-slate-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                        <tr>
                            <th class="px-5 py-3">Kode Transaksi</th>
                            <th class="px-5 py-3">Anggota</th>
                            <th class="px-5 py-3">Buku</th>
                            <th class="px-5 py-3">Tgl Kembali</th>
                            <th class="px-5 py-3">Jatuh Tempo</th>
                            <th class="px-5 py-3">Denda</th>
                            <th class="px-5 py-3">Status</th>
                            <th class="px-5 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($dendaNonPelajar as $item)
                            <tr class="hover:bg-slate-50">
                                <td class="px-5 py-3 font-mono text-xs text-slate-600">{{ $item->kode_transaksi }}</td>
                                <td class="px-5 py-3">
                                    <div class="font-medium">{{ $item->anggota?->nama_anggota ?? '-' }}</div>
                                    <div class="text-xs text-slate-400">{{ $item->anggota?->no_anggota ?? '' }}</div>
                                </td>
                                <td class="px-5 py-3">{{ Str::limit($item->buku?->judul, 25) }}</td>
                                <td class="px-5 py-3">{{ $item->tgl_kembali ? \Carbon\Carbon::parse($item->tgl_kembali)->format('d/m/Y') : '-' }}</td>
                                <td class="px-5 py-3">{{ \Carbon\Carbon::parse($item->tgl_jatuh_tempo)->format('d/m/Y') }}</td>
                                <td class="px-5 py-3 font-semibold text-red-600">
                                    Rp {{ number_format($item->denda, 0, ',', '.') }}
                                </td>
                                <td class="px-5 py-3">
                                    @if ($item->status_denda === 'lunas')
                                        <span class="rounded-full bg-emerald-100 px-2 py-0.5 text-xs font-medium text-emerald-700">Lunas</span>
                                    @else
                                        <span class="rounded-full bg-orange-100 px-2 py-0.5 text-xs font-medium text-orange-700">Belum Lunas</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3">
                                    <form method="POST" action="{{ route('transaksi.denda.toggle', ['type' => 'non_pelajar', 'id' => $item->id]) }}">
                                        @csrf
                                        <button type="submit"
                                                class="rounded-md border border-slate-300 px-3 py-1 text-xs font-medium text-slate-700 hover:bg-slate-50">
                                            @if ($item->status_denda === 'lunas')
                                                Tandai Belum Lunas
                                            @else
                                                Tandai Lunas
                                            @endif
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-5 py-10 text-center text-slate-400">Tidak ada denda untuk anggota non pelajar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($dendaNonPelajar->hasPages())
                <div class="border-t px-5 py-4">{{ $dendaNonPelajar->links() }}</div>
            @endif
        </div>
    </div>

</x-layouts.dashboard>

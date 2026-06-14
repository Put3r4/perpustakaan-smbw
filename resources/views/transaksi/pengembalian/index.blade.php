<x-layouts.dashboard title="Pengembalian Buku">

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

    <div class="mb-4">
        <h2 class="text-lg font-semibold text-slate-900">Daftar Buku yang Sedang Dipinjam</h2>
        <p class="text-sm text-slate-500">Pilih transaksi untuk memproses pengembalian buku.</p>
    </div>

    {{-- TAB NAVIGATION --}}
    <div x-data="{ tab: 'pelajar' }" class="space-y-4">
        <div class="flex gap-2 border-b border-slate-200">
            <button @click="tab = 'pelajar'"
                    :class="tab === 'pelajar' ? 'border-emerald-600 text-emerald-700' : 'border-transparent text-slate-500 hover:text-slate-700'"
                    class="border-b-2 px-4 py-2 text-sm font-medium transition-colors">
                Pelajar
                <span class="ml-1 rounded-full bg-slate-100 px-2 py-0.5 text-xs text-slate-600">{{ $kembaliPelajar->total() }}</span>
            </button>
            <button @click="tab = 'non_pelajar'"
                    :class="tab === 'non_pelajar' ? 'border-emerald-600 text-emerald-700' : 'border-transparent text-slate-500 hover:text-slate-700'"
                    class="border-b-2 px-4 py-2 text-sm font-medium transition-colors">
                Non Pelajar
                <span class="ml-1 rounded-full bg-slate-100 px-2 py-0.5 text-xs text-slate-600">{{ $kembaliNonPelajar->total() }}</span>
            </button>
        </div>

        {{-- PELAJAR --}}
        <div x-show="tab === 'pelajar'" class="rounded-lg border border-slate-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                        <tr>
                            <th class="px-5 py-3">Kode</th>
                            <th class="px-5 py-3">Anggota</th>
                            <th class="px-5 py-3">Buku</th>
                            <th class="px-5 py-3">Tgl Pinjam</th>
                            <th class="px-5 py-3">Jatuh Tempo</th>
                            <th class="px-5 py-3">Keterangan</th>
                            <th class="px-5 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($kembaliPelajar as $item)
                            @php
                                $terlambat = now()->toDateString() > $item->tgl_jatuh_tempo;
                                $hariTerlambat = $terlambat ? now()->diffInDays($item->tgl_jatuh_tempo) : 0;
                            @endphp
                            <tr class="hover:bg-slate-50 {{ $terlambat ? 'bg-red-50' : '' }}">
                                <td class="px-5 py-3 font-mono text-xs text-slate-600">{{ $item->kode_transaksi }}</td>
                                <td class="px-5 py-3">
                                    <div class="font-medium">{{ $item->anggota?->nama_anggota ?? '-' }}</div>
                                    <div class="text-xs text-slate-400">{{ $item->anggota?->no_anggota ?? '' }}</div>
                                </td>
                                <td class="px-5 py-3 font-medium">{{ Str::limit($item->buku?->judul, 28) }}</td>
                                <td class="px-5 py-3">{{ \Carbon\Carbon::parse($item->tgl_pinjam)->format('d/m/Y') }}</td>
                                <td class="px-5 py-3 {{ $terlambat ? 'font-semibold text-red-600' : '' }}">
                                    {{ \Carbon\Carbon::parse($item->tgl_jatuh_tempo)->format('d/m/Y') }}
                                </td>
                                <td class="px-5 py-3">
                                    @if ($terlambat)
                                        <span class="rounded-full bg-red-100 px-2 py-0.5 text-xs font-medium text-red-700">
                                            Telat {{ $hariTerlambat }} hari ~ Rp {{ number_format($hariTerlambat * 500, 0, ',', '.') }}
                                        </span>
                                    @else
                                        <span class="rounded-full bg-blue-100 px-2 py-0.5 text-xs font-medium text-blue-700">Tepat Waktu</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3">
                                    <a href="{{ route('transaksi.pengembalian.process', ['type' => 'pelajar', 'id' => $item->id]) }}"
                                       class="rounded-md bg-emerald-600 px-3 py-1.5 text-xs font-medium text-white hover:bg-emerald-700">
                                        Proses
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-5 py-10 text-center text-slate-400">Tidak ada buku pelajar yang sedang dipinjam.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($kembaliPelajar->hasPages())
                <div class="border-t px-5 py-4">{{ $kembaliPelajar->links() }}</div>
            @endif
        </div>

        {{-- NON PELAJAR --}}
        <div x-show="tab === 'non_pelajar'" class="rounded-lg border border-slate-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                        <tr>
                            <th class="px-5 py-3">Kode</th>
                            <th class="px-5 py-3">Anggota</th>
                            <th class="px-5 py-3">Buku</th>
                            <th class="px-5 py-3">Tgl Pinjam</th>
                            <th class="px-5 py-3">Jatuh Tempo</th>
                            <th class="px-5 py-3">Keterangan</th>
                            <th class="px-5 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($kembaliNonPelajar as $item)
                            @php
                                $terlambat = now()->toDateString() > $item->tgl_jatuh_tempo;
                                $hariTerlambat = $terlambat ? now()->diffInDays($item->tgl_jatuh_tempo) : 0;
                            @endphp
                            <tr class="hover:bg-slate-50 {{ $terlambat ? 'bg-red-50' : '' }}">
                                <td class="px-5 py-3 font-mono text-xs text-slate-600">{{ $item->kode_transaksi }}</td>
                                <td class="px-5 py-3">
                                    <div class="font-medium">{{ $item->anggota?->nama_anggota ?? '-' }}</div>
                                    <div class="text-xs text-slate-400">{{ $item->anggota?->no_anggota ?? '' }}</div>
                                </td>
                                <td class="px-5 py-3 font-medium">{{ Str::limit($item->buku?->judul, 28) }}</td>
                                <td class="px-5 py-3">{{ \Carbon\Carbon::parse($item->tgl_pinjam)->format('d/m/Y') }}</td>
                                <td class="px-5 py-3 {{ $terlambat ? 'font-semibold text-red-600' : '' }}">
                                    {{ \Carbon\Carbon::parse($item->tgl_jatuh_tempo)->format('d/m/Y') }}
                                </td>
                                <td class="px-5 py-3">
                                    @if ($terlambat)
                                        <span class="rounded-full bg-red-100 px-2 py-0.5 text-xs font-medium text-red-700">
                                            Telat {{ $hariTerlambat }} hari ~ Rp {{ number_format($hariTerlambat * 500, 0, ',', '.') }}
                                        </span>
                                    @else
                                        <span class="rounded-full bg-blue-100 px-2 py-0.5 text-xs font-medium text-blue-700">Tepat Waktu</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3">
                                    <a href="{{ route('transaksi.pengembalian.process', ['type' => 'non_pelajar', 'id' => $item->id]) }}"
                                       class="rounded-md bg-emerald-600 px-3 py-1.5 text-xs font-medium text-white hover:bg-emerald-700">
                                        Proses
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-5 py-10 text-center text-slate-400">Tidak ada buku non pelajar yang sedang dipinjam.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($kembaliNonPelajar->hasPages())
                <div class="border-t px-5 py-4">{{ $kembaliNonPelajar->links() }}</div>
            @endif
        </div>
    </div>

</x-layouts.dashboard>

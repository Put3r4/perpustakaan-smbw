<x-layouts.dashboard title="Daftar Peminjaman Buku">

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

    <div class="mb-4 flex items-center justify-between">
        <div>
            <h2 class="text-lg font-semibold text-slate-900">Manajemen Peminjaman Buku</h2>
            <p class="text-sm text-slate-500">Catat transaksi peminjaman buku untuk anggota pelajar dan non pelajar.</p>
        </div>
        <a href="{{ route('transaksi.peminjaman.create') }}"
           class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white hover:bg-emerald-700">
            + Tambah Peminjaman
        </a>
    </div>

    {{-- TAB NAVIGATION --}}
    <div x-data="{ tab: 'pelajar' }" class="space-y-4">
        <div class="flex gap-2 border-b border-slate-200">
            <button @click="tab = 'pelajar'"
                    :class="tab === 'pelajar' ? 'border-emerald-600 text-emerald-700' : 'border-transparent text-slate-500 hover:text-slate-700'"
                    class="border-b-2 px-4 py-2 text-sm font-medium transition-colors">
                Pelajar
                <span class="ml-1 rounded-full bg-slate-100 px-2 py-0.5 text-xs text-slate-600">{{ $pinjamPelajar->total() }}</span>
            </button>
            <button @click="tab = 'non_pelajar'"
                    :class="tab === 'non_pelajar' ? 'border-emerald-600 text-emerald-700' : 'border-transparent text-slate-500 hover:text-slate-700'"
                    class="border-b-2 px-4 py-2 text-sm font-medium transition-colors">
                Non Pelajar
                <span class="ml-1 rounded-full bg-slate-100 px-2 py-0.5 text-xs text-slate-600">{{ $pinjamNonPelajar->total() }}</span>
            </button>
        </div>

        {{-- TAB: PELAJAR --}}
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
                            <th class="px-5 py-3">Status</th>
                            <th class="px-5 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($pinjamPelajar as $item)
                            <tr class="hover:bg-slate-50">
                                <td class="px-5 py-3 font-mono text-xs text-slate-600">{{ $item->kode_transaksi }}</td>
                                <td class="px-5 py-3">
                                    <div class="font-medium">{{ $item->anggota?->nama_anggota ?? '-' }}</div>
                                    <div class="text-xs text-slate-400">{{ $item->anggota?->no_anggota ?? '' }}</div>
                                </td>
                                <td class="px-5 py-3">
                                    <div class="font-medium">{{ Str::limit($item->buku?->judul, 30) }}</div>
                                    <div class="text-xs text-slate-400">{{ $item->buku?->kode_buku ?? '' }}</div>
                                </td>
                                <td class="px-5 py-3">{{ \Carbon\Carbon::parse($item->tgl_pinjam)->format('d/m/Y') }}</td>
                                <td class="px-5 py-3">{{ \Carbon\Carbon::parse($item->tgl_jatuh_tempo)->format('d/m/Y') }}</td>
                                <td class="px-5 py-3">
                                    @if ($item->status === 'dipinjam')
                                        <span class="rounded-full bg-blue-100 px-2 py-0.5 text-xs font-medium text-blue-700">Dipinjam</span>
                                    @elseif ($item->status === 'terlambat')
                                        <span class="rounded-full bg-red-100 px-2 py-0.5 text-xs font-medium text-red-700">Terlambat</span>
                                    @else
                                        <span class="rounded-full bg-emerald-100 px-2 py-0.5 text-xs font-medium text-emerald-700">Dikembalikan</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('transaksi.peminjaman.show', ['type' => 'pelajar', 'id' => $item->id]) }}"
                                           class="text-xs font-medium text-slate-600 hover:text-emerald-700">Detail</a>
                                        @if ($item->status !== 'dikembalikan')
                                            <span class="text-slate-300">|</span>
                                            <form method="POST" action="{{ route('transaksi.peminjaman.destroy', ['type' => 'pelajar', 'id' => $item->id]) }}"
                                                  onsubmit="return confirm('Hapus transaksi ini? Stok buku akan dikembalikan.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-xs font-medium text-red-600 hover:text-red-700">Hapus</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-5 py-10 text-center text-slate-400">Belum ada data peminjaman pelajar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($pinjamPelajar->hasPages())
                <div class="border-t px-5 py-4">{{ $pinjamPelajar->links() }}</div>
            @endif
        </div>

        {{-- TAB: NON PELAJAR --}}
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
                            <th class="px-5 py-3">Status</th>
                            <th class="px-5 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($pinjamNonPelajar as $item)
                            <tr class="hover:bg-slate-50">
                                <td class="px-5 py-3 font-mono text-xs text-slate-600">{{ $item->kode_transaksi }}</td>
                                <td class="px-5 py-3">
                                    <div class="font-medium">{{ $item->anggota?->nama_anggota ?? '-' }}</div>
                                    <div class="text-xs text-slate-400">{{ $item->anggota?->no_anggota ?? '' }}</div>
                                </td>
                                <td class="px-5 py-3">
                                    <div class="font-medium">{{ Str::limit($item->buku?->judul, 30) }}</div>
                                    <div class="text-xs text-slate-400">{{ $item->buku?->kode_buku ?? '' }}</div>
                                </td>
                                <td class="px-5 py-3">{{ \Carbon\Carbon::parse($item->tgl_pinjam)->format('d/m/Y') }}</td>
                                <td class="px-5 py-3">{{ \Carbon\Carbon::parse($item->tgl_jatuh_tempo)->format('d/m/Y') }}</td>
                                <td class="px-5 py-3">
                                    @if ($item->status === 'dipinjam')
                                        <span class="rounded-full bg-blue-100 px-2 py-0.5 text-xs font-medium text-blue-700">Dipinjam</span>
                                    @elseif ($item->status === 'terlambat')
                                        <span class="rounded-full bg-red-100 px-2 py-0.5 text-xs font-medium text-red-700">Terlambat</span>
                                    @else
                                        <span class="rounded-full bg-emerald-100 px-2 py-0.5 text-xs font-medium text-emerald-700">Dikembalikan</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('transaksi.peminjaman.show', ['type' => 'non_pelajar', 'id' => $item->id]) }}"
                                           class="text-xs font-medium text-slate-600 hover:text-emerald-700">Detail</a>
                                        @if ($item->status !== 'dikembalikan')
                                            <span class="text-slate-300">|</span>
                                            <form method="POST" action="{{ route('transaksi.peminjaman.destroy', ['type' => 'non_pelajar', 'id' => $item->id]) }}"
                                                  onsubmit="return confirm('Hapus transaksi ini? Stok buku akan dikembalikan.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-xs font-medium text-red-600 hover:text-red-700">Hapus</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-5 py-10 text-center text-slate-400">Belum ada data peminjaman non pelajar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($pinjamNonPelajar->hasPages())
                <div class="border-t px-5 py-4">{{ $pinjamNonPelajar->links() }}</div>
            @endif
        </div>
    </div>

    <script>
        // Pastikan Alpine.js tersedia dari layout
    </script>

</x-layouts.dashboard>

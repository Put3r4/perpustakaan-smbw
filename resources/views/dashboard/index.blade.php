<x-layouts.dashboard title="Dashboard">
    <div class="space-y-6">
        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <x-cards.stat-card label="Anggota Pelajar" :value="number_format($stats['anggotaPelajar'])" tone="emerald" />
            <x-cards.stat-card label="Anggota Non Pelajar" :value="number_format($stats['anggotaNonPelajar'])" tone="sky" />
            <x-cards.stat-card label="Total Buku" :value="number_format($stats['buku'])" tone="slate" />
            <x-cards.stat-card label="Kunjungan Hari Ini" :value="number_format($stats['kunjunganHariIni'])" tone="amber" />
        </div>

        <div class="grid gap-6 xl:grid-cols-[1.2fr_0.8fr]">
            <section class="rounded-md border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-200 px-5 py-4">
                    <h2 class="text-base font-semibold text-slate-950">Transaksi Terbaru</h2>
                    <p class="mt-1 text-sm text-slate-500">Gabungan peminjaman pelajar dan non pelajar.</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 text-sm">
                        <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                            <tr>
                                <th class="px-5 py-3">Kode</th>
                                <th class="px-5 py-3">Anggota</th>
                                <th class="px-5 py-3">Buku</th>
                                <th class="px-5 py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($latestTransactions as $transaction)
                                <tr wire:key="transaction-{{ $transaction['kode'] }}">
                                    <td class="whitespace-nowrap px-5 py-4 font-medium text-slate-900">{{ $transaction['kode'] }}</td>
                                    <td class="px-5 py-4 text-slate-600">{{ $transaction['anggota'] }}</td>
                                    <td class="px-5 py-4 text-slate-600">{{ $transaction['buku'] }}</td>
                                    <td class="px-5 py-4">
                                        <span class="rounded-md bg-slate-100 px-2 py-1 text-xs font-semibold text-slate-700">{{ $transaction['status'] }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-5 py-6 text-center text-slate-500">Belum ada transaksi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="rounded-md border border-slate-200 bg-white p-5 shadow-sm">
                <h2 class="text-base font-semibold text-slate-950">Ringkasan Sirkulasi</h2>
                <div class="mt-4 grid gap-3">
                    <div class="flex items-center justify-between rounded-md bg-slate-50 px-4 py-3">
                        <span class="text-sm font-medium text-slate-600">Stok Tersedia</span>
                        <span class="text-lg font-semibold text-slate-950">{{ number_format($stats['stokTersedia']) }}</span>
                    </div>
                    <div class="flex items-center justify-between rounded-md bg-emerald-50 px-4 py-3">
                        <span class="text-sm font-medium text-emerald-800">Peminjaman Aktif</span>
                        <span class="text-lg font-semibold text-emerald-900">{{ number_format($stats['peminjamanAktif']) }}</span>
                    </div>
                    <div class="flex items-center justify-between rounded-md bg-rose-50 px-4 py-3">
                        <span class="text-sm font-medium text-rose-800">Terlambat</span>
                        <span class="text-lg font-semibold text-rose-900">{{ number_format($stats['terlambat']) }}</span>
                    </div>
                </div>
            </section>
        </div>

        <div class="grid gap-6 xl:grid-cols-2">
            <section class="rounded-md border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-200 px-5 py-4">
                    <h2 class="text-base font-semibold text-slate-950">Buku Paling Aktif</h2>
                    <p class="mt-1 text-sm text-slate-500">Diurutkan dari total dipinjam dan total dilihat.</p>
                </div>
                <div class="divide-y divide-slate-100">
                    @forelse ($popularBooks as $book)
                        <div class="flex items-center justify-between gap-4 px-5 py-4" wire:key="dashboard-book-{{ $book->id }}">
                            <div>
                                <p class="font-medium text-slate-950">{{ $book->judul }}</p>
                                <p class="mt-1 text-sm text-slate-500">{{ $book->kode_buku }} · Stok {{ $book->stok_tersedia }}</p>
                            </div>
                            <div class="text-right text-sm text-slate-500">
                                <p>{{ $book->total_dipinjam }} pinjam</p>
                                <p>{{ $book->total_dilihat }} lihat</p>
                            </div>
                        </div>
                    @empty
                        <p class="px-5 py-6 text-sm text-slate-500">Belum ada data buku.</p>
                    @endforelse
                </div>
            </section>

            <section class="rounded-md border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-200 px-5 py-4">
                    <h2 class="text-base font-semibold text-slate-950">Jadwal Piket Hari Ini</h2>
                    <p class="mt-1 text-sm text-slate-500">Daftar petugas yang dijadwalkan bertugas.</p>
                </div>
                <div class="divide-y divide-slate-100">
                    @forelse ($todayShifts as $shift)
                        <div class="flex items-center justify-between gap-4 px-5 py-4" wire:key="shift-{{ $shift->id }}">
                            <div>
                                <p class="font-medium text-slate-950">{{ $shift->petugas?->nama_petugas ?? 'Petugas' }}</p>
                                <p class="mt-1 text-sm text-slate-500">{{ $shift->petugas?->jabatan ?? '-' }}</p>
                            </div>
                            <p class="text-sm font-semibold text-slate-700">{{ $shift->jam_mulai }} - {{ $shift->jam_selesai }}</p>
                        </div>
                    @empty
                        <p class="px-5 py-6 text-sm text-slate-500">Belum ada jadwal piket untuk hari ini.</p>
                    @endforelse
                </div>
            </section>
        </div>
    </div>
</x-layouts.dashboard>

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
                            <p class="text-sm font-semibold text-slate-700">
                                {{ \Carbon\Carbon::parse($shift->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($shift->jam_selesai)->format('H:i') }}
                            </p>
                        </div>
                    @empty
                        <p class="px-5 py-6 text-sm text-slate-500">Belum ada jadwal piket untuk hari ini.</p>
                    @endforelse
                </div>
            </section>
        </div>

        {{-- SECTION STATISTIK PENGUNJUNG --}}
        <div class="border-t border-slate-200 pt-6">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between mb-6">
                <div>
                    <h2 class="text-xl font-bold text-slate-950">Statistik Pengunjung</h2>
                    <p class="text-sm text-slate-500">Analisis dan data kunjungan perpustakaan.</p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('dashboard.visitor.excel') }}" 
                       class="inline-flex items-center justify-center rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700 transition-colors">
                        Excel
                    </a>
                    <a href="{{ route('dashboard.visitor.pdf') }}" 
                       class="inline-flex items-center justify-center rounded-lg bg-rose-600 px-4 py-2 text-sm font-semibold text-white hover:bg-rose-700 transition-colors">
                        PDF
                    </a>
                </div>
            </div>

            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4 mb-6">
                <x-cards.stat-card label="Pengunjung Hari Ini" :value="number_format($stats['kunjunganHariIni'])" tone="amber" />
                <x-cards.stat-card label="Pengunjung Minggu Ini" :value="number_format($stats['kunjunganMingguIni'])" tone="emerald" />
                <x-cards.stat-card label="Pengunjung Bulan Ini" :value="number_format($stats['kunjunganBulanIni'])" tone="sky" />
                <x-cards.stat-card label="Pengunjung Tahun Ini" :value="number_format($stats['kunjunganTahunIni'])" tone="slate" />
            </div>

            <div class="grid gap-6 xl:grid-cols-[1.2fr_0.8fr] mb-6">
                {{-- Grafik Kunjungan (Chart.js) --}}
                <section class="rounded-md border border-slate-200 bg-white p-5 shadow-sm">
                    <h3 class="text-base font-semibold text-slate-950 mb-4">Grafik Kunjungan (7 Hari Terakhir)</h3>
                    <div style="height: 300px;">
                        <canvas id="visitorChart"></canvas>
                    </div>
                </section>

                {{-- Statistik Jenis Pengunjung --}}
                <section class="rounded-md border border-slate-200 bg-white p-5 shadow-sm flex flex-col justify-between">
                    <div>
                        <h3 class="text-base font-semibold text-slate-950 mb-4">Jenis Pengunjung</h3>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between rounded-md bg-emerald-50 px-4 py-3">
                                <span class="text-sm font-medium text-emerald-800">Total Pelajar</span>
                                <span class="text-lg font-semibold text-emerald-900">{{ number_format($totalPelajarVisitor) }}</span>
                            </div>
                            <div class="flex items-center justify-between rounded-md bg-sky-50 px-4 py-3">
                                <span class="text-sm font-medium text-slate-600">Total Non Pelajar</span>
                                <span class="text-lg font-semibold text-slate-950">{{ number_format($totalNonPelajarVisitor) }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6 border-t border-slate-100 pt-4 text-xs text-slate-500">
                        * Data dihitung berdasarkan total log kunjungan yang tercatat di sistem.
                    </div>
                </section>
            </div>

            {{-- Top 10 Pengunjung --}}
            <section class="rounded-md border border-slate-200 bg-white shadow-sm mb-6">
                <div class="border-b border-slate-200 px-5 py-4">
                    <h3 class="text-base font-semibold text-slate-950">Top 10 Pengunjung Teraktif</h3>
                    <p class="mt-1 text-sm text-slate-500 font-normal">Daftar anggota dengan jumlah kunjungan terbanyak.</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 text-sm">
                        <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                            <tr>
                                <th class="px-5 py-3">Peringkat</th>
                                <th class="px-5 py-3">Nama Anggota</th>
                                <th class="px-5 py-3">No. Anggota</th>
                                <th class="px-5 py-3">Tipe</th>
                                <th class="px-5 py-3 text-center">Total Kunjungan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($topVisitors as $index => $visitor)
                                <tr>
                                    <td class="px-5 py-4 font-medium text-slate-900">{{ $index + 1 }}</td>
                                    <td class="px-5 py-4 text-slate-700 font-semibold">{{ $visitor['nama'] }}</td>
                                    <td class="px-5 py-4 text-slate-600">{{ $visitor['no_anggota'] }}</td>
                                    <td class="px-5 py-4">
                                        @if ($visitor['tipe'] === 'Pelajar')
                                            <span class="rounded-md bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">Pelajar</span>
                                        @else
                                            <span class="rounded-md bg-sky-50 px-2.5 py-1 text-xs font-semibold text-sky-700">Non Pelajar</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 text-center font-bold text-slate-900">{{ $visitor['total_kunjungan'] }} kali</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-5 py-6 text-center text-slate-500">Belum ada data kunjungan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>

    {{-- CHART.JS INTEGRATION --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('visitorChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($chartLabels) !!},
                    datasets: [{
                        label: 'Jumlah Kunjungan',
                        data: {!! json_encode($chartData) !!},
                        borderColor: '#0f766e',
                        backgroundColor: 'rgba(15, 118, 110, 0.1)',
                        borderWidth: 2,
                        tension: 0.3,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        });
    </script>
</x-layouts.dashboard>

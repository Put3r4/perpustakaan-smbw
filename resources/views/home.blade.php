<x-layouts.app title="Perpustakaan Kota Sumbawa">
    <section class="bg-white">
        <div class="mx-auto grid max-w-7xl gap-8 px-4 py-10 sm:px-6 lg:grid-cols-[1.15fr_0.85fr] lg:px-8 lg:py-14">
            <div class="flex flex-col justify-center">
                <p class="text-sm font-semibold uppercase tracking-wide text-emerald-700">Perpustakaan Kota Sumbawa</p>
                <h1 class="mt-3 max-w-3xl text-4xl font-semibold tracking-normal text-slate-950 sm:text-5xl">
                    Temukan buku, pantau stok, dan kelola kunjungan dalam satu sistem.
                </h1>
                <p class="mt-5 max-w-2xl text-base leading-7 text-slate-600">
                    Portal awal untuk melihat katalog, aktivitas perpustakaan, dan ringkasan layanan sebelum masuk ke dashboard operasional petugas.
                </p>
                <div class="mt-7 flex flex-wrap gap-3">
                    <a href="{{ route('buku.index') }}" class="rounded-md bg-emerald-700 px-4 py-2.5 text-sm font-semibold text-white hover:bg-emerald-800">Lihat Katalog</a>
                    <a href="{{ route('dashboard') }}" class="rounded-md border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">Masuk Dashboard</a>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3 rounded-md border border-slate-200 bg-slate-50 p-4">
                <x-cards.stat-card label="Total Buku" :value="number_format($stats['buku'])" tone="emerald" />
                <x-cards.stat-card label="Total Anggota" :value="number_format($stats['anggota'])" tone="sky" />
                <x-cards.stat-card label="Kunjungan Hari Ini" :value="number_format($stats['kunjungan'])" tone="amber" />
                <x-cards.stat-card label="Stok Tersedia" :value="number_format($stats['tersedia'])" tone="slate" />
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between gap-4">
            <div>
                <p class="text-sm font-semibold uppercase tracking-wide text-emerald-700">Katalog</p>
                <h2 class="mt-1 text-2xl font-semibold text-slate-950">Buku Populer</h2>
            </div>
            <a href="{{ route('buku.index') }}" class="text-sm font-semibold text-emerald-700 hover:text-emerald-900">Lihat semua</a>
        </div>

        <div class="mt-5 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($popularBooks as $book)
                <article class="rounded-md border border-slate-200 bg-white p-4 shadow-sm" wire:key="home-book-{{ $book->id }}">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">{{ $book->kode_buku }}</p>
                            <h3 class="mt-2 text-base font-semibold text-slate-950">{{ $book->judul }}</h3>
                        </div>
                        <span class="rounded-md bg-emerald-50 px-2 py-1 text-xs font-semibold text-emerald-800">{{ $book->status }}</span>
                    </div>
                    <p class="mt-3 text-sm text-slate-600">{{ $book->pengarang }}</p>
                    <div class="mt-4 flex items-center justify-between text-sm text-slate-500">
                        <span>Stok {{ $book->stok_tersedia }}</span>
                        <span>Dilihat {{ $book->total_dilihat }}</span>
                    </div>
                </article>
            @empty
                <div class="rounded-md border border-dashed border-slate-300 bg-white p-6 text-sm text-slate-500 sm:col-span-2 lg:col-span-3">
                    Belum ada data buku. Jalankan seeder buku untuk melihat katalog contoh.
                </div>
            @endforelse
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 pb-12 sm:px-6 lg:px-8">
        <div class="rounded-md border border-slate-200 bg-white p-5">
            <div class="grid gap-5 lg:grid-cols-[0.75fr_1.25fr]">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-wide text-amber-700">Aturan Layanan</p>
                    <h2 class="mt-1 text-2xl font-semibold text-slate-950">Konfigurasi Sistem</h2>
                    <p class="mt-3 text-sm leading-6 text-slate-600">Nilai diambil dari tabel system_settings sehingga bisa disesuaikan pada modul pengaturan berikutnya.</p>
                </div>
                <div class="grid gap-3 sm:grid-cols-2">
                    @forelse ($settings as $key => $value)
                        <div class="rounded-md border border-slate-200 p-4" wire:key="setting-{{ $key }}">
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">{{ str_replace('_', ' ', $key) }}</p>
                            <p class="mt-2 text-lg font-semibold text-slate-950">{{ $value }}</p>
                        </div>
                    @empty
                        <p class="text-sm text-slate-500">Belum ada konfigurasi sistem.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>

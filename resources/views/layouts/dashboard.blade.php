<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title }} - {{ config('app.name', 'Perpustakaan Kota Sumbawa') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-slate-100 text-slate-950 antialiased">
        <div class="min-h-screen lg:flex">
            <aside class="border-b border-slate-200 bg-white lg:sticky lg:top-0 lg:h-screen lg:w-72 lg:border-b-0 lg:border-r">
                <div class="flex h-full flex-col">
                    <div class="border-b border-slate-200 px-5 py-5">
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                            <span class="flex size-10 items-center justify-center rounded-md bg-emerald-700 text-sm font-semibold text-white">PK</span>
                            <span>
                                <span class="block text-sm font-semibold">Perpus Kota</span>
                                <span class="block text-xs text-slate-500">Dashboard Petugas</span>
                            </span>
                        </a>
                    </div>

                    <nav class="flex-1 space-y-5 overflow-y-auto px-3 py-4 text-sm">
                        <div class="space-y-1">
                            <x-dashboard.nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">Dashboard</x-dashboard.nav-link>
                        </div>

                        <div>
                            <p class="px-3 text-xs font-semibold uppercase tracking-wide text-slate-400">Keanggotaan</p>
                            <div class="mt-2 space-y-1">
                                <x-dashboard.nav-link :href="route('anggota.pelajar.index')" :active="request()->routeIs('anggota.pelajar.*')">Pelajar</x-dashboard.nav-link>
                                <x-dashboard.nav-link :href="route('anggota.non-pelajar.index')" :active="request()->routeIs('anggota.non-pelajar.*')">Non Pelajar</x-dashboard.nav-link>
                            </div>
                        </div>

                        <div>
                            <p class="px-3 text-xs font-semibold uppercase tracking-wide text-slate-400">Buku</p>
                            <div class="mt-2 space-y-1">
                                <x-dashboard.nav-link :href="route('buku.index')" :active="request()->routeIs('buku.index')">Data Buku</x-dashboard.nav-link>
                                <x-dashboard.nav-link :href="route('buku.kategori.index')" :active="request()->routeIs('buku.kategori.*')">Kategori Buku</x-dashboard.nav-link>
                                <x-dashboard.nav-link :href="route('buku.rak.index')" :active="request()->routeIs('buku.rak.*')">Rak Buku</x-dashboard.nav-link>
                            </div>
                        </div>

                        <div>
                            <p class="px-3 text-xs font-semibold uppercase tracking-wide text-slate-400">Transaksi</p>
                            <div class="mt-2 space-y-1">
                                <x-dashboard.nav-link :href="route('transaksi.peminjaman.index')" :active="request()->routeIs('transaksi.peminjaman.*')">Peminjaman</x-dashboard.nav-link>
                                <x-dashboard.nav-link :href="route('transaksi.pengembalian.index')" :active="request()->routeIs('transaksi.pengembalian.*')">Pengembalian</x-dashboard.nav-link>
                                <x-dashboard.nav-link :href="route('transaksi.denda.index')" :active="request()->routeIs('transaksi.denda.*')">Denda</x-dashboard.nav-link>
                            </div>
                        </div>

                        <div>
                            <p class="px-3 text-xs font-semibold uppercase tracking-wide text-slate-400">Kunjungan</p>
                            <div class="mt-2 space-y-1">
                                <x-dashboard.nav-link :href="route('kunjungan.check-in.index')" :active="request()->routeIs('kunjungan.*')">Check-In Pengunjung</x-dashboard.nav-link>
                            </div>
                        </div>

                        <div>
                            <p class="px-3 text-xs font-semibold uppercase tracking-wide text-slate-400">Laporan</p>
                            <div class="mt-2 space-y-1">
                                <x-dashboard.nav-link :href="route('laporan.peminjaman.index')" :active="request()->routeIs('laporan.peminjaman.*')">Peminjaman</x-dashboard.nav-link>
                                <x-dashboard.nav-link :href="route('laporan.pengembalian.index')" :active="request()->routeIs('laporan.pengembalian.*')">Pengembalian</x-dashboard.nav-link>
                                <x-dashboard.nav-link :href="route('laporan.buku.index')" :active="request()->routeIs('laporan.buku.*')">Buku</x-dashboard.nav-link>
                                <x-dashboard.nav-link :href="route('laporan.denda.index')" :active="request()->routeIs('laporan.denda.*')">Denda</x-dashboard.nav-link>
                                <x-dashboard.nav-link :href="route('laporan.keanggotaan.index')" :active="request()->routeIs('laporan.keanggotaan.*')">Keanggotaan</x-dashboard.nav-link>
                            </div>
                        </div>

                        <div>
                            <p class="px-3 text-xs font-semibold uppercase tracking-wide text-slate-400">Pengaturan</p>
                            <div class="mt-2 space-y-1">
                                <x-dashboard.nav-link :href="route('pengaturan.profil.index')" :active="request()->routeIs('pengaturan.*')">Profil</x-dashboard.nav-link>
                            </div>
                        </div>
                    </nav>
                </div>
            </aside>

            <div class="min-w-0 flex-1">
                <header class="border-b border-slate-200 bg-white">
                    <div class="flex items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-emerald-700">Sistem Informasi</p>
                            <h1 class="mt-1 text-xl font-semibold text-slate-950">{{ $title }}</h1>
                        </div>
                        <a href="{{ route('home') }}" class="rounded-md border border-slate-200 px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Lihat Home</a>
                    </div>
                </header>

                <main class="px-4 py-6 sm:px-6 lg:px-8">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>

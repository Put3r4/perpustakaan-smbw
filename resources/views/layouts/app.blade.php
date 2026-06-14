<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title ?? config('app.name', 'Perpustakaan Kota Sumbawa') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-stone-50 text-slate-950 antialiased">
        <div class="min-h-screen">
            <header class="border-b border-slate-200 bg-white">
                <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">
                    {{-- Logo Aplikasi --}}
                    <a href="{{ route('home') }}" class="flex items-center gap-3">
                        <span class="flex size-10 items-center justify-center rounded-md bg-emerald-700 text-sm font-semibold text-white">PK</span>
                        <span>
                            <span class="block text-sm font-semibold">Perpustakaan Kota Sumbawa</span>
                            <span class="block text-xs text-slate-500">Sistem Informasi Perpustakaan</span>
                        </span>
                    </a>

                    {{-- Container Menu Navigasi --}}
                    <nav class="flex items-center gap-2 text-sm">
                        {{-- Menu Publik (Selalu Muncul) --}}
                        <a href="{{ route('buku.index') }}" class="rounded-md px-3 py-2 font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-950 transition">Katalog</a>

                        {{-- 1. KONDISI JIKA PENGGUNA SUDAH LOGIN --}}
                        @auth
                            {{-- Menu Tambahan khusus untuk Anggota Umum (Pelajar & Non-Pelajar) --}}
                            @if(in_array(auth()->user()->role, ['pelajar', 'non_pelajar']))
                                <a href="{{ route('profile.index') }}" class="rounded-md px-3 py-2 font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-950 transition">Profil Saya</a>
                                <a href="{{ route('peminjaman.index') }}" class="rounded-md px-3 py-2 font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-950 transition">Peminjaman</a>
                            @endif

                            {{-- Tombol Akses Dashboard (HANYA UNTUK PETUGAS ATAU SUPERADMIN) --}}
                            @if(in_array(auth()->user()->role, ['petugas', 'superadmin']))
                                <a href="{{ route('dashboard') }}" class="rounded-md bg-slate-950 px-3 py-2 font-medium text-white hover:bg-slate-800 transition">Dashboard</a>
                            @endif

                            {{-- Form Keluar Sistem yang Menyatu Sempurna di Navbar --}}
                            <form method="POST" action="{{ route('logout') }}" class="inline m-0">
                                @csrf
                                <button type="submit" class="rounded-md px-3 py-2 font-medium text-rose-600 hover:bg-rose-50 hover:text-rose-700 transition">
                                    Keluar
                                </button>
                            </form>
                        @endauth

                        {{-- 2. KONDISI JIKA PENGGUNA BELUM LOGIN (GUEST) --}}
                        @guest
                            <a href="{{ route('login') }}" class="rounded-md px-3 py-2 font-medium text-emerald-700 hover:bg-emerald-50 transition">Masuk</a>
                            <a href="{{ route('register') }}" class="rounded-md bg-emerald-700 px-3 py-2 font-medium text-white hover:bg-emerald-800 transition">Daftar</a>
                        @endguest
                    </nav>
                </div>
            </header>

            {{-- Main Content --}}
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
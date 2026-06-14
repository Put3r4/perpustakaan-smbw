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
                    <a href="{{ route('home') }}" class="flex items-center gap-3">
                        <span class="flex size-10 items-center justify-center rounded-md bg-emerald-700 text-sm font-semibold text-white">PK</span>
                        <span>
                            <span class="block text-sm font-semibold">Perpustakaan Kota Sumbawa</span>
                            <span class="block text-xs text-slate-500">Sistem Informasi Perpustakaan</span>
                        </span>
                    </a>

                    <nav class="flex items-center gap-2 text-sm">
                        <a href="{{ route('buku.index') }}" class="rounded-md px-3 py-2 font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-950">Katalog</a>
                        <a href="{{ route('dashboard') }}" class="rounded-md bg-slate-950 px-3 py-2 font-medium text-white hover:bg-slate-800">Dashboard</a>
                    </nav>
                </div>
            </header>

            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>

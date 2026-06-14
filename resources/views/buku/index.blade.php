<x-layouts.dashboard title="Data Buku">
    <div class="space-y-5">
        <section class="rounded-md border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm font-semibold uppercase tracking-wide text-emerald-700">
                        Katalog
                    </p>

                    <h2 class="mt-1 text-2xl font-semibold text-slate-950">
                        Data Buku
                    </h2>
                </div>


                <a href="{{ route('buku.create') }}"
                    class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">
                    + Tambah Buku
                </a>

               <form method="GET" action="{{ route('buku.index') }}" class="flex w-full gap-2 md:max-w-md">
    <input
        type="search"
        name="search"
        value="{{ $search ?? '' }}"
        placeholder="Cari judul, pengarang, atau kode"
        class="min-w-0 flex-1 rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100"
    >

    <button type="submit" class="rounded-md bg-emerald-700 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-800">Cari</button>
</form>

            </div>
        </section>

        <section class="rounded-md border border-slate-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                        <tr>
                            <th class="px-5 py-3">Kode</th>
                            <th class="px-5 py-3">Cover</th>
                            <th class="px-5 py-3">Judul</th>
                            <th class="px-5 py-3">Pengarang</th>
                            <th class="px-5 py-3">Penerbit</th>
                            <th class="px-5 py-3">ISBN</th>
                            <th class="px-5 py-3">Tahun</th>
                            <th class="px-5 py-3">Stok</th>
                            <th class="px-5 py-3">Status</th>
                            <th class="px-5 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($books as $book)
                            <tr>

                                <td class="whitespace-nowrap px-5 py-4 font-medium text-slate-950">
                                    {{ $book->kode_buku }}
                                </td>

                                <td class="px-5 py-4">
                                    @if ($book->cover_buku)
                                        <img src="{{ asset('storage/' . $book->cover_buku) }}" alt="{{ $book->judul }}"
                                            class="h-16 w-12 rounded-md object-cover border">
                                    @else
                                        <div
                                            class="flex h-16 w-12 items-center justify-center rounded-md bg-slate-200 text-[10px] text-slate-500">
                                            No Cover
                                        </div>
                                    @endif
                                </td>

                                <td class="px-5 py-4 text-slate-700">
                                    {{ $book->judul }}
                                </td>

                                <td class="px-5 py-4 text-slate-600">
                                    {{ $book->pengarang }}
                                </td>

                                <td class="px-5 py-4 text-slate-600">
                                    {{ $book->penerbit }}
                                </td>

                                <td class="px-5 py-4 text-slate-600">
                                    {{ $book->isbn ?? '-' }}
                                </td>

                                <td class="px-5 py-4 text-slate-600">
                                    {{ $book->tahun_terbit }}
                                </td>

                                <td class="px-5 py-4 text-slate-600">
                                    {{ $book->stok_tersedia }}
                                </td>

                                <td class="px-5 py-4">
                                    @if ($book->status == 'tersedia')
                                        <span
                                            class="rounded-md bg-green-100 px-2 py-1 text-xs font-semibold text-green-700">
                                            Tersedia
                                        </span>
                                    @else
                                        <span
                                            class="rounded-md bg-red-100 px-2 py-1 text-xs font-semibold text-red-700">
                                            {{ $book->status }}
                                        </span>
                                    @endif
                                </td>

                                <td class="px-5 py-4">
                                    <div class="flex items-center justify-center gap-2">

                                        <a href="{{ route('buku.show', $book->id) }}"
                                            class="rounded bg-blue-500 px-3 py-1 text-xs font-medium text-white hover:bg-blue-600">
                                            Detail
                                        </a>

                                        <a href="{{ route('buku.edit', $book->id) }}"
                                            class="rounded bg-yellow-500 px-3 py-1 text-xs font-medium text-white hover:bg-yellow-600">
                                            Edit
                                        </a>

                                        <form action="{{ route('buku.destroy', $book->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus buku ini?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="rounded bg-red-600 px-3 py-1 text-xs font-medium text-white hover:bg-red-700">
                                                Hapus
                                            </button>

                                        </form>

                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="px-5 py-8 text-center text-slate-500">
                                    Data buku belum tersedia.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="border-t border-slate-200 px-5 py-4">
                {{ $books->links() }}
            </div>
        </section>
    </div>
</x-layouts.dashboard>

<x-layouts.dashboard title="Data Kategori">

    <div class="space-y-5">

        {{-- HEADER --}}
        <section class="rounded-md border border-slate-200 bg-white p-5 shadow-sm">

            <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">

                <div>
                    <p class="text-sm font-semibold uppercase tracking-wide text-emerald-700">
                        Katalog
                    </p>

                    <h2 class="mt-1 text-2xl font-semibold text-slate-950">
                        Data Kategori
                    </h2>
                </div>

                <a href="{{ route('kategori.create') }}"
                    class="w-fit rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">
                    + Tambah Kategori
                </a>

            </div>

        </section>

        {{-- TABLE --}}
        <section class="rounded-md border border-slate-200 bg-white shadow-sm">

            <div class="overflow-x-auto">

                <table class="min-w-full divide-y divide-slate-200 text-sm">

                    <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                        <tr>
                            <th class="px-5 py-3">No</th>
                            <th class="px-5 py-3">Nama Kategori</th>
                            <th class="px-5 py-3">Deskripsi</th>
                            <th class="px-5 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">

                        @forelse ($kategori as $k)
                            <tr>

                                <td class="px-5 py-4 font-medium text-slate-950">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="px-5 py-4 text-slate-700">
                                    {{ $k->nama_kategori }}
                                </td>

                                <td class="px-5 py-4 text-slate-600">
                                    {{ $k->deskripsi ?? '-' }}
                                </td>

                                <td class="px-5 py-4">
                                    <div class="flex items-center justify-center gap-2">

                                        <a href="{{ route('kategori.edit', $k->id) }}"
                                            class="rounded bg-yellow-500 px-3 py-1 text-xs font-medium text-white hover:bg-yellow-600">
                                            Edit
                                        </a>

                                        <form action="{{ route('kategori.destroy', $k->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">

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
                                <td colspan="4" class="px-5 py-8 text-center text-slate-500">
                                    Data kategori belum tersedia.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

            {{-- PAGINATION --}}
            <div class="border-t border-slate-200 px-5 py-4">
                {{ $kategori->links() }}
            </div>

        </section>

    </div>

</x-layouts.dashboard>

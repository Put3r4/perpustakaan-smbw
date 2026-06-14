<x-layouts.dashboard title="Data Rak Buku">

    <div class="space-y-5">

        {{-- HEADER --}}
        <section class="rounded-md border border-slate-200 bg-white p-5 shadow-sm">

            <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">

                <div>
                    <p class="text-sm font-semibold uppercase tracking-wide text-emerald-700">
                        Katalog
                    </p>

                    <h2 class="mt-1 text-2xl font-semibold text-slate-950">
                        Data Rak Buku
                    </h2>
                </div>

                <a href="{{ route('rak.create') }}"
                    class="w-fit rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">
                    + Tambah Rak
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
                            <th class="px-5 py-3">Kode Rak</th>
                            <th class="px-5 py-3">Nama Rak</th>
                            <th class="px-5 py-3">Lokasi</th>

                            {{-- TAMBAHAN --}}
                            <th class="px-5 py-3 text-center">Jumlah Buku</th>

                            <th class="px-5 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">

                        @forelse ($rak as $r)
                            <tr>

                                <td class="px-5 py-4 font-medium text-slate-950">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="px-5 py-4 text-slate-700">
                                    {{ $r->kode_rak }}
                                </td>

                                <td class="px-5 py-4 text-slate-700">
                                    {{ $r->nama_rak }}
                                </td>

                                <td class="px-5 py-4 text-slate-600">
                                    {{ $r->lokasi ?? '-' }}
                                </td>

                                {{-- JUMLAH BUKU --}}
                                <td class="px-5 py-4 text-center">
                                    <span
                                        class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                                        {{ $r->buku_count ?? 0 }} Buku
                                    </span>
                                </td>

                                <td class="px-5 py-4">
                                    <div class="flex items-center justify-center gap-2">

                                        <a href="{{ route('rak.edit', $r->id) }}"
                                            class="rounded bg-yellow-500 px-3 py-1 text-xs font-medium text-white hover:bg-yellow-600">
                                            Edit
                                        </a>

                                        <form action="{{ route('rak.destroy', $r->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus rak ini?')">

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
                                <td colspan="6" class="px-5 py-8 text-center text-slate-500">
                                    Data rak belum tersedia.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="border-t border-slate-200 px-5 py-4">
                {{ $rak->links() }}
            </div>

        </section>

    </div>

</x-layouts.dashboard>

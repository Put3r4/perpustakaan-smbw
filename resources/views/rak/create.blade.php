<x-layouts.dashboard title="Tambah Rak Buku">

    <div class="rounded-lg bg-white p-6 shadow">

        <h1 class="mb-6 text-2xl font-bold">Tambah Rak Buku</h1>

        <form action="{{ route('rak.store') }}" method="POST">
            @csrf

            <div class="grid gap-4">

                <div>
                    <label class="mb-1 block text-sm font-medium">Kode Rak</label>
                    <input type="text" name="kode_rak"
                           class="w-full rounded border p-2">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium">Nama Rak</label>
                    <input type="text" name="nama_rak"
                           class="w-full rounded border p-2">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium">Lokasi</label>
                    <input type="text" name="lokasi"
                           class="w-full rounded border p-2">
                </div>

                <div class="flex gap-2">

                    <button type="submit"
                            class="rounded bg-emerald-600 px-4 py-2 text-white">
                        Simpan
                    </button>

                    <a href="{{ route('buku.rak.index') }}"
                       class="rounded bg-slate-500 px-4 py-2 text-white">
                        Kembali
                    </a>

                </div>

            </div>

        </form>

    </div>

</x-layouts.dashboard>

<x-layouts.dashboard title="Edit Rak Buku">

    <div class="rounded-lg bg-white p-6 shadow">

        <h1 class="mb-6 text-2xl font-bold">Edit Rak Buku</h1>

        <form action="{{ route('rak.update', $rak->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid gap-4">

                <div>
                    <label>Kode Rak</label>
                    <input type="text" name="kode_rak" value="{{ old('kode_rak', $rak->kode_rak) }}"
                        class="w-full rounded border p-2">
                </div>

                <div>
                    <label>Nama Rak</label>
                    <input type="text" name="nama_rak" value="{{ old('nama_rak', $rak->nama_rak) }}"
                        class="w-full rounded border p-2">
                </div>

                <div>
                    <label>Lokasi</label>
                    <input type="text" name="lokasi" value="{{ old('lokasi', $rak->lokasi) }}"
                        class="w-full rounded border p-2">
                </div>

                <div class="flex gap-2">

                    <button class="rounded bg-emerald-600 px-4 py-2 text-white">
                        Update
                    </button>

                    <a href="{{ route('buku.rak.index') }}" class="rounded bg-slate-500 px-4 py-2 text-white">
                        Kembali
                    </a>

                </div>

            </div>

        </form>

    </div>

</x-layouts.dashboard>

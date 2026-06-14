<x-layouts.dashboard title="Tambah Buku">

    <div class="rounded-lg bg-white p-6 shadow">

        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-slate-800">
                Tambah Buku
            </h1>

            <a href="{{ route('buku.index') }}" class="rounded-lg bg-slate-500 px-4 py-2 text-white hover:bg-slate-600">
                Kembali
            </a>
        </div>

        @if ($errors->any())
            <div class="mb-5 rounded-lg bg-red-100 p-4 text-red-700">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('buku.store') }}" method="POST" enctype="multipart/form-data">

            @csrf

            <div class="grid gap-5 md:grid-cols-2">

                <div>
                    <label class="mb-1 block font-medium">
                        Kode Buku
                    </label>
                    <input type="text" name="kode_buku" value="{{ old('kode_buku') }}"
                        class="w-full rounded-lg border p-2">
                </div>

                <div>
                    <label class="mb-1 block font-medium">
                        ISBN
                    </label>
                    <input type="text" name="isbn" value="{{ old('isbn') }}"
                        class="w-full rounded-lg border p-2">
                </div>

                <div class="md:col-span-2">
                    <label class="mb-1 block font-medium">
                        Judul Buku
                    </label>
                    <input type="text" name="judul" value="{{ old('judul') }}"
                        class="w-full rounded-lg border p-2">
                </div>

                <div>
                    <label class="mb-1 block font-medium">
                        Pengarang
                    </label>
                    <input type="text" name="pengarang" value="{{ old('pengarang') }}"
                        class="w-full rounded-lg border p-2">
                </div>

                <div>
                    <label class="mb-1 block font-medium">
                        Penerbit
                    </label>
                    <input type="text" name="penerbit" value="{{ old('penerbit') }}"
                        class="w-full rounded-lg border p-2">
                </div>

                <div>
                    <label class="mb-1 block font-medium">
                        Kota Terbit
                    </label>
                    <input type="text" name="kota_terbit" value="{{ old('kota_terbit') }}"
                        class="w-full rounded-lg border p-2">
                </div>

                <div>
                    <label class="mb-1 block font-medium">
                        Tahun Terbit
                    </label>
                    <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit') }}"
                        class="w-full rounded-lg border p-2">
                </div>

                <div>
                    <label class="mb-1 block font-medium">
                        Bahasa
                    </label>
                    <input type="text" name="bahasa" value="{{ old('bahasa', 'Indonesia') }}"
                        class="w-full rounded-lg border p-2">
                </div>

                <div>
                    <label class="mb-1 block font-medium">
                        Jumlah Eksemplar
                    </label>
                    <input type="number" name="jumlah_eksemplar" value="{{ old('jumlah_eksemplar', 1) }}"
                        class="w-full rounded-lg border p-2">
                </div>

                <div>
                    <label class="mb-1 block font-medium">
                        Stok Tersedia
                    </label>
                    <input type="number" name="stok_tersedia" value="{{ old('stok_tersedia', 1) }}"
                        class="w-full rounded-lg border p-2">
                </div>

                <div>
                    <label class="mb-1 block font-medium">
                        Status
                    </label>

                    <select name="status" class="w-full rounded-lg border p-2">

                        <option value="tersedia">
                            Tersedia
                        </option>

                        <option value="tidak tersedia">
                            Tidak Tersedia
                        </option>

                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="mb-1 block font-medium">
                        Cover Buku
                    </label>

                    <input type="file" name="cover_buku" class="w-full rounded-lg border p-2">
                </div>

                <div class="md:col-span-2">
                    <label class="mb-1 block font-medium">
                        Deskripsi
                    </label>

                    <textarea name="deskripsi" rows="4" class="w-full rounded-lg border p-2">{{ old('deskripsi') }}</textarea>
                </div>

            </div>

            <div class="mt-6 flex gap-2">

                <button type="submit" class="rounded-lg bg-emerald-600 px-5 py-2 text-white hover:bg-emerald-700">
                    Simpan Buku
                </button>

                <a href="{{ route('buku.index') }}"
                    class="rounded-lg bg-slate-500 px-5 py-2 text-white hover:bg-slate-600">
                    Batal
                </a>

            </div>

        </form>

    </div>

</x-layouts.dashboard>

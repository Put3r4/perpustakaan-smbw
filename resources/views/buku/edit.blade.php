<x-layouts.dashboard title="Edit Buku">

    <div class="rounded-lg bg-white p-6 shadow">

        <h1 class="mb-6 text-2xl font-bold">
            Edit Buku
        </h1>

        {{-- ERROR VALIDASI --}}
        @if ($errors->any())
            <div class="mb-4 rounded bg-red-100 p-3 text-red-600">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('buku.update', $buku->id) }}" method="POST" enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="grid gap-4">

                {{-- KODE BUKU --}}
                <div>
                    <label class="mb-1 block text-sm font-medium">Kode Buku</label>
                    <input type="text" name="kode_buku" value="{{ old('kode_buku', $buku->kode_buku) }}"
                        class="w-full rounded border p-2">
                </div>

                {{-- JUDUL --}}
                <div>
                    <label class="mb-1 block text-sm font-medium">Judul Buku</label>
                    <input type="text" name="judul" value="{{ old('judul', $buku->judul) }}"
                        class="w-full rounded border p-2">
                </div>

                {{-- PENGARANG --}}
                <div>
                    <label class="mb-1 block text-sm font-medium">Pengarang</label>
                    <input type="text" name="pengarang" value="{{ old('pengarang', $buku->pengarang) }}"
                        class="w-full rounded border p-2">
                </div>

                {{-- PENERBIT --}}
                <div>
                    <label class="mb-1 block text-sm font-medium">Penerbit</label>
                    <input type="text" name="penerbit" value="{{ old('penerbit', $buku->penerbit) }}"
                        class="w-full rounded border p-2">
                </div>

                {{-- TAHUN TERBIT --}}
                <div>
                    <label class="mb-1 block text-sm font-medium">Tahun Terbit</label>
                    <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit', $buku->tahun_terbit) }}"
                        class="w-full rounded border p-2">
                </div>

                {{-- KOTA TERBIT --}}
                <div>
                    <label class="mb-1 block text-sm font-medium">Kota Terbit</label>
                    <input type="text" name="kota_terbit" value="{{ old('kota_terbit', $buku->kota_terbit) }}"
                        class="w-full rounded border p-2">
                </div>

                {{-- BAHASA --}}
                <div>
                    <label class="mb-1 block text-sm font-medium">Bahasa</label>
                    <input type="text" name="bahasa" value="{{ old('bahasa', $buku->bahasa) }}"
                        class="w-full rounded border p-2">
                </div>

                {{-- JUMLAH EKSEMPLAR --}}
                <div>
                    <label class="mb-1 block text-sm font-medium">Jumlah Eksemplar</label>
                    <input type="number" name="jumlah_eksemplar"
                        value="{{ old('jumlah_eksemplar', $buku->jumlah_eksemplar) }}"
                        class="w-full rounded border p-2">
                </div>

                {{-- STOK TERSEDIA --}}
                <div>
                    <label class="mb-1 block text-sm font-medium">Stok Tersedia</label>
                    <input type="number" name="stok_tersedia" value="{{ old('stok_tersedia', $buku->stok_tersedia) }}"
                        class="w-full rounded border p-2">
                </div>

                {{-- COVER BUKU --}}
                <div>
                    <label class="mb-1 block text-sm font-medium">Cover Buku</label>

                    @if ($buku->cover_buku)
                        <img src="{{ asset('storage/' . $buku->cover_buku) }}" class="mb-3 h-32 rounded border">
                    @endif

                    <input type="file" name="cover_buku" class="w-full rounded border p-2">
                </div>

                {{-- BUTTON --}}
                <div class="flex gap-2">

                    <button type="submit" class="rounded bg-emerald-600 px-4 py-2 text-white hover:bg-emerald-700">
                        Simpan Perubahan
                    </button>

                    <a href="{{ route('buku.index') }}"
                        class="rounded bg-slate-500 px-4 py-2 text-white hover:bg-slate-600">
                        Kembali
                    </a>

                </div>

            </div>

        </form>

    </div>

</x-layouts.dashboard>

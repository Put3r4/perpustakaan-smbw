<x-layouts.dashboard title="Tambah Kategori">

<div class="rounded-lg bg-white p-6 shadow">

    <h1 class="mb-4 text-2xl font-bold">Tambah Kategori</h1>

    <form action="{{ route('kategori.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Nama Kategori</label>
            <input type="text" name="nama_kategori"
                   class="w-full rounded border p-2">
        </div>

        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi"
                      class="w-full rounded border p-2"></textarea>
        </div>

        <button class="rounded bg-emerald-600 px-4 py-2 text-white">
            Simpan
        </button>
    </form>

</div>

</x-layouts.dashboard>

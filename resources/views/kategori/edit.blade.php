<x-layouts.dashboard title="Edit Kategori">

<div class="rounded-lg bg-white p-6 shadow">

    <h1 class="mb-4 text-2xl font-bold">Edit Kategori</h1>

    <form action="{{ route('kategori.update', $kategori->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nama Kategori</label>
            <input type="text"
                   name="nama_kategori"
                   value="{{ old('nama_kategori', $kategori->nama_kategori) }}"
                   class="w-full rounded border p-2">
        </div>

        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi"
                      class="w-full rounded border p-2">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
        </div>

        <button class="rounded bg-emerald-600 px-4 py-2 text-white">
            Update
        </button>

    </form>

</div>

</x-layouts.dashboard>

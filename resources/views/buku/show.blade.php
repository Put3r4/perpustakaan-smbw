<x-layouts.dashboard title="Detail Buku">

    <div class="space-y-6">

        <div class="rounded-lg bg-white p-6 shadow">
            <div class="flex items-start gap-6">

                <div>
                    @if ($buku->cover_buku)
                        <img src="{{ asset('storage/' . $buku->cover_buku) }}" alt="{{ $buku->judul }}"
                            class="w-48 rounded-lg border shadow">
                    @else
                        <div
                            class="flex h-64 w-48 items-center justify-center rounded-lg border bg-slate-100 text-slate-500">
                            No Cover
                        </div>
                    @endif
                </div>

                <div class="flex-1">

                    <h1 class="mb-4 text-3xl font-bold text-slate-800">
                        {{ $buku->judul }}
                    </h1>

                    <div class="grid gap-3 md:grid-cols-2">

                        <div>
                            <span class="font-semibold">Kode Buku :</span>
                            {{ $buku->kode_buku }}
                        </div>

                        <div>
                            <span class="font-semibold">ISBN :</span>
                            {{ $buku->isbn ?? '-' }}
                        </div>

                        <div>
                            <span class="font-semibold">Pengarang :</span>
                            {{ $buku->pengarang }}
                        </div>

                        <div>
                            <span class="font-semibold">Penerbit :</span>
                            {{ $buku->penerbit }}
                        </div>

                        <div>
                            <span class="font-semibold">Tahun Terbit :</span>
                            {{ $buku->tahun_terbit }}
                        </div>

                        <div>
                            <span class="font-semibold">Stok :</span>
                            {{ $buku->stok_tersedia }}
                        </div>

                        <div>
                            <span class="font-semibold">Status :</span>
                            {{ $buku->status }}
                        </div>

                    </div>

                    <div class="mt-6 flex gap-2">

                        <a href="{{ route('buku.edit', $buku->id) }}"
                            class="rounded bg-yellow-500 px-4 py-2 text-white hover:bg-yellow-600">
                            Edit Buku
                        </a>

                        <a href="{{ route('buku.index') }}"
                            class="rounded bg-slate-600 px-4 py-2 text-white hover:bg-slate-700">
                            Kembali
                        </a>

                    </div>

                </div>

            </div>
        </div>

    </div>

</x-layouts.dashboard>

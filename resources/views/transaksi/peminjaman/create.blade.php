<x-layouts.dashboard title="Tambah Peminjaman Buku">

    <div class="mb-4 flex items-center gap-2 text-sm text-slate-500">
        <a href="{{ route('transaksi.peminjaman.index') }}" class="hover:text-emerald-700">Peminjaman</a>
        <span>/</span>
        <span class="text-slate-700">Tambah Baru</span>
    </div>

    @if (session('error'))
        <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            {{ session('error') }}
        </div>
    @endif

    <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
        <h2 class="mb-1 text-base font-semibold text-slate-900">Form Peminjaman Buku</h2>
        <p class="mb-6 text-sm text-slate-500">Isi data peminjaman buku. Tanggal pinjam dan jatuh tempo diisi otomatis.</p>

        <form method="POST" action="{{ route('transaksi.peminjaman.store') }}" x-data="peminjamanForm()">
            @csrf

            <div class="grid grid-cols-1 gap-5 lg:grid-cols-2">

                {{-- TIPE ANGGOTA --}}
                <div class="lg:col-span-2">
                    <label class="mb-1 block text-sm font-medium text-slate-700">Tipe Anggota <span class="text-red-500">*</span></label>
                    <div class="flex gap-4">
                        <label class="flex cursor-pointer items-center gap-2">
                            <input type="radio" name="tipe_anggota" value="pelajar"
                                   x-model="tipeAnggota"
                                   class="text-emerald-600 focus:ring-emerald-500"
                                   {{ old('tipe_anggota', 'pelajar') === 'pelajar' ? 'checked' : '' }}>
                            <span class="text-sm text-slate-700">Pelajar</span>
                        </label>
                        <label class="flex cursor-pointer items-center gap-2">
                            <input type="radio" name="tipe_anggota" value="non_pelajar"
                                   x-model="tipeAnggota"
                                   class="text-emerald-600 focus:ring-emerald-500"
                                   {{ old('tipe_anggota') === 'non_pelajar' ? 'checked' : '' }}>
                            <span class="text-sm text-slate-700">Non Pelajar</span>
                        </label>
                    </div>
                    @error('tipe_anggota')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- DROPDOWN ANGGOTA PELAJAR --}}
                <div x-show="tipeAnggota === 'pelajar'">
                    <label for="anggota_pelajar_id" class="mb-1 block text-sm font-medium text-slate-700">Anggota Pelajar <span class="text-red-500">*</span></label>
                    <select id="anggota_pelajar_id" name="anggota_id"
                            x-bind:required="tipeAnggota === 'pelajar'"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500">
                        <option value="">-- Pilih Anggota Pelajar --</option>
                        @foreach ($anggotaPelajar as $ap)
                            <option value="{{ $ap->id }}" {{ old('anggota_id') == $ap->id ? 'selected' : '' }}>
                                {{ $ap->nama_anggota }} ({{ $ap->no_anggota }})
                            </option>
                        @endforeach
                    </select>
                    @error('anggota_id')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- DROPDOWN ANGGOTA NON PELAJAR --}}
                <div x-show="tipeAnggota === 'non_pelajar'">
                    <label for="anggota_non_pelajar_id" class="mb-1 block text-sm font-medium text-slate-700">Anggota Non Pelajar <span class="text-red-500">*</span></label>
                    <select id="anggota_non_pelajar_id" name="anggota_id"
                            x-bind:required="tipeAnggota === 'non_pelajar'"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500">
                        <option value="">-- Pilih Anggota Non Pelajar --</option>
                        @foreach ($anggotaNonPelajar as $anp)
                            <option value="{{ $anp->id }}" {{ old('anggota_id') == $anp->id ? 'selected' : '' }}>
                                {{ $anp->nama_anggota }} ({{ $anp->no_anggota }})
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- BUKU --}}
                <div>
                    <label for="buku_id" class="mb-1 block text-sm font-medium text-slate-700">Buku <span class="text-red-500">*</span></label>
                    <select id="buku_id" name="buku_id" required
                            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500">
                        <option value="">-- Pilih Buku --</option>
                        @foreach ($bukuTersedia as $buku)
                            <option value="{{ $buku->id }}" {{ old('buku_id') == $buku->id ? 'selected' : '' }}>
                                {{ $buku->judul }} — Stok: {{ $buku->stok_tersedia }}
                            </option>
                        @endforeach
                    </select>
                    @error('buku_id')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- PETUGAS --}}
                <div>
                    <label for="petugas_id" class="mb-1 block text-sm font-medium text-slate-700">Petugas Peminjaman <span class="text-red-500">*</span></label>
                    <select id="petugas_id" name="petugas_id" required
                            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500">
                        <option value="">-- Pilih Petugas --</option>
                        @foreach ($petugasList as $petugas)
                            <option value="{{ $petugas->id }}" {{ old('petugas_id') == $petugas->id ? 'selected' : '' }}>
                                {{ $petugas->nama_petugas }} ({{ $petugas->kode_petugas }})
                            </option>
                        @endforeach
                    </select>
                    @error('petugas_id')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- INFO OTOMATIS --}}
                <div class="lg:col-span-2">
                    <div class="rounded-lg border border-dashed border-slate-200 bg-slate-50 p-4">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500 mb-2">Informasi Otomatis Sistem</p>
                        <div class="grid grid-cols-1 gap-2 sm:grid-cols-3 text-sm">
                            <div>
                                <span class="text-slate-500">Tanggal Pinjam:</span>
                                <span class="ml-1 font-medium text-slate-800">{{ now()->format('d/m/Y') }}</span>
                            </div>
                            <div>
                                <span class="text-slate-500">Jatuh Tempo:</span>
                                <span class="ml-1 font-medium text-slate-800">{{ now()->addDays(7)->format('d/m/Y') }}</span>
                            </div>
                            <div>
                                <span class="text-slate-500">Kode Transaksi:</span>
                                <span class="ml-1 font-medium text-slate-800">TRX-{{ now()->format('Ymd') }}-XXXX</span>
                            </div>
                        </div>
                        <p class="mt-2 text-xs text-slate-400">Denda keterlambatan: Rp500 per hari. Maks. 2 buku aktif per anggota.</p>
                    </div>
                </div>

            </div>

            <div class="mt-6 flex gap-3">
                <button type="submit"
                        class="rounded-lg bg-emerald-600 px-5 py-2 text-sm font-medium text-white hover:bg-emerald-700">
                    Simpan Peminjaman
                </button>
                <a href="{{ route('transaksi.peminjaman.index') }}"
                   class="rounded-lg border border-slate-300 px-5 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
                    Batal
                </a>
            </div>
        </form>
    </div>

    <script>
        function peminjamanForm() {
            return {
                tipeAnggota: '{{ old('tipe_anggota', 'pelajar') }}',
            };
        }
    </script>

</x-layouts.dashboard>

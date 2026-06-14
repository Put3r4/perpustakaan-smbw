<x-layouts.dashboard title="Proses Pengembalian Buku">

    <div class="mb-4 flex items-center gap-2 text-sm text-slate-500">
        <a href="{{ route('transaksi.pengembalian.index') }}" class="hover:text-emerald-700">Pengembalian</a>
        <span>/</span>
        <span class="text-slate-700">Proses Pengembalian</span>
    </div>

    @if (session('error'))
        <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

        {{-- FORM PENGEMBALIAN --}}
        <div class="lg:col-span-2">
            <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="mb-1 text-base font-semibold text-slate-900">Konfirmasi Pengembalian</h2>
                <p class="mb-5 text-sm text-slate-500">Periksa detail transaksi dan pilih petugas yang memproses pengembalian.</p>

                {{-- DENDA ALERT --}}
                @if ($hariTerlambat > 0)
                    <div class="mb-5 rounded-lg border border-red-200 bg-red-50 p-4">
                        <div class="flex items-start gap-3">
                            <div class="mt-0.5 flex-shrink-0">
                                <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-red-700">Terlambat {{ $hariTerlambat }} Hari!</p>
                                <p class="text-sm text-red-600">
                                    Denda yang dikenakan: <strong>Rp {{ number_format($dendaSementara, 0, ',', '.') }}</strong>
                                    ({{ $hariTerlambat }} hari × Rp500)
                                </p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="mb-5 rounded-lg border border-emerald-200 bg-emerald-50 p-4">
                        <p class="text-sm font-medium text-emerald-700">✓ Tepat waktu — Tidak ada denda.</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('transaksi.pengembalian.store', ['type' => $type, 'id' => $transaksi->id]) }}">
                    @csrf

                    {{-- PETUGAS PENGEMBALIAN --}}
                    <div class="mb-5">
                        <label for="petugas_id" class="mb-1 block text-sm font-medium text-slate-700">
                            Petugas Pengembalian <span class="text-red-500">*</span>
                        </label>
                        <select id="petugas_id" name="petugas_id" required
                                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500">
                            <option value="">-- Pilih Petugas --</option>
                            @foreach ($petugasList as $petugas)
                                <option value="{{ $petugas->id }}">
                                    {{ $petugas->nama_petugas }} ({{ $petugas->kode_petugas }})
                                </option>
                            @endforeach
                        </select>
                        @error('petugas_id')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- INFO TANGGAL --}}
                    <div class="mb-5 rounded-lg bg-slate-50 p-4 text-sm">
                        <p class="font-semibold text-slate-700 mb-2">Ringkasan Pengembalian</p>
                        <div class="grid grid-cols-2 gap-2 text-slate-600">
                            <div><span class="text-slate-400">Tanggal Pinjam:</span> {{ \Carbon\Carbon::parse($transaksi->tgl_pinjam)->format('d/m/Y') }}</div>
                            <div><span class="text-slate-400">Jatuh Tempo:</span> {{ \Carbon\Carbon::parse($transaksi->tgl_jatuh_tempo)->format('d/m/Y') }}</div>
                            <div><span class="text-slate-400">Tanggal Kembali:</span> <strong>{{ now()->format('d/m/Y') }}</strong></div>
                            <div>
                                <span class="text-slate-400">Denda:</span>
                                <strong class="{{ $dendaSementara > 0 ? 'text-red-600' : 'text-emerald-600' }}">
                                    Rp {{ number_format($dendaSementara, 0, ',', '.') }}
                                </strong>
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <button type="submit"
                                onclick="return confirm('Konfirmasi pengembalian buku ini?')"
                                class="rounded-lg bg-emerald-600 px-5 py-2 text-sm font-medium text-white hover:bg-emerald-700">
                            Konfirmasi Pengembalian
                        </button>
                        <a href="{{ route('transaksi.pengembalian.index') }}"
                           class="rounded-lg border border-slate-300 px-5 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>

        {{-- SIDEBAR DETAIL --}}
        <div class="space-y-4">
            {{-- Info Buku --}}
            <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                <p class="mb-3 text-xs font-semibold uppercase tracking-wide text-slate-400">Buku Dipinjam</p>
                <p class="font-semibold text-slate-900">{{ $transaksi->buku?->judul ?? '-' }}</p>
                <p class="text-sm text-slate-500">{{ $transaksi->buku?->pengarang ?? '' }}</p>
                <p class="mt-1 font-mono text-xs text-slate-400">{{ $transaksi->buku?->kode_buku ?? '' }}</p>
            </div>

            {{-- Info Anggota --}}
            <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                <p class="mb-3 text-xs font-semibold uppercase tracking-wide text-slate-400">Anggota</p>
                <p class="font-semibold text-slate-900">{{ $transaksi->anggota?->nama_anggota ?? '-' }}</p>
                <p class="font-mono text-xs text-slate-400">{{ $transaksi->anggota?->no_anggota ?? '' }}</p>
                <p class="mt-1 text-xs text-slate-500">{{ $type === 'pelajar' ? 'Pelajar' : 'Non Pelajar' }}</p>
            </div>

            {{-- Kode Transaksi --}}
            <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400">Kode Transaksi</p>
                <p class="font-mono text-sm font-bold text-slate-800">{{ $transaksi->kode_transaksi }}</p>
            </div>
        </div>
    </div>

</x-layouts.dashboard>

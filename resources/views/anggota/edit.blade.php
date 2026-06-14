<x-layouts.dashboard title="Edit Anggota Pelajar">

<div class="max-w-6xl mx-auto">

    @if (session('error'))
        <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm">

        <div class="border-b border-slate-200 px-6 py-4">
            <h2 class="text-lg font-semibold text-slate-800">
                Form Edit Anggota Pelajar
            </h2>
            <p class="text-sm text-slate-500 mt-1">
                Perbarui data anggota: {{ $anggota->nama_anggota }}
            </p>
        </div>

        <form method="POST"
              action="{{ route('anggota.pelajar.update', $anggota) }}"
              class="p-6">

            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Nomor Anggota</label>
                    <input type="text" name="no_anggota"
                           value="{{ old('no_anggota', $anggota->no_anggota) }}"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2 @error('no_anggota') border-red-500 @enderror">
                    @error('no_anggota')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">NIM / NIS</label>
                    <input type="text" name="nim_nis"
                           value="{{ old('nim_nis', $anggota->nim_nis) }}"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2 @error('nim_nis') border-red-500 @enderror">
                    @error('nim_nis')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Nama Anggota</label>
                    <input type="text" name="nama_anggota"
                           value="{{ old('nama_anggota', $anggota->nama_anggota) }}"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2 @error('nama_anggota') border-red-500 @enderror">
                    @error('nama_anggota')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Asal Sekolah</label>
                    <input type="text" name="asal_sekolah"
                           value="{{ old('asal_sekolah', $anggota->asal_sekolah) }}"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2 @error('asal_sekolah') border-red-500 @enderror">
                    @error('asal_sekolah')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir"
                           value="{{ old('tanggal_lahir', optional($anggota->tanggal_lahir)->format('Y-m-d')) }}"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2 @error('tanggal_lahir') border-red-500 @enderror">
                    @error('tanggal_lahir')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Kode Pos</label>
                    <input type="text" name="kode_pos"
                           value="{{ old('kode_pos', $anggota->kode_pos) }}"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2 @error('kode_pos') border-red-500 @enderror">
                    @error('kode_pos')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Alamat</label>
                    <textarea name="alamat" rows="3"
                              class="w-full rounded-lg border border-slate-300 px-3 py-2 @error('alamat') border-red-500 @enderror">{{ old('alamat', $anggota->alamat) }}</textarea>
                    @error('alamat')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Telepon 1</label>
                    <input type="text" name="no_telp1"
                           value="{{ old('no_telp1', $anggota->no_telp1) }}"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2 @error('no_telp1') border-red-500 @enderror">
                    @error('no_telp1')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Telepon 2 (opsional)</label>
                    <input type="text" name="no_telp2"
                           value="{{ old('no_telp2', $anggota->no_telp2) }}"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2 @error('no_telp2') border-red-500 @enderror">
                    @error('no_telp2')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Nama Orang Tua</label>
                    <input type="text" name="nama_ortu"
                           value="{{ old('nama_ortu', $anggota->nama_ortu) }}"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2 @error('nama_ortu') border-red-500 @enderror">
                    @error('nama_ortu')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Telepon Orang Tua</label>
                    <input type="text" name="no_telp_ortu"
                           value="{{ old('no_telp_ortu', $anggota->no_telp_ortu) }}"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2 @error('no_telp_ortu') border-red-500 @enderror">
                    @error('no_telp_ortu')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Alamat Orang Tua</label>
                    <textarea name="alamat_ortu" rows="3"
                              class="w-full rounded-lg border border-slate-300 px-3 py-2 @error('alamat_ortu') border-red-500 @enderror">{{ old('alamat_ortu', $anggota->alamat_ortu) }}</textarea>
                    @error('alamat_ortu')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="md:col-span-2 border-t border-slate-200 pt-6">
                    <h3 class="text-sm font-semibold text-slate-800 mb-4">Akun Login Anggota</h3>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Email</label>
                    <input type="email" name="email"
                           value="{{ old('email', $anggota->user?->email) }}"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2 @error('email') border-red-500 @enderror">
                    @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Password Baru (opsional)</label>
                    <input type="password" name="password"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2 @error('password') border-red-500 @enderror">
                    @error('password')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2">
                </div>

            </div>

            <div class="mt-8 flex justify-end gap-3">
                <a href="{{ route('anggota.pelajar.index') }}"
                   class="px-4 py-2 rounded-lg border border-slate-300">
                    Batal
                </a>
                <button type="submit"
                        class="px-5 py-2 rounded-lg bg-emerald-600 text-white hover:bg-emerald-700">
                    Simpan Perubahan
                </button>
            </div>

        </form>

    </div>

</div>

</x-layouts.dashboard>

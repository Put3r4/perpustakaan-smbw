<x-layouts.dashboard title="Tambah Anggota Non Pelajar">

<div class="max-w-6xl mx-auto">

    @if (session('error'))
        <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm">

        <div class="border-b border-slate-200 px-6 py-4">
            <h2 class="text-lg font-semibold text-slate-800">
                Form Tambah Anggota Non Pelajar
            </h2>
            <p class="text-sm text-slate-500 mt-1">
                Lengkapi data anggota umum dan akun login perpustakaan.
            </p>
        </div>

        <form method="POST"
              action="{{ route('anggota.non-pelajar.store') }}"
              class="p-6">

            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Nomor Anggota</label>
                    <input type="text" name="no_anggota" value="{{ old('no_anggota') }}"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2 @error('no_anggota') border-red-500 @enderror">
                    @error('no_anggota')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Nama Anggota</label>
                    <input type="text" name="nama_anggota" value="{{ old('nama_anggota') }}"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2 @error('nama_anggota') border-red-500 @enderror">
                    @error('nama_anggota')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Pekerjaan</label>
                    <input type="text" name="pekerjaan" value="{{ old('pekerjaan') }}"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2 @error('pekerjaan') border-red-500 @enderror">
                    @error('pekerjaan')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">NIK</label>
                    <input type="text" name="nik" value="{{ old('nik') }}"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2 @error('nik') border-red-500 @enderror">
                    @error('nik')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Tempat, Tanggal Lahir (TTL)</label>
                    <input type="text" name="ttl" value="{{ old('ttl') }}" placeholder="Contoh: Sumbawa, 17 Agustus 1995"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2 @error('ttl') border-red-500 @enderror">
                    @error('ttl')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Kode Pos</label>
                    <input type="text" name="kode_pos" value="{{ old('kode_pos') }}"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2 @error('kode_pos') border-red-500 @enderror">
                    @error('kode_pos')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Alamat</label>
                    <textarea name="alamat" rows="3"
                              class="w-full rounded-lg border border-slate-300 px-3 py-2 @error('alamat') border-red-500 @enderror">{{ old('alamat') }}</textarea>
                    @error('alamat')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Nomor Telepon 1</label>
                    <input type="text" name="no_telp1" value="{{ old('no_telp1') }}"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2 @error('no_telp1') border-red-500 @enderror">
                    @error('no_telp1')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Nomor Telepon 2 (opsional)</label>
                    <input type="text" name="no_telp2" value="{{ old('no_telp2') }}"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2 @error('no_telp2') border-red-500 @enderror">
                    @error('no_telp2')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="md:col-span-2 border-t border-slate-200 pt-6">
                    <h3 class="text-sm font-semibold text-slate-800 mb-4">Akun Login Anggota</h3>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2 @error('email') border-red-500 @enderror">
                    @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Password</label>
                    <input type="password" name="password"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2 @error('password') border-red-500 @enderror">
                    @error('password')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2">
                </div>

            </div>

            <div class="mt-8 flex justify-end gap-3">
                <a href="{{ route('anggota.non-pelajar.index') }}"
                   class="px-4 py-2 rounded-lg border border-slate-300">
                    Batal
                </a>
                <button type="submit"
                        class="px-5 py-2 rounded-lg bg-emerald-600 text-white hover:bg-emerald-700">
                    Simpan Data
                </button>
            </div>

        </form>

    </div>

</div>

</x-layouts.dashboard>

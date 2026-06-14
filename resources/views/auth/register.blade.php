<x-layouts.app title="Registrasi Anggota">
    <section class="mx-auto flex min-h-[calc(100vh-73px)] max-w-lg items-center px-4 py-10">
        <div class="w-full rounded-md border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-wide text-emerald-700">Keanggotaan</p>
            <h1 class="mt-2 text-2xl font-semibold text-slate-950">Registrasi Anggota</h1>

            <form method="POST" action="{{ route('register') }}" class="mt-6 space-y-4">
                @csrf
                
                {{-- Input Nama --}}
                <div>
                    <label for="name" class="text-sm font-medium text-slate-700">Nama</label>
                    <input id="name" name="name" value="{{ old('name') }}" required class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100">
                    @error('name')
                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Input Email --}}
                <div>
                    <label for="email" class="text-sm font-medium text-slate-700">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100">
                    @error('email')
                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Pilihan Jenis Anggota --}}
                <div>
                    <label for="role" class="text-sm font-medium text-slate-700">Jenis Anggota</label>
                    <select id="role" name="role" required class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100">
                        <option value="pelajar" @selected(old('role', 'pelajar') === 'pelajar')>Pelajar</option>
                        <option value="non_pelajar" @selected(old('role') === 'non_pelajar')>Non Pelajar</option>
                    </select>
                    @error('role')
                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- DUST DYNAMIC INPUT: Group Fields Pelajar --}}
                <div id="group-pelajar" class="{{ old('role', 'pelajar') === 'pelajar' ? '' : 'hidden' }} space-y-4">
                    <div>
                        <label for="nim_nis" class="text-sm font-medium text-slate-700">NIM / NIS</label>
                        <input id="nim_nis" name="nim_nis" value="{{ old('nim_nis') }}" class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100">
                        @error('nim_nis')
                            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="asal_sekolah" class="text-sm font-medium text-slate-700">Asal Sekolah / Kampus</label>
                        <input id="asal_sekolah" name="asal_sekolah" value="{{ old('asal_sekolah') }}" class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100">
                        @error('asal_sekolah')
                            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- DUST DYNAMIC INPUT: Group Fields Non-Pelajar --}}
                <div id="group-non_pelajar" class="{{ old('role') === 'non_pelajar' ? '' : 'hidden' }} space-y-4">
                    <div>
                        <label for="nik" class="text-sm font-medium text-slate-700">NIK (No. KTP)</label>
                        <input id="nik" name="nik" value="{{ old('nik') }}" class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100">
                        @error('nik')
                            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="pekerjaan" class="text-sm font-medium text-slate-700">Pekerjaan</label>
                        <input id="pekerjaan" name="pekerjaan" value="{{ old('pekerjaan') }}" class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100">
                        @error('pekerjaan')
                            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Input Password & Konfirmasi --}}
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label for="password" class="text-sm font-medium text-slate-700">Password</label>
                        <input id="password" name="password" type="password" required class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100">
                        @error('password')
                            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="text-sm font-medium text-slate-700">Konfirmasi</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" required class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100">
                    </div>
                </div>

                <button type="submit" class="w-full rounded-md bg-emerald-700 px-4 py-2.5 text-sm font-semibold text-white hover:bg-emerald-800">Daftar</button>
            </form>
        </div>
    </section>

    {{-- Script JavaScript Sederhana untuk Toggle Tampilan --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const roleSelect = document.getElementById('role');
            const groupPelajar = document.getElementById('group-pelajar');
            const groupNonPelajar = document.getElementById('group-non_pelajar');

            function handleRoleFields() {
                if (roleSelect.value === 'pelajar') {
                    groupPelajar.classList.remove('hidden');
                    groupNonPelajar.classList.add('hidden');
                } else {
                    groupPelajar.classList.add('hidden');
                    groupNonPelajar.classList.remove('hidden');
                }
            }

            // Jalankan saat ada perubahan opsi select
            roleSelect.addEventListener('change', handleRoleFields);
        });
    </script>
</x-layouts.app>
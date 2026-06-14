<x-layouts.dashboard title="Edit Jadwal Piket">

    <div class="max-w-2xl bg-white rounded-lg shadow-sm border border-slate-200 p-6">
        <h2 class="text-xl font-bold text-slate-900 mb-6">Edit Jadwal Piket</h2>

        <form action="{{ route('operasional.petugas-shift.update', $petugasShift) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="petugas_id" class="block text-sm font-medium text-slate-700 mb-1">Pilih Petugas</label>
                <select name="petugas_id" id="petugas_id" class="w-full rounded border border-slate-300 p-2 focus:ring-emerald-500 focus:border-emerald-500 @error('petugas_id') border-red-500 @enderror">
                    <option value="">-- Pilih Petugas --</option>
                    @foreach($petugasList as $petugas)
                        <option value="{{ $petugas->id }}" {{ old('petugas_id', $petugasShift->petugas_id) == $petugas->id ? 'selected' : '' }}>
                            {{ $petugas->nama_petugas }} ({{ $petugas->jabatan }})
                        </option>
                    @endforeach
                </select>
                @error('petugas_id')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="tanggal" class="block text-sm font-medium text-slate-700 mb-1">Tanggal Piket</label>
                <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', $petugasShift->tanggal) }}" class="w-full rounded border border-slate-300 p-2 focus:ring-emerald-500 focus:border-emerald-500 @error('tanggal') border-red-500 @enderror">
                @error('tanggal')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="jam_mulai" class="block text-sm font-medium text-slate-700 mb-1">Jam Mulai</label>
                    <input type="time" name="jam_mulai" id="jam_mulai" value="{{ old('jam_mulai', \Carbon\Carbon::parse($petugasShift->jam_mulai)->format('H:i')) }}" class="w-full rounded border border-slate-300 p-2 focus:ring-emerald-500 focus:border-emerald-500 @error('jam_mulai') border-red-500 @enderror">
                    @error('jam_mulai')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="jam_selesai" class="block text-sm font-medium text-slate-700 mb-1">Jam Selesai</label>
                    <input type="time" name="jam_selesai" id="jam_selesai" value="{{ old('jam_selesai', \Carbon\Carbon::parse($petugasShift->jam_selesai)->format('H:i')) }}" class="w-full rounded border border-slate-300 p-2 focus:ring-emerald-500 focus:border-emerald-500 @error('jam_selesai') border-red-500 @enderror">
                    @error('jam_selesai')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex gap-3 pt-4 border-t">
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-colors">
                    Perbarui Jadwal
                </button>
                <a href="{{ route('operasional.petugas-shift.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2 rounded-lg text-sm font-semibold transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>

</x-layouts.dashboard>

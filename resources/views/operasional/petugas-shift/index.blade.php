<x-layouts.dashboard title="Jadwal Piket Petugas">

    @if (session('success'))
        <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-sm border border-slate-200">

        <div class="flex items-center justify-between p-6 border-b">
            <div>
                <h2 class="text-lg font-semibold">Jadwal Piket Petugas</h2>
                <p class="text-sm text-slate-500">Kelola jadwal shift piket petugas perpustakaan.</p>
            </div>

            <a href="{{ route('operasional.petugas-shift.create') }}"
               class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-colors">
                + Tambah Jadwal Piket
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50">
                    <tr class="text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                        <th class="px-6 py-3">No</th>
                        <th class="px-6 py-3">Nama Petugas</th>
                        <th class="px-6 py-3">Tanggal</th>
                        <th class="px-6 py-3">Jam Mulai</th>
                        <th class="px-6 py-3">Jam Selesai</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                @forelse($shifts as $index => $item)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4 text-slate-700">
                            {{ $shifts->firstItem() + $index }}
                        </td>
                        <td class="px-6 py-4 font-medium text-slate-900">
                            {{ $item->petugas?->nama_petugas ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-slate-700">
                            {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}
                        </td>
                        <td class="px-6 py-4 text-slate-700">
                            {{ \Carbon\Carbon::parse($item->jam_mulai)->format('H:i') }}
                        </td>
                        <td class="px-6 py-4 text-slate-700">
                            {{ \Carbon\Carbon::parse($item->jam_selesai)->format('H:i') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex gap-2 justify-center">
                                <a href="{{ route('operasional.petugas-shift.edit', $item) }}"
                                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-xs font-medium transition-colors">
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('operasional.petugas-shift.destroy', $item) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus jadwal piket ini?')"
                                            class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs font-medium transition-colors">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-slate-500">
                            Belum ada jadwal piket petugas yang didaftarkan.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        @if($shifts->hasPages())
            <div class="border-t border-slate-200 px-6 py-4">
                {{ $shifts->links() }}
            </div>
        @endif

    </div>

</x-layouts.dashboard>

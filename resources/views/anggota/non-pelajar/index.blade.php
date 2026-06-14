<x-layouts.dashboard title="Data Anggota Non Pelajar">

    @if (session('success'))
        <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-sm border border-slate-200">

        <div class="flex items-center justify-between p-6 border-b">
            <div>
                <h2 class="text-lg font-semibold">Daftar Anggota Non Pelajar</h2>
                <p class="text-sm text-slate-500">Kelola data anggota umum, pekerjaan, dan instansi.</p>
            </div>

            <a href="{{ route('anggota.non-pelajar.create') }}"
               class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg">
                + Tambah Anggota Non Pelajar
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left">No. Anggota</th>
                        <th class="px-6 py-3 text-left">NIK</th>
                        <th class="px-6 py-3 text-left">Nama</th>
                        <th class="px-6 py-3 text-left">Pekerjaan</th>
                        <th class="px-6 py-3 text-left">TTL</th>
                        <th class="px-6 py-3 text-left">Nomor Telepon</th>
                        <th class="px-6 py-3 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($anggota as $item)
                    <tr class="border-t">
                        <td class="px-6 py-4">{{ $item->no_anggota }}</td>
                        <td class="px-6 py-4">{{ $item->nik }}</td>
                        <td class="px-6 py-4">{{ $item->nama_anggota }}</td>
                        <td class="px-6 py-4">{{ $item->pekerjaan }}</td>
                        <td class="px-6 py-4">{{ $item->ttl }}</td>
                        <td class="px-6 py-4">{{ $item->no_telp1 }}</td>
                        <td class="px-6 py-4">
                            <div class="flex gap-2">
                                <a href="{{ route('anggota.non-pelajar.edit', $item) }}"
                                   class="bg-yellow-500 text-white px-3 py-1 rounded">
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('anggota.non-pelajar.destroy', $item) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Hapus data anggota ini?')"
                                            class="bg-red-600 text-white px-3 py-1 rounded">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-10 text-center text-slate-500">
                            Belum ada anggota non pelajar.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        @if ($anggota->hasPages())
            <div class="border-t px-6 py-4">
                {{ $anggota->links() }}
            </div>
        @endif

    </div>

</x-layouts.dashboard>

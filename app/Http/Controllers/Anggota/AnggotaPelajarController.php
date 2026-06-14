<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Http\Requests\Anggota\StoreAnggotaPelajarRequest;
use App\Http\Requests\Anggota\UpdateAnggotaPelajarRequest;
use App\Models\AnggotaPelajar;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Throwable;

class AnggotaPelajarController extends Controller
{
    public function index(): View
    {
        $anggota = AnggotaPelajar::query()
            ->with('user:id,name,email')
            ->latest('tgl_daftar')
            ->paginate(15);

        return view('anggota.index', compact('anggota'));
    }

    public function create(): View
    {
        return view('anggota.create');
    }

    public function store(StoreAnggotaPelajarRequest $request): RedirectResponse
    {
        try {
            DB::transaction(function () use ($request) {
                $validated = $request->validated();

                $user = User::create([
                    'name'     => $validated['nama_anggota'],
                    'email'    => $validated['email'],
                    'password' => Hash::make($validated['password']),
                    'role'     => 'pelajar',
                ]);

                AnggotaPelajar::create([
                    'user_id'       => $user->id,
                    'no_anggota'    => $validated['no_anggota'],
                    'nim_nis'       => $validated['nim_nis'],
                    'nama_anggota'  => $validated['nama_anggota'],
                    'asal_sekolah'  => $validated['asal_sekolah'],
                    'tanggal_lahir' => $validated['tanggal_lahir'],
                    'alamat'        => $validated['alamat'],
                    'kode_pos'      => $validated['kode_pos'] ?? null,
                    'no_telp1'      => $validated['no_telp1'],
                    'no_telp2'      => $validated['no_telp2'] ?? null,
                    'tgl_daftar'    => now()->toDateString(),
                    'nama_ortu'     => $validated['nama_ortu'],
                    'alamat_ortu'   => $validated['alamat_ortu'],
                    'no_telp_ortu'  => $validated['no_telp_ortu'],
                ]);
            });
        } catch (Throwable $exception) {
            report($exception);

            return back()
                ->withInput()
                ->with('error', 'Gagal menyimpan data anggota. Silakan coba lagi.');
        }

        return redirect()
            ->route('anggota.pelajar.index')
            ->with('success', 'Data anggota pelajar berhasil ditambahkan.');
    }

    public function show(AnggotaPelajar $pelajar): View
    {
        $pelajar->load('user:id,name,email,role');

        return view('anggota.show', ['anggota' => $pelajar]);
    }

    public function edit(AnggotaPelajar $pelajar): View
    {
        $pelajar->load('user:id,email');

        return view('anggota.edit', ['anggota' => $pelajar]);
    }

    public function update(UpdateAnggotaPelajarRequest $request, AnggotaPelajar $pelajar): RedirectResponse
    {
        try {
            DB::transaction(function () use ($request, $pelajar) {
                $validated = $request->validated();

                $pelajar->user->update([
                    'name'  => $validated['nama_anggota'],
                    'email' => $validated['email'],
                    ...($validated['password'] ?? null
                        ? ['password' => Hash::make($validated['password'])]
                        : []),
                ]);

                $pelajar->update([
                    'no_anggota'    => $validated['no_anggota'],
                    'nim_nis'       => $validated['nim_nis'],
                    'nama_anggota'  => $validated['nama_anggota'],
                    'asal_sekolah'  => $validated['asal_sekolah'],
                    'tanggal_lahir' => $validated['tanggal_lahir'],
                    'alamat'        => $validated['alamat'],
                    'kode_pos'      => $validated['kode_pos'] ?? null,
                    'no_telp1'      => $validated['no_telp1'],
                    'no_telp2'      => $validated['no_telp2'] ?? null,
                    'nama_ortu'     => $validated['nama_ortu'],
                    'alamat_ortu'   => $validated['alamat_ortu'],
                    'no_telp_ortu'  => $validated['no_telp_ortu'],
                ]);
            });
        } catch (Throwable $exception) {
            report($exception);

            return back()
                ->withInput()
                ->with('error', 'Gagal memperbarui data anggota. Silakan coba lagi.');
        }

        return redirect()
            ->route('anggota.pelajar.index')
            ->with('success', 'Data anggota pelajar berhasil diperbarui.');
    }

    public function destroy(AnggotaPelajar $pelajar): RedirectResponse
    {
        try {
            DB::transaction(function () use ($pelajar) {
                $user = $pelajar->user;
                $pelajar->delete();
                $user?->delete();
            });
        } catch (Throwable $exception) {
            report($exception);

            return back()->with('error', 'Gagal menghapus data anggota. Pastikan tidak ada transaksi aktif.');
        }

        return redirect()
            ->route('anggota.pelajar.index')
            ->with('success', 'Data anggota pelajar berhasil dihapus.');
    }
}

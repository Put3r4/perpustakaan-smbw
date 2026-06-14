<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\AnggotaNonPelajar;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Anggota\StoreAnggotaNonPelajarRequest;
use App\Http\Requests\Anggota\UpdateAnggotaNonPelajarRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Throwable;

class AnggotaNonPelajarController extends Controller
{
    public function index(): View
    {
        $anggota = AnggotaNonPelajar::query()
            ->with('user:id,name,email')
            ->latest()
            ->paginate(15);

        return view('anggota.non-pelajar.index', compact('anggota'));
    }

    public function create(): View
    {
        return view('anggota.non-pelajar.create');
    }

    public function store(StoreAnggotaNonPelajarRequest $request): RedirectResponse
    {
        try {
            DB::transaction(function () use ($request) {
                $validated = $request->validated();

                $user = User::create([
                    'name'     => $validated['nama_anggota'],
                    'email'    => $validated['email'],
                    'password' => Hash::make($validated['password']),
                    'role'     => 'non_pelajar',
                ]);

                AnggotaNonPelajar::create([
                    'user_id'      => $user->id,
                    'no_anggota'   => $validated['no_anggota'],
                    'nik'          => $validated['nik'],
                    'nama_anggota' => $validated['nama_anggota'],
                    'pekerjaan'    => $validated['pekerjaan'],
                    'ttl'          => $validated['ttl'],
                    'alamat'       => $validated['alamat'],
                    'kode_pos'     => $validated['kode_pos'],
                    'no_telp1'     => $validated['no_telp1'],
                    'no_telp2'     => $validated['no_telp2'] ?? null,
                    'tgl_daftar'   => now()->toDateString(),
                ]);
            });
        } catch (Throwable $exception) {
            report($exception);

            return back()
                ->withInput()
                ->with('error', 'Gagal menambahkan data anggota. Silakan coba lagi.');
        }

        return redirect()
            ->route('anggota.non-pelajar.index')
            ->with('success', 'Data anggota non pelajar berhasil ditambahkan.');
    }

    public function edit(AnggotaNonPelajar $nonPelajar): View
    {
        $nonPelajar->load('user:id,email');

        return view('anggota.non-pelajar.edit', ['anggota' => $nonPelajar]);
    }

    public function update(UpdateAnggotaNonPelajarRequest $request, AnggotaNonPelajar $nonPelajar): RedirectResponse
    {
        try {
            DB::transaction(function () use ($request, $nonPelajar) {
                $validated = $request->validated();

                $nonPelajar->user->update([
                    'name'  => $validated['nama_anggota'],
                    'email' => $validated['email'],
                    ...($validated['password'] ?? null
                        ? ['password' => Hash::make($validated['password'])]
                        : []),
                ]);

                $nonPelajar->update([
                    'no_anggota'   => $validated['no_anggota'],
                    'nik'          => $validated['nik'],
                    'nama_anggota' => $validated['nama_anggota'],
                    'pekerjaan'    => $validated['pekerjaan'],
                    'ttl'          => $validated['ttl'],
                    'alamat'       => $validated['alamat'],
                    'kode_pos'     => $validated['kode_pos'],
                    'no_telp1'     => $validated['no_telp1'],
                    'no_telp2'     => $validated['no_telp2'] ?? null,
                ]);
            });
        } catch (Throwable $exception) {
            report($exception);

            return back()
                ->withInput()
                ->with('error', 'Gagal memperbarui data anggota. Silakan coba lagi.');
        }

        return redirect()
            ->route('anggota.non-pelajar.index')
            ->with('success', 'Data anggota non pelajar berhasil diperbarui.');
    }

    public function destroy(AnggotaNonPelajar $nonPelajar): RedirectResponse
    {
        try {
            DB::transaction(function () use ($nonPelajar) {
                $user = $nonPelajar->user;
                $nonPelajar->delete();
                $user?->delete();
            });
        } catch (Throwable $exception) {
            report($exception);

            return back()->with('error', 'Gagal menghapus data anggota. Pastikan tidak ada transaksi aktif.');
        }

        return redirect()
            ->route('anggota.non-pelajar.index')
            ->with('success', 'Data anggota non pelajar berhasil dihapus.');
    }
}

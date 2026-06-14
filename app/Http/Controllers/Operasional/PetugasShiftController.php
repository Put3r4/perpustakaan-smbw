<?php

namespace App\Http\Controllers\Operasional;

use App\Http\Controllers\Controller;
use App\Models\Petugas;
use App\Models\PetugasShift;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class PetugasShiftController extends Controller
{
    public function index(): View
    {
        $shifts = PetugasShift::with('petugas')
            ->orderBy('tanggal', 'desc')
            ->orderBy('jam_mulai', 'asc')
            ->paginate(15);

        return view('operasional.petugas-shift.index', compact('shifts'));
    }

    public function create(): View
    {
        $petugasList = Petugas::orderBy('nama_petugas')->get();
        return view('operasional.petugas-shift.create', compact('petugasList'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'petugas_id' => 'required|exists:petugas,id',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
        ], [
            'petugas_id.required' => 'Petugas wajib dipilih.',
            'petugas_id.exists' => 'Petugas tidak valid.',
            'tanggal.required' => 'Tanggal wajib diisi.',
            'tanggal.date' => 'Format tanggal tidak valid.',
            'jam_mulai.required' => 'Jam mulai wajib diisi.',
            'jam_selesai.required' => 'Jam selesai wajib diisi.',
            'jam_selesai.after' => 'Jam selesai harus setelah jam mulai.',
        ]);

        // Validasi jadwal bertabrakan
        $overlapping = PetugasShift::where('petugas_id', $request->petugas_id)
            ->where('tanggal', $request->tanggal)
            ->where(function ($query) use ($request) {
                $query->where('jam_mulai', '<', $request->jam_selesai)
                      ->where('jam_selesai', '>', $request->jam_mulai);
            })
            ->exists();

        if ($overlapping) {
            return back()
                ->withErrors(['jam_mulai' => 'Petugas yang sama tidak boleh memiliki jadwal yang bertabrakan pada tanggal yang sama.'])
                ->withInput();
        }

        PetugasShift::create([
            'petugas_id' => $request->petugas_id,
            'tanggal' => $request->tanggal,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
        ]);

        return redirect()
            ->route('operasional.petugas-shift.index')
            ->with('success', 'Jadwal piket berhasil ditambahkan.');
    }

    public function edit(PetugasShift $petugasShift): View
    {
        $petugasList = Petugas::orderBy('nama_petugas')->get();
        return view('operasional.petugas-shift.edit', compact('petugasShift', 'petugasList'));
    }

    public function update(Request $request, PetugasShift $petugasShift): RedirectResponse
    {
        $request->validate([
            'petugas_id' => 'required|exists:petugas,id',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
        ], [
            'petugas_id.required' => 'Petugas wajib dipilih.',
            'petugas_id.exists' => 'Petugas tidak valid.',
            'tanggal.required' => 'Tanggal wajib diisi.',
            'tanggal.date' => 'Format tanggal tidak valid.',
            'jam_mulai.required' => 'Jam mulai wajib diisi.',
            'jam_selesai.required' => 'Jam selesai wajib diisi.',
            'jam_selesai.after' => 'Jam selesai harus setelah jam mulai.',
        ]);

        // Validasi jadwal bertabrakan (kecuali shift yang sedang di-edit)
        $overlapping = PetugasShift::where('petugas_id', $request->petugas_id)
            ->where('tanggal', $request->tanggal)
            ->where('id', '!=', $petugasShift->id)
            ->where(function ($query) use ($request) {
                $query->where('jam_mulai', '<', $request->jam_selesai)
                      ->where('jam_selesai', '>', $request->jam_mulai);
            })
            ->exists();

        if ($overlapping) {
            return back()
                ->withErrors(['jam_mulai' => 'Petugas yang sama tidak boleh memiliki jadwal yang bertabrakan pada tanggal yang sama.'])
                ->withInput();
        }

        $petugasShift->update([
            'petugas_id' => $request->petugas_id,
            'tanggal' => $request->tanggal,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
        ]);

        return redirect()
            ->route('operasional.petugas-shift.index')
            ->with('success', 'Jadwal piket berhasil diperbarui.');
    }

    public function destroy(PetugasShift $petugasShift): RedirectResponse
    {
        $petugasShift->delete();

        return redirect()
            ->route('operasional.petugas-shift.index')
            ->with('success', 'Jadwal piket berhasil dihapus.');
    }
}

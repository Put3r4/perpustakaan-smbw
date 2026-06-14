<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use App\Models\TransaksiNonPelajar;
use App\Models\TransaksiPelajar;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class DendaController extends Controller
{
    /**
     * Tampilkan daftar semua transaksi yang memiliki denda > 0.
     */
    public function index(): View
    {
        $dendaPelajar = TransaksiPelajar::with(['anggota', 'buku', 'petugasP', 'petugasK'])
            ->where('denda', '>', 0)
            ->latest('tgl_kembali')
            ->paginate(15, ['*'], 'pelajar_page');

        $dendaNonPelajar = TransaksiNonPelajar::with(['anggota', 'buku', 'petugasP', 'petugasK'])
            ->where('denda', '>', 0)
            ->latest('tgl_kembali')
            ->paginate(15, ['*'], 'non_pelajar_page');

        return view('transaksi.denda.index', compact('dendaPelajar', 'dendaNonPelajar'));
    }

    /**
     * Toggle status pembayaran denda antara 'lunas' dan 'belum_lunas'.
     */
    public function toggleStatus(string $type, int $id): RedirectResponse
    {
        if ($type === 'pelajar') {
            $transaksi = TransaksiPelajar::findOrFail($id);
        } else {
            $transaksi = TransaksiNonPelajar::findOrFail($id);
        }

        // Toggle status
        $statusBaru = $transaksi->status_denda === 'lunas' ? 'belum_lunas' : 'lunas';
        $transaksi->update(['status_denda' => $statusBaru]);

        $pesan = $statusBaru === 'lunas'
            ? 'Denda berhasil ditandai sebagai LUNAS.'
            : 'Denda berhasil ditandai sebagai BELUM LUNAS.';

        return back()->with('success', $pesan);
    }
}

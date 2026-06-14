<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Petugas;
use App\Models\TransaksiNonPelajar;
use App\Models\TransaksiPelajar;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengembalianController extends Controller
{
    /**
     * Tampilkan daftar transaksi yang sedang aktif (berstatus dipinjam/terlambat).
     */
    public function index(): View
    {
        $kembaliPelajar = TransaksiPelajar::with(['anggota', 'buku', 'petugasP'])
            ->whereIn('status', ['dipinjam', 'terlambat'])
            ->latest()
            ->paginate(15, ['*'], 'pelajar_page');

        $kembaliNonPelajar = TransaksiNonPelajar::with(['anggota', 'buku', 'petugasP'])
            ->whereIn('status', ['dipinjam', 'terlambat'])
            ->latest()
            ->paginate(15, ['*'], 'non_pelajar_page');

        return view('transaksi.pengembalian.index', compact('kembaliPelajar', 'kembaliNonPelajar'));
    }

    /**
     * Tampilkan form proses pengembalian.
     */
    public function process(string $type, int $id): View
    {
        if ($type === 'pelajar') {
            $transaksi = TransaksiPelajar::with(['anggota', 'buku', 'petugasP'])->findOrFail($id);
        } else {
            $transaksi = TransaksiNonPelajar::with(['anggota', 'buku', 'petugasP'])->findOrFail($id);
        }

        // Jangan bisa memproses yang sudah dikembalikan
        if ($transaksi->status === 'dikembalikan') {
            return redirect()->route('transaksi.pengembalian.index')
                ->with('error', 'Transaksi ini sudah dikembalikan sebelumnya.');
        }

        $petugasList = Petugas::orderBy('nama_petugas')->get();

        // Hitung perkiraan denda saat ini
        $tglKembaliHariIni  = now()->toDateString();
        $tglJatuhTempo       = $transaksi->tgl_jatuh_tempo;
        $hariTerlambat       = 0;
        $dendaSementara      = 0;

        if ($tglKembaliHariIni > $tglJatuhTempo) {
            $hariTerlambat  = now()->diffInDays($tglJatuhTempo);
            $dendaSementara = $hariTerlambat * 500;
        }

        return view('transaksi.pengembalian.process', compact(
            'transaksi',
            'type',
            'petugasList',
            'hariTerlambat',
            'dendaSementara',
            'tglKembaliHariIni'
        ));
    }

    /**
     * Proses dan simpan data pengembalian buku.
     */
    public function store(string $type, int $id, Request $request): RedirectResponse
    {
        $request->validate([
            'petugas_id' => 'required|exists:petugas,id',
        ], [
            'petugas_id.required' => 'Petugas pengembalian wajib dipilih.',
            'petugas_id.exists'   => 'Petugas tidak valid.',
        ]);

        try {
            DB::transaction(function () use ($type, $id, $request) {
                if ($type === 'pelajar') {
                    $transaksi = TransaksiPelajar::findOrFail($id);
                } else {
                    $transaksi = TransaksiNonPelajar::findOrFail($id);
                }

                // Validasi: jangan proses jika sudah dikembalikan
                if ($transaksi->status === 'dikembalikan') {
                    throw new \RuntimeException('Transaksi ini sudah dikembalikan sebelumnya.');
                }

                $tglKembali    = now()->toDateString();
                $tglJatuhTempo = $transaksi->tgl_jatuh_tempo;

                // Hitung keterlambatan dan denda
                $hariTerlambat = 0;
                $denda         = 0;
                $statusDenda   = 'lunas';

                if ($tglKembali > $tglJatuhTempo) {
                    $hariTerlambat = now()->diffInDays($tglJatuhTempo);
                    $denda         = $hariTerlambat * 500;
                    $statusDenda   = 'belum_lunas';
                }

                // Update data transaksi
                $transaksi->update([
                    'petugas_kembali' => $request->petugas_id,
                    'tgl_kembali'     => $tglKembali,
                    'status'          => 'dikembalikan',
                    'denda'           => $denda,
                    'status_denda'    => $statusDenda,
                ]);

                // Kembalikan stok buku
                $buku = Buku::findOrFail($transaksi->buku_id);
                $buku->increment('stok_tersedia');

                // Update status buku ke "tersedia" jika stok > 0
                if ($buku->fresh()->stok_tersedia > 0 && $buku->status === 'habis') {
                    $buku->update(['status' => 'tersedia']);
                }
            });
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        } catch (\Throwable $e) {
            report($e);
            return back()->with('error', 'Gagal memproses pengembalian. Silakan coba lagi.');
        }

        return redirect()->route('transaksi.pengembalian.index')
            ->with('success', 'Buku berhasil dikembalikan. Denda (jika ada) telah dihitung otomatis.');
    }
}

<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use App\Models\AnggotaNonPelajar;
use App\Models\AnggotaPelajar;
use App\Models\Buku;
use App\Models\Petugas;
use App\Models\TransaksiNonPelajar;
use App\Models\TransaksiPelajar;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    /**
     * Tampilkan daftar semua peminjaman (Pelajar & Non Pelajar).
     */
    public function index(): View
    {
        $pinjamPelajar = TransaksiPelajar::with(['anggota', 'buku', 'petugasP'])
            ->latest()
            ->paginate(15, ['*'], 'pelajar_page');

        $pinjamNonPelajar = TransaksiNonPelajar::with(['anggota', 'buku', 'petugasP'])
            ->latest()
            ->paginate(15, ['*'], 'non_pelajar_page');

        return view('transaksi.peminjaman.index', compact('pinjamPelajar', 'pinjamNonPelajar'));
    }

    /**
     * Tampilkan form untuk membuat peminjaman baru.
     */
    public function create(): View
    {
        $bukuTersedia   = Buku::where('stok_tersedia', '>', 0)->orderBy('judul')->get();
        $anggotaPelajar = AnggotaPelajar::orderBy('nama_anggota')->get();
        $anggotaNonPelajar = AnggotaNonPelajar::orderBy('nama_anggota')->get();
        $petugasList    = Petugas::orderBy('nama_petugas')->get();

        return view('transaksi.peminjaman.create', compact(
            'bukuTersedia',
            'anggotaPelajar',
            'anggotaNonPelajar',
            'petugasList'
        ));
    }

    /**
     * Simpan data peminjaman baru ke database.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'tipe_anggota' => 'required|in:pelajar,non_pelajar',
            'anggota_id'   => 'required|integer',
            'buku_id'      => 'required|exists:buku,id',
            'petugas_id'   => 'required|exists:petugas,id',
        ], [
            'tipe_anggota.required' => 'Tipe anggota wajib dipilih.',
            'tipe_anggota.in'       => 'Tipe anggota tidak valid.',
            'anggota_id.required'   => 'Anggota wajib dipilih.',
            'buku_id.required'      => 'Buku wajib dipilih.',
            'buku_id.exists'        => 'Buku yang dipilih tidak valid.',
            'petugas_id.required'   => 'Petugas wajib dipilih.',
            'petugas_id.exists'     => 'Petugas tidak valid.',
        ]);

        $buku = Buku::findOrFail($request->buku_id);

        // Validasi stok buku
        if ($buku->stok_tersedia <= 0) {
            return back()->withInput()->with('error', 'Stok buku tidak tersedia.');
        }

        $tipeAnggota = $request->tipe_anggota;

        // Validasi batas maksimal 2 buku aktif per anggota
        $jumlahPinjamAktif = 0;
        if ($tipeAnggota === 'pelajar') {
            // Validasi anggota pelajar ada
            $anggota = AnggotaPelajar::find($request->anggota_id);
            if (! $anggota) {
                return back()->withInput()->with('error', 'Anggota pelajar tidak ditemukan.');
            }
            $jumlahPinjamAktif = TransaksiPelajar::where('no_anggota_p', $anggota->id)
                ->whereIn('status', ['dipinjam', 'terlambat'])
                ->count();
        } else {
            // Validasi anggota non pelajar ada
            $anggota = AnggotaNonPelajar::find($request->anggota_id);
            if (! $anggota) {
                return back()->withInput()->with('error', 'Anggota non pelajar tidak ditemukan.');
            }
            $jumlahPinjamAktif = TransaksiNonPelajar::where('no_anggota_np', $anggota->id)
                ->whereIn('status', ['dipinjam', 'terlambat'])
                ->count();
        }

        if ($jumlahPinjamAktif >= 2) {
            return back()->withInput()->with('error', 'Anggota ini sudah mencapai batas maksimal 2 buku yang sedang dipinjam.');
        }

        // Generate kode transaksi: TRX-YYYYMMDD-XXXX
        $kodeTransaksi = $this->generateKodeTransaksi($tipeAnggota);

        $tglPinjam    = now()->toDateString();
        $tglJatuhTempo = now()->addDays(7)->toDateString();

        try {
            DB::transaction(function () use ($request, $buku, $anggota, $tipeAnggota, $kodeTransaksi, $tglPinjam, $tglJatuhTempo) {
                // Simpan transaksi
                if ($tipeAnggota === 'pelajar') {
                    TransaksiPelajar::create([
                        'kode_transaksi'  => $kodeTransaksi,
                        'no_anggota_p'    => $anggota->id,
                        'buku_id'         => $buku->id,
                        'petugas_pinjam'  => $request->petugas_id,
                        'petugas_kembali' => null,
                        'tgl_pinjam'      => $tglPinjam,
                        'tgl_jatuh_tempo' => $tglJatuhTempo,
                        'tgl_kembali'     => null,
                        'status'          => 'dipinjam',
                        'denda'           => 0,
                        'status_denda'    => 'lunas',
                    ]);
                } else {
                    TransaksiNonPelajar::create([
                        'kode_transaksi'  => $kodeTransaksi,
                        'no_anggota_np'   => $anggota->id,
                        'buku_id'         => $buku->id,
                        'petugas_pinjam'  => $request->petugas_id,
                        'petugas_kembali' => null,
                        'tgl_pinjam'      => $tglPinjam,
                        'tgl_jatuh_tempo' => $tglJatuhTempo,
                        'tgl_kembali'     => null,
                        'status'          => 'dipinjam',
                        'denda'           => 0,
                        'status_denda'    => 'lunas',
                    ]);
                }

                // Kurangi stok buku
                $buku->decrement('stok_tersedia');
                $buku->increment('total_dipinjam');

                // Update status buku jika stok habis
                if ($buku->fresh()->stok_tersedia <= 0) {
                    $buku->update(['status' => 'habis']);
                }
            });
        } catch (\Throwable $e) {
            report($e);
            return back()->withInput()->with('error', 'Gagal menyimpan data peminjaman. Silakan coba lagi.');
        }

        return redirect()->route('transaksi.peminjaman.index')
            ->with('success', "Peminjaman berhasil dicatat dengan kode: {$kodeTransaksi}");
    }

    /**
     * Tampilkan detail satu transaksi peminjaman.
     */
    public function show(string $type, int $id): View
    {
        if ($type === 'pelajar') {
            $transaksi = TransaksiPelajar::with(['anggota', 'buku', 'petugasP', 'petugasK'])->findOrFail($id);
        } else {
            $transaksi = TransaksiNonPelajar::with(['anggota', 'buku', 'petugasP', 'petugasK'])->findOrFail($id);
        }

        return view('transaksi.peminjaman.show', compact('transaksi', 'type'));
    }

    /**
     * Hapus data transaksi peminjaman.
     * Jika transaksi belum dikembalikan, stok buku dikembalikan.
     */
    public function destroy(string $type, int $id): RedirectResponse
    {
        try {
            DB::transaction(function () use ($type, $id) {
                if ($type === 'pelajar') {
                    $transaksi = TransaksiPelajar::findOrFail($id);
                } else {
                    $transaksi = TransaksiNonPelajar::findOrFail($id);
                }

                // Kembalikan stok jika belum dikembalikan
                if ($transaksi->status !== 'dikembalikan') {
                    $buku = Buku::find($transaksi->buku_id);
                    if ($buku) {
                        $buku->increment('stok_tersedia');
                        if ($buku->fresh()->stok_tersedia > 0) {
                            $buku->update(['status' => 'tersedia']);
                        }
                    }
                }

                $transaksi->delete();
            });
        } catch (\Throwable $e) {
            report($e);
            return back()->with('error', 'Gagal menghapus data transaksi.');
        }

        return redirect()->route('transaksi.peminjaman.index')
            ->with('success', 'Data transaksi peminjaman berhasil dihapus.');
    }

    /**
     * Generate kode transaksi otomatis dengan format TRX-YYYYMMDD-XXXX.
     */
    private function generateKodeTransaksi(string $tipe): string
    {
        $tanggal = now()->format('Ymd');
        $prefix  = "TRX-{$tanggal}-";

        // Cari nomor urut tertinggi hari ini (dari kedua tabel)
        $maxPelajar = TransaksiPelajar::where('kode_transaksi', 'like', $prefix . '%')
            ->max('kode_transaksi');
        $maxNonPelajar = TransaksiNonPelajar::where('kode_transaksi', 'like', $prefix . '%')
            ->max('kode_transaksi');

        $max = max($maxPelajar, $maxNonPelajar);
        if ($max) {
            $lastNumber = (int) substr($max, -4);
        } else {
            $lastNumber = 0;
        }

        $nextNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

        return $prefix . $nextNumber;
    }
}

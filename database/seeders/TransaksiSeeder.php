<?php

namespace Database\Seeders;

use App\Models\AnggotaPelajar;
use App\Models\AnggotaNonPelajar;
use App\Models\Buku;
use App\Models\Petugas;
use App\Models\TransaksiPelajar;
use App\Models\TransaksiNonPelajar;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TransaksiSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil data pendukung
        $pelajars = AnggotaPelajar::all();
        $nonPelajars = AnggotaNonPelajar::all();
        $petugasIds = Petugas::pluck('id')->toArray();

        if ($pelajars->isEmpty() || $nonPelajars->isEmpty() || empty($petugasIds)) {
            $this->command->warn('Pastikan CoreSeeder dan AnggotaSeeder sudah dijalankan sebelum TransaksiSeeder.');
            return;
        }

        // Tanggal rujukan "Hari Ini" dalam sistem: 2026-06-15
        $today = Carbon::parse('2026-06-15');

        // Track active loans per member to enforce max 2 active loans
        $activeLoansPelajar = array_fill_keys($pelajars->pluck('id')->toArray(), 0);
        $activeLoansNonPelajar = array_fill_keys($nonPelajars->pluck('id')->toArray(), 0);

        // Counter untuk kode transaksi unik
        $trpCounter = 1;
        $trnpCounter = 1;

        // Distribusi Transaksi Pelajar vs Non-Pelajar (total 242)
        // 45 Normal (Tidak Telat): 23 Pelajar, 22 Non-Pelajar
        // 37 Telat 3 Hari (Kembali): 19 Pelajar, 18 Non-Pelajar
        // 98 Telat 7 Hari (Kembali): 49 Pelajar, 49 Non-Pelajar
        // 62 Aktif (Sedang Dipinjam): 31 Pelajar, 31 Non-Pelajar

        // ==========================================
        // 1. SEED TRANSAKSI PELAJAR
        // ==========================================

        // A. 23 Transaksi Pelajar Normal
        for ($i = 0; $i < 23; $i++) {
            $tglPinjam = $today->copy()->subDays(rand(10, 30));
            $tglJatuhTempo = $tglPinjam->copy()->addDays(7);
            // Kembali sebelum atau tepat pada jatuh tempo
            $tglKembali = $tglPinjam->copy()->addDays(rand(1, 7));

            $buku = Buku::inRandomOrder()->first();
            $buku->increment('total_dipinjam');

            TransaksiPelajar::create([
                'kode_transaksi'  => 'TR-P-' . str_pad($trpCounter++, 6, '0', STR_PAD_LEFT),
                'no_anggota_p'    => $pelajars->random()->id,
                'buku_id'         => $buku->id,
                'petugas_pinjam'  => $petugasIds[array_rand($petugasIds)],
                'petugas_kembali' => $petugasIds[array_rand($petugasIds)],
                'tgl_pinjam'      => $tglPinjam->toDateString(),
                'tgl_jatuh_tempo' => $tglJatuhTempo->toDateString(),
                'tgl_kembali'     => $tglKembali->toDateString(),
                'status'          => 'dikembalikan',
                'denda'           => 0,
                'status_denda'    => 'lunas',
            ]);
        }

        // B. 19 Transaksi Pelajar Terlambat 3 Hari
        for ($i = 0; $i < 19; $i++) {
            $tglPinjam = $today->copy()->subDays(rand(11, 20));
            $tglJatuhTempo = $tglPinjam->copy()->addDays(7);
            $tglKembali = $tglJatuhTempo->copy()->addDays(3);

            $buku = Buku::inRandomOrder()->first();
            $buku->increment('total_dipinjam');

            // 12 lunas, 7 belum lunas
            $statusDenda = ($i < 12) ? 'lunas' : 'belum_lunas';

            TransaksiPelajar::create([
                'kode_transaksi'  => 'TR-P-' . str_pad($trpCounter++, 6, '0', STR_PAD_LEFT),
                'no_anggota_p'    => $pelajars->random()->id,
                'buku_id'         => $buku->id,
                'petugas_pinjam'  => $petugasIds[array_rand($petugasIds)],
                'petugas_kembali' => $petugasIds[array_rand($petugasIds)],
                'tgl_pinjam'      => $tglPinjam->toDateString(),
                'tgl_jatuh_tempo' => $tglJatuhTempo->toDateString(),
                'tgl_kembali'     => $tglKembali->toDateString(),
                'status'          => 'dikembalikan',
                'denda'           => 1500, // 3 hari * 500
                'status_denda'    => $statusDenda,
            ]);
        }

        // C. 49 Transaksi Pelajar Terlambat 7 Hari
        for ($i = 0; $i < 49; $i++) {
            $tglPinjam = $today->copy()->subDays(rand(15, 35));
            $tglJatuhTempo = $tglPinjam->copy()->addDays(7);
            $tglKembali = $tglJatuhTempo->copy()->addDays(7);

            $buku = Buku::inRandomOrder()->first();
            $buku->increment('total_dipinjam');

            // 25 lunas, 24 belum lunas
            $statusDenda = ($i < 25) ? 'lunas' : 'belum_lunas';

            TransaksiPelajar::create([
                'kode_transaksi'  => 'TR-P-' . str_pad($trpCounter++, 6, '0', STR_PAD_LEFT),
                'no_anggota_p'    => $pelajars->random()->id,
                'buku_id'         => $buku->id,
                'petugas_pinjam'  => $petugasIds[array_rand($petugasIds)],
                'petugas_kembali' => $petugasIds[array_rand($petugasIds)],
                'tgl_pinjam'      => $tglPinjam->toDateString(),
                'tgl_jatuh_tempo' => $tglJatuhTempo->toDateString(),
                'tgl_kembali'     => $tglKembali->toDateString(),
                'status'          => 'dikembalikan',
                'denda'           => 3500, // 7 hari * 500
                'status_denda'    => $statusDenda,
            ]);
        }

        // D. 31 Transaksi Pelajar Aktif (Dipinjam)
        // 15 Normal (Belum Jatuh Tempo), 16 Terlambat (Melewati Jatuh Tempo)
        for ($i = 0; $i < 31; $i++) {
            $isOverdue = ($i >= 15);

            if ($isOverdue) {
                // Pinjam di masa lalu sehingga jatuh tempo sebelum hari ini (2026-06-15)
                // Misal pinjam 10 hari lalu -> jatuh tempo 3 hari lalu
                $tglPinjam = $today->copy()->subDays(rand(8, 14));
                $status = 'terlambat';
                $statusDenda = 'belum_lunas';
            } else {
                // Pinjam baru-baru ini sehingga jatuh tempo di masa depan
                // Misal pinjam 2 hari lalu -> jatuh tempo 5 hari lagi
                $tglPinjam = $today->copy()->subDays(rand(1, 6));
                $status = 'dipinjam';
                $statusDenda = 'lunas'; // Belum didenda
            }
            $tglJatuhTempo = $tglPinjam->copy()->addDays(7);

            // Cari anggota pelajar yang memiliki pinjaman aktif < 2
            $anggota = null;
            $attempts = 0;
            while ($attempts < 100) {
                $candidate = $pelajars->random();
                if ($activeLoansPelajar[$candidate->id] < 2) {
                    $anggota = $candidate;
                    $activeLoansPelajar[$candidate->id]++;
                    break;
                }
                $attempts++;
            }
            if (!$anggota) continue; // Safety check

            // Cari buku dengan stok tersedia > 0
            $buku = Buku::where('stok_tersedia', '>', 0)->inRandomOrder()->first();
            if (!$buku) {
                // Fallback jika kehabisan buku
                $buku = Buku::inRandomOrder()->first();
            }

            // Kurangi stok buku secara real-time
            $buku->decrement('stok_tersedia');
            $buku->increment('total_dipinjam');
            if ($buku->fresh()->stok_tersedia <= 0) {
                $buku->update(['status' => 'habis']);
            }

            TransaksiPelajar::create([
                'kode_transaksi'  => 'TR-P-' . str_pad($trpCounter++, 6, '0', STR_PAD_LEFT),
                'no_anggota_p'    => $anggota->id,
                'buku_id'         => $buku->id,
                'petugas_pinjam'  => $petugasIds[array_rand($petugasIds)],
                'petugas_kembali' => null,
                'tgl_pinjam'      => $tglPinjam->toDateString(),
                'tgl_jatuh_tempo' => $tglJatuhTempo->toDateString(),
                'tgl_kembali'     => null,
                'status'          => $status,
                'denda'           => 0,
                'status_denda'    => $statusDenda,
            ]);
        }


        // ==========================================
        // 2. SEED TRANSAKSI NON-PELAJAR
        // ==========================================

        // A. 22 Transaksi Non-Pelajar Normal
        for ($i = 0; $i < 22; $i++) {
            $tglPinjam = $today->copy()->subDays(rand(10, 30));
            $tglJatuhTempo = $tglPinjam->copy()->addDays(7);
            $tglKembali = $tglPinjam->copy()->addDays(rand(1, 7));

            $buku = Buku::inRandomOrder()->first();
            $buku->increment('total_dipinjam');

            TransaksiNonPelajar::create([
                'kode_transaksi'  => 'TR-NP-' . str_pad($trnpCounter++, 6, '0', STR_PAD_LEFT),
                'no_anggota_np'   => $nonPelajars->random()->id,
                'buku_id'         => $buku->id,
                'petugas_pinjam'  => $petugasIds[array_rand($petugasIds)],
                'petugas_kembali' => $petugasIds[array_rand($petugasIds)],
                'tgl_pinjam'      => $tglPinjam->toDateString(),
                'tgl_jatuh_tempo' => $tglJatuhTempo->toDateString(),
                'tgl_kembali'     => $tglKembali->toDateString(),
                'status'          => 'dikembalikan',
                'denda'           => 0,
                'status_denda'    => 'lunas',
            ]);
        }

        // B. 18 Transaksi Non-Pelajar Terlambat 3 Hari
        for ($i = 0; $i < 18; $i++) {
            $tglPinjam = $today->copy()->subDays(rand(11, 20));
            $tglJatuhTempo = $tglPinjam->copy()->addDays(7);
            $tglKembali = $tglJatuhTempo->copy()->addDays(3);

            $buku = Buku::inRandomOrder()->first();
            $buku->increment('total_dipinjam');

            // 10 lunas, 8 belum lunas
            $statusDenda = ($i < 10) ? 'lunas' : 'belum_lunas';

            TransaksiNonPelajar::create([
                'kode_transaksi'  => 'TR-NP-' . str_pad($trnpCounter++, 6, '0', STR_PAD_LEFT),
                'no_anggota_np'   => $nonPelajars->random()->id,
                'buku_id'         => $buku->id,
                'petugas_pinjam'  => $petugasIds[array_rand($petugasIds)],
                'petugas_kembali' => $petugasIds[array_rand($petugasIds)],
                'tgl_pinjam'      => $tglPinjam->toDateString(),
                'tgl_jatuh_tempo' => $tglJatuhTempo->toDateString(),
                'tgl_kembali'     => $tglKembali->toDateString(),
                'status'          => 'dikembalikan',
                'denda'           => 1500,
                'status_denda'    => $statusDenda,
            ]);
        }

        // C. 49 Transaksi Non-Pelajar Terlambat 7 Hari
        for ($i = 0; $i < 49; $i++) {
            $tglPinjam = $today->copy()->subDays(rand(15, 35));
            $tglJatuhTempo = $tglPinjam->copy()->addDays(7);
            $tglKembali = $tglJatuhTempo->copy()->addDays(7);

            $buku = Buku::inRandomOrder()->first();
            $buku->increment('total_dipinjam');

            // 25 lunas, 24 belum lunas
            $statusDenda = ($i < 25) ? 'lunas' : 'belum_lunas';

            TransaksiNonPelajar::create([
                'kode_transaksi'  => 'TR-NP-' . str_pad($trnpCounter++, 6, '0', STR_PAD_LEFT),
                'no_anggota_np'   => $nonPelajars->random()->id,
                'buku_id'         => $buku->id,
                'petugas_pinjam'  => $petugasIds[array_rand($petugasIds)],
                'petugas_kembali' => $petugasIds[array_rand($petugasIds)],
                'tgl_pinjam'      => $tglPinjam->toDateString(),
                'tgl_jatuh_tempo' => $tglJatuhTempo->toDateString(),
                'tgl_kembali'     => $tglKembali->toDateString(),
                'status'          => 'dikembalikan',
                'denda'           => 3500,
                'status_denda'    => $statusDenda,
            ]);
        }

        // D. 31 Transaksi Non-Pelajar Aktif (Dipinjam)
        // 15 Normal, 16 Terlambat
        for ($i = 0; $i < 31; $i++) {
            $isOverdue = ($i >= 15);

            if ($isOverdue) {
                $tglPinjam = $today->copy()->subDays(rand(8, 14));
                $status = 'terlambat';
                $statusDenda = 'belum_lunas';
            } else {
                $tglPinjam = $today->copy()->subDays(rand(1, 6));
                $status = 'dipinjam';
                $statusDenda = 'lunas';
            }
            $tglJatuhTempo = $tglPinjam->copy()->addDays(7);

            // Cari anggota non-pelajar yang memiliki pinjaman aktif < 2
            $anggota = null;
            $attempts = 0;
            while ($attempts < 100) {
                $candidate = $nonPelajars->random();
                if ($activeLoansNonPelajar[$candidate->id] < 2) {
                    $anggota = $candidate;
                    $activeLoansNonPelajar[$candidate->id]++;
                    break;
                }
                $attempts++;
            }
            if (!$anggota) continue;

            // Cari buku dengan stok tersedia > 0
            $buku = Buku::where('stok_tersedia', '>', 0)->inRandomOrder()->first();
            if (!$buku) {
                $buku = Buku::inRandomOrder()->first();
            }

            // Kurangi stok buku secara real-time
            $buku->decrement('stok_tersedia');
            $buku->increment('total_dipinjam');
            if ($buku->fresh()->stok_tersedia <= 0) {
                $buku->update(['status' => 'habis']);
            }

            TransaksiNonPelajar::create([
                'kode_transaksi'  => 'TR-NP-' . str_pad($trnpCounter++, 6, '0', STR_PAD_LEFT),
                'no_anggota_np'   => $anggota->id,
                'buku_id'         => $buku->id,
                'petugas_pinjam'  => $petugasIds[array_rand($petugasIds)],
                'petugas_kembali' => null,
                'tgl_pinjam'      => $tglPinjam->toDateString(),
                'tgl_jatuh_tempo' => $tglJatuhTempo->toDateString(),
                'tgl_kembali'     => null,
                'status'          => $status,
                'denda'           => 0,
                'status_denda'    => $statusDenda,
            ]);
        }
    }
}

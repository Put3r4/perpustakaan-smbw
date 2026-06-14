<?php

namespace Database\Seeders;

use App\Models\SystemSetting;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Aturan Konfigurasi Denda Sistem (Menggunakan updateOrCreate)
        SystemSetting::updateOrCreate(
            ['key_setting' => 'denda_per_hari'],
            [
                'value_setting' => '500',
                'description' => 'Tarif denda keterlambatan buku per hari (Rupiah)'
            ]
        );

        SystemSetting::updateOrCreate(
            ['key_setting' => 'maksimal_pinjam_buku'],
            [
                'value_setting' => '2',
                'description' => 'Batas maksimal buku yang aktif dipinjam'
            ]
        );

        // 2. Jalankan Seeder Modul Fitur Secara Berurutan
        $this->call([
            CoreSeeder::class,        // 1 User Admin + 7 Petugas
            AnggotaSeeder::class,     // 100 Pelajar + 100 Non-Pelajar
            BukuSeeder::class,        // 10 Kategori + 7 Rak + 1000 Buku
            TransaksiSeeder::class,   // 242 Transaksi Peminjaman & Pengembalian
            OperasionalSeeder::class, // Jadwal Shift Petugas (Weekly + 2 Shift Aktif Hari Ini)
            VisitorSeeder::class,     // 43 Visitor Log Polymorphic
        ]);
    }
}

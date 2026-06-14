<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Buku;
use App\Models\SystemSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Aturan Konfigurasi Denda Sistem (Menggunakan updateOrCreate)
        SystemSetting::updateOrCreate(
            ['key_setting' => 'denda_per_hari'], // Kolom acuan pengecekan
            [
                'value_setting' => '500',
                'description' => 'Tarif denda keterlambatan buku per hari (Rupiah)'
            ]
        );

        SystemSetting::updateOrCreate(
            ['key_setting' => 'maksimal_pinjam_buku'], // Kolom acuan pengecekan
            [
                'value_setting' => '2',
                'description' => 'Batas maksimal buku yang aktif dipinjam'
            ]
        );

        // 2. Seed Default Superadmin (Menggunakan firstOrCreate agar password tidak ter-hash ulang jika dijalankan lagi)
        User::firstOrCreate(
            ['email' => 'admin@perpuskota.id'], // Kolom acuan pengecekan
            [
                'name' => 'Super Admin Perpus',
                'password' => Hash::make('adminSumbawa2026'),
                'role' => 'superadmin',
                'email_verified_at' => now(),
            ]
        );

        // 3. Buat Data Dummy Buku
        // Tips: Menggunakan count() mencegah penambahan 20 buku baru terus-menerus setiap seeder dijalankan
        if (Buku::count() === 0) {
            Buku::factory(20)->create();
        }
    }
}

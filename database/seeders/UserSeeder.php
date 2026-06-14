<?php
namespace Database\Seeders;

use App\Models\Buku;
use App\Models\SystemSetting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Aturan Konfigurasi Denda Sistem
        SystemSetting::create([
            'key_setting'   => 'denda_per_hari',
            'value_setting' => '500',
            'description'   => 'Tarif denda keterlambatan buku per hari (Rupiah)',
        ]);

        SystemSetting::create([
            'key_setting'   => 'maksimal_pinjam_buku',
            'value_setting' => '2',
            'description'   => 'Batas maksimal buku yang aktif dipinjam',
        ]);

        // 2. Seed Default Superadmin
        User::create([
            'name'              => 'Super Admin Perpus',
            'email'             => 'admin@perpuskota.id',
            'password'          => Hash::make('adminSumbawa2026'),
            'role'              => 'superadmin',
            'email_verified_at' => now(),
        ]);

        // 3. Buat Data Dummy Buku
        Buku::factory(20)->create();
    }
}

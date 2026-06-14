<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Petugas;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CoreSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Super Admin
        User::updateOrCreate(
            ['email' => 'admin@perpuskota.id'],
            [
                'name'              => 'Super Admin Perpus',
                'password'          => Hash::make('adminSumbawa2026'),
                'role'              => 'superadmin',
                'email_verified_at' => now(),
            ]
        );

        // Names and roles for 7 petugas
        $petugasData = [
            ['nama' => 'Bambang Triyono', 'jabatan' => 'Kepala Perpustakaan', 'telp' => '081234567890'],
            ['nama' => 'Siti Aminah', 'jabatan' => 'Staf Pelayanan', 'telp' => '081234567891'],
            ['nama' => 'Rian Hidayat', 'jabatan' => 'Staf Administrasi', 'telp' => '081234567892'],
            ['nama' => 'Dewi Lestari', 'jabatan' => 'Staf Pengarsipan', 'telp' => '081234567893'],
            ['nama' => 'Eko Prasetyo', 'jabatan' => 'Staf TI', 'telp' => '081234567894'],
            ['nama' => 'Fitriani', 'jabatan' => 'Staf Pelayanan Pagi', 'telp' => '081234567895'],
            ['nama' => 'Hendra Wijaya', 'jabatan' => 'Staf Pelayanan Sore', 'telp' => '081234567896'],
        ];

        foreach ($petugasData as $index => $data) {
            $num = $index + 1;
            $email = "petugas{$num}@perpuskota.id";
            
            // Create user for petugas
            $user = User::updateOrCreate(
                ['email' => $email],
                [
                    'name'              => $data['nama'],
                    'password'          => Hash::make('petugasSumbawa2026'),
                    'role'              => 'petugas',
                    'email_verified_at' => now(),
                ]
            );

            // Create petugas profile
            Petugas::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'kode_petugas' => 'PTG' . str_pad($num, 3, '0', STR_PAD_LEFT),
                    'nama_petugas' => $data['nama'],
                    'jabatan'      => $data['jabatan'],
                    'no_telp'      => $data['telp'],
                    'foto'         => null,
                ]
            );
        }
    }
}

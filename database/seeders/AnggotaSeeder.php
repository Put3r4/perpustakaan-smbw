<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\AnggotaPelajar;
use App\Models\AnggotaNonPelajar;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class AnggotaSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $password = Hash::make('password123');

        // 1. Seed 100 Anggota Pelajar
        for ($i = 1; $i <= 100; $i++) {
            $name = $faker->name();
            $email = "pelajar" . str_pad($i, 3, '0', STR_PAD_LEFT) . "@perpuskota.id";
            
            // Create user
            $user = User::create([
                'name'              => $name,
                'email'             => $email,
                'password'          => $password,
                'role'              => 'pelajar',
                'email_verified_at' => now(),
            ]);

            // Create AnggotaPelajar record
            AnggotaPelajar::create([
                'user_id'       => $user->id,
                'no_anggota'    => 'AP-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'nim_nis'       => $faker->numerify('2026######'),
                'nama_anggota'  => $name,
                'asal_sekolah'  => $faker->randomElement([
                    'SMAN 1 Sumbawa', 'SMAN 2 Sumbawa', 'SMKN 1 Sumbawa', 
                    'SMPN 1 Sumbawa', 'SMPN 2 Sumbawa', 'MAN 1 Sumbawa'
                ]),
                'tanggal_lahir' => $faker->dateTimeBetween('-18 years', '-12 years')->format('Y-m-d'),
                'alamat'        => $faker->address(),
                'kode_pos'      => $faker->postcode(),
                'no_telp1'      => $faker->phoneNumber(),
                'no_telp2'      => null,
                'tgl_daftar'    => $faker->dateTimeBetween('-1 years', 'now')->format('Y-m-d'),
                'nama_ortu'     => $faker->name('male'),
                'alamat_ortu'   => $faker->address(),
                'no_telp_ortu'  => $faker->phoneNumber(),
            ]);
        }

        // 2. Seed 100 Anggota Non-Pelajar
        for ($i = 1; $i <= 100; $i++) {
            $name = $faker->name();
            $email = "nonpelajar" . str_pad($i, 3, '0', STR_PAD_LEFT) . "@perpuskota.id";

            // Create user
            $user = User::create([
                'name'              => $name,
                'email'             => $email,
                'password'          => $password,
                'role'              => 'non_pelajar',
                'email_verified_at' => now(),
            ]);

            // Create AnggotaNonPelajar record
            AnggotaNonPelajar::create([
                'user_id'      => $user->id,
                'no_anggota'   => 'ANP-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'nik'          => $faker->numerify('5204############'),
                'nama_anggota' => $name,
                'pekerjaan'    => $faker->randomElement([
                    'PNS', 'Karyawan Swasta', 'Wiraswasta', 'Buruh', 'Guru', 'Dosen', 'IRT'
                ]),
                'ttl'          => 'Sumbawa, ' . $faker->dateTimeBetween('-50 years', '-20 years')->format('Y-m-d'),
                'alamat'       => $faker->address(),
                'kode_pos'     => $faker->postcode(),
                'no_telp1'     => $faker->phoneNumber(),
                'no_telp2'     => null,
                'tgl_daftar'   => $faker->dateTimeBetween('-1 years', 'now')->format('Y-m-d'),
            ]);
        }
    }
}

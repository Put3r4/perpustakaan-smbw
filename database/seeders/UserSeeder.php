<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Injeksi Akun Petugas Ke Dalam Sistem
        User::create([
            'name' => 'Petugas',
            'email' => 'petugas@sumbawa.go.id',
            'password' => Hash::make('petugas123'),
            'role' => 'petugas',
        ]);
    }
}
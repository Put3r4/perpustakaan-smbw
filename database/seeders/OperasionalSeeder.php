<?php

namespace Database\Seeders;

use App\Models\Petugas;
use App\Models\PetugasShift;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class OperasionalSeeder extends Seeder
{
    public function run(): void
    {
        $petugas = Petugas::all();
        if ($petugas->isEmpty()) {
            $this->command->warn('Pastikan CoreSeeder sudah dijalankan sebelum OperasionalSeeder.');
            return;
        }

        $petugasIds = $petugas->pluck('id')->toArray();
        $petugasCount = count($petugasIds);

        // Ambil hari pertama minggu ini (Senin)
        $startOfWeek = Carbon::today()->startOfWeek();

        // Buat jadwal untuk 7 hari dalam minggu ini (Senin - Minggu)
        // Setiap hari ada 2 shift: 08:00 - 12:00 dan 12:00 - 16:00
        // Petugas dirotasi secara merata
        $petugasIndex = 0;

        for ($day = 0; $day < 7; $day++) {
            $currentDate = $startOfWeek->copy()->addDays($day);

            // Shift 1: Pagi (08:00 - 12:00)
            PetugasShift::create([
                'petugas_id'  => $petugasIds[$petugasIndex % $petugasCount],
                'tanggal'     => $currentDate->toDateString(),
                'jam_mulai'   => '08:00:00',
                'jam_selesai' => '12:00:00',
            ]);
            $petugasIndex++;

            // Shift 2: Siang (12:00 - 16:00)
            PetugasShift::create([
                'petugas_id'  => $petugasIds[$petugasIndex % $petugasCount],
                'tanggal'     => $currentDate->toDateString(),
                'jam_mulai'   => '12:00:00',
                'jam_selesai' => '16:00:00',
            ]);
            $petugasIndex++;
        }
    }
}

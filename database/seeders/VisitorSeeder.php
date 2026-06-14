<?php

namespace Database\Seeders;

use App\Models\AnggotaPelajar;
use App\Models\AnggotaNonPelajar;
use App\Models\VisitorLog;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class VisitorSeeder extends Seeder
{
    public function run(): void
    {
        $pelajars = AnggotaPelajar::all();
        $nonPelajars = AnggotaNonPelajar::all();

        if ($pelajars->isEmpty() || $nonPelajars->isEmpty()) {
            $this->command->warn('Pastikan AnggotaSeeder sudah dijalankan sebelum VisitorSeeder.');
            return;
        }

        $now = Carbon::now();

        // Seed 43 visitor logs distributed over the last 7 days
        // We will make 38 of them completed visits (have checkout and duration)
        // and 5 of them active visits (checked in today, checkout is null)

        for ($i = 1; $i <= 43; $i++) {
            // Pick member type and member randomly
            $isPelajar = (rand(1, 100) <= 50);
            $memberType = $isPelajar ? AnggotaPelajar::class : AnggotaNonPelajar::class;
            $memberId = $isPelajar ? $pelajars->random()->id : $nonPelajars->random()->id;

            // Determine if it is active or completed
            // 5 active visits, only for "today"
            $isActive = ($i > 38);

            if ($isActive) {
                // Checked in today between 1 and 4 hours ago
                $checkin = $now->copy()->subMinutes(rand(60, 240));
                
                VisitorLog::create([
                    'member_type'       => $memberType,
                    'member_id'         => $memberId,
                    'checkin_at'        => $checkin->toDateTimeString(),
                    'checkout_at'       => null,
                    'durasi_kunjungan'  => null,
                ]);
            } else {
                // Completed visits over the last 7 days (day 0 to 6 ago)
                $daysAgo = rand(0, 6);
                $checkin = $now->copy()->subDays($daysAgo)->setHour(rand(8, 17))->setMinute(rand(0, 59))->setSecond(rand(0, 59));
                
                $duration = rand(30, 240); // 30 mins to 4 hours
                $checkout = $checkin->copy()->addMinutes($duration);

                VisitorLog::create([
                    'member_type'       => $memberType,
                    'member_id'         => $memberId,
                    'checkin_at'        => $checkin->toDateTimeString(),
                    'checkout_at'       => $checkout->toDateTimeString(),
                    'durasi_kunjungan'  => $duration,
                ]);
            }
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\InternAttend;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class InternAttendSeeder extends Seeder
{
    public function run(): void
    {
        $allInterns = User::where('role', 'intern')->get();
        $budi = User::where('email', 'budi.intern@example.com')->first();

        if ($budi) {
            $specificData = [
                ['days_ago' => 0, 'status' => 'Hadir', 'check_in' => '08:30:00', 'check_out' => null], // Hari ini
                ['days_ago' => 1, 'status' => 'Hadir', 'check_in' => '08:45:12', 'check_out' => '17:05:30'],
                ['days_ago' => 2, 'status' => 'Sakit', 'check_in' => null, 'check_out' => null],
                ['days_ago' => 3, 'status' => 'Ijin', 'check_in' => null, 'check_out' => null],
                ['days_ago' => 4, 'status' => 'Hadir', 'check_in' => '09:00:00', 'check_out' => '17:00:00'],
            ];

            foreach ($specificData as $data) {
                $date = Carbon::today('Asia/Kuala_Lumpur')->subDays($data['days_ago']);
                if ($date->isWeekend()) continue;

                InternAttend::create([
                    'user_id' => $budi->id,
                    'tanggal' => $date->toDateString(),
                    'status' => $data['status'],
                    'jam_masuk' => $data['check_in'],
                    'jam_keluar' => $data['check_out'],
                ]);
            }
        }

        foreach ($allInterns->where('id', '!=', $budi?->id) as $intern) {
            for ($i = 0; $i < 5; $i++) {
                $date = Carbon::today('Asia/Kuala_Lumpur')->subDays($i);
                if ($date->isWeekend()) continue;

                InternAttend::create([
                    'user_id' => $intern->id,
                    'tanggal' => $date->toDateString(),
                    'status' => 'Hadir',
                    'jam_masuk' => '09:00:00',
                    'jam_keluar' => '17:00:00',
                ]);
            }
        }
    }
}
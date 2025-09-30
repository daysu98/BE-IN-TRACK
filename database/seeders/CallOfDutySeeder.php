<?php

namespace Database\Seeders;

use App\Models\CallOfDuty;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CallOfDutySeeder extends Seeder
{
    public function run(): void
    {
        $interns = User::where('role', 'intern')->get();
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        $dayIndex = 0;

        foreach ($interns as $intern) {
            CallOfDuty::create([
                'user_id' => $intern->id,
                'days' => $days[$dayIndex % count($days)]
            ]);

            $dayIndex++;
        }
    }
}
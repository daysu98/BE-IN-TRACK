<?php

namespace App\Console\Commands;

use App\Enums\CheckAttendStatus;
use App\Models\InternAttend;
use App\Models\TempInternAttend;
use App\Models\User;
use Illuminate\Console\Command;

class SetAttendAt5PM extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:set-attendance-at-5pm';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set attend if not attending yet';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $usersId = User::where('role', '=', 'intern')->pluck('id')->toArray();

        foreach ($usersId as $id) {
            $check = InternAttend::where('tanggal', today('Asia/Kuala_Lumpur')->toDateString())->where('user_id', $id)->exists();

            if (!$check) {
                $data = InternAttend::create(
                    [
                        'user_id' => $id,
                        'status' => CheckAttendStatus::ALPA->value,
                        'tanggal' => today('Asia/Kuala_Lumpur')->toDateString(),
                        'jam_masuk' => null,
                        'jam_keluar' => null,
                    ]
                );

                TempInternAttend::create(
                    [
                        'intern_attend_id' => $data->id,
                        'user_id' => $data->user_id,
                        'status' => $data->status,
                        'tanggal' => $data->tanggal,
                        'jam_masuk' => $data->jam_masuk,
                        'jam_keluar' => $data->jam_keluar,
                        'expired_at' => now('Asia/Kuala_Lumpur')->addWeek(),
                    ]
                );

            }
        }

        $this->info("Successful Created!");
    }
}

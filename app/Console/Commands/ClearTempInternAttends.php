<?php

namespace App\Console\Commands;

use App\Models\TempInternAttend;
use Illuminate\Console\Command;

class ClearTempInternAttends extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clear-temp-intern-attends';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete expired temp intern attends';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        TempInternAttend::where('expired_at', '<=', now('Asia/Kuala_Lumpur'))->delete();
        $this->info('Expired temp intern attends cleared!');

        // for json. I don't know this gonna work or not.
        // response()->json([
        //     'message' => 'Expired temp intern attends cleared!',
        // ]);
    }
}

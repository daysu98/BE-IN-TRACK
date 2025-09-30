<?php

namespace App\Console\Commands;

use App\Models\TempJobIntern;
use Illuminate\Console\Command;

class ClearTempJobInterns extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clear-temp-job-interns';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete expired temp job interns';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        TempJobIntern::where('expired_at', '<=', now('Asia/Kuala_Lumpur'))->delete();
        $this->info('Expired temp job interns cleared!');

        // for json. I don't know this gonna work or not.
        // response()->json([
        //     'message' => 'Expired temp job interns cleared!',
        // ]);
    }
}

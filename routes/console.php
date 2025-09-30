<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// for clear table intern attends.
Schedule::command('app:clear-temp-intern-attends')->weekly();

// for clear table job interns.
Schedule::command('app:clear-temp-job-interns')->weekly();

// token expiration.
Schedule::command('sanctum:prune-expired --hours=6')->everySixHours();

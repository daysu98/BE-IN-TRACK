<?php

namespace App\Repositories\InternAttend;

use LaravelEasyRepository\Repository;

interface InternAttendRepository extends Repository
{
    public function getDataAttend();
}

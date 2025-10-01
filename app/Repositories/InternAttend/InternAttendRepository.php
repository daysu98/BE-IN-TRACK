<?php

namespace App\Repositories\InternAttend;

use App\Models\InternAttend;
use LaravelEasyRepository\Repository;

interface InternAttendRepository extends Repository
{
    public function getDataAttend();

    public function checkIfAttendIsExist($userId): bool;

    public function checkIfInternHasBeenCheckout(): InternAttend;
}

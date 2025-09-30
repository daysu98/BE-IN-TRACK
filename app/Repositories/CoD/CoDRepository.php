<?php

namespace App\Repositories\CoD;

use LaravelEasyRepository\Repository;

interface CoDRepository extends Repository
{
    public function getDataCoD();
}

<?php

namespace App\Services\CoD;

use LaravelEasyRepository\BaseService;

interface CoDService extends BaseService
{
    public function getDataCoD();

    public function getCoDById($id);

    public function createCoD();

    public function updateCoD($id);

    public function deleteCoDById($id);
}

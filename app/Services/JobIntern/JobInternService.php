<?php

namespace App\Services\JobIntern;

use LaravelEasyRepository\BaseService;

interface JobInternService extends BaseService
{
    public function getDataInternJob();

    public function getDataJobInternById($id);

    public function createInternJob();

    public function updateInternJob($id);

    public function deleteJobInternById($id);
}

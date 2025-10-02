<?php

namespace App\Repositories\User;

use Illuminate\Database\Eloquent\Collection;
use LaravelEasyRepository\Repository;

interface UserRepository extends Repository
{
    public function getDataUser();

    public function checkIfAdminExist(): bool;

    public function checkIfInternBypassTheManageBy($userName);

    public function getStaffList();
}

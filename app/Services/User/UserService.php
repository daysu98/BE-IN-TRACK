<?php

namespace App\Services\User;

use LaravelEasyRepository\BaseService;

interface UserService extends BaseService
{
    public function getDataUser();

    public function getUserById($id);

    public function getStaffUser();

    public function createUser();

    public function updateUser($id);

    public function deleteUserById($id);
}

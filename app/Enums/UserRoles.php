<?php

namespace App\Enums;

enum UserRoles: string
{
    case ADMIN = "admin";

    case STAFF = "staff";

    case INTERN = "intern";
}

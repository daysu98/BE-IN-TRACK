<?php

namespace App\Enums;

enum CheckJobStatus: string
{
    case PENDING = 'Pending';
    case DONE = 'Done';
}

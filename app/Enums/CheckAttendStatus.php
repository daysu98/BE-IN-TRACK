<?php

namespace App\Enums;

enum CheckAttendStatus: string
{
    case HADIR = 'Hadir';
    case IJIN = 'Ijin';
    case SAKIT = 'Sakit';
    case ALPA = 'Alpa';
}

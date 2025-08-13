<?php

namespace App\Services;

use Carbon\Carbon;

class DateService
{
    public static function getCurrentYear(): int
    {
        if (now()->month > 8) {
            return now()->year + 1;
        } else {
            return now()->year;
        }
    }

    public static function getSeasonYear(Carbon $date): int
    {
        if ($date->month > 8) {
            return $date->year + 1;
        } else {
            return $date->year;
        }
    }

    public static function getSeasonBreak(): Carbon
    {
        if (now()->month > 10) {
            return Carbon::createMidnightDate(now()->year, '11', '1');
        } else {
            return Carbon::createMidnightDate(now()->year + 1, '11', '1');
        }
    }
}

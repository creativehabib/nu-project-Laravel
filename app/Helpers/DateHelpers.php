<?php

namespace App\Helpers;

use Carbon\Carbon;

class DateHelpers
{
    /**
     * @param $birthDate
     * @return string
     */
    public static function calculatePRLDate($birthDate): string
    {
        return Carbon::parse($birthDate)->addYears(60)->toDateString(); // Returns YYYY-MM-DD
    }
}

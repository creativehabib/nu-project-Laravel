<?php

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class DateHelpers
{
    /**
     * @param $birthDate
     * @return string
     */
    public static function calculatePRLDate($birthDate, $years): string
    {
        return Carbon::parse($birthDate)->addYears($years)->toDateString();
    }
    public static function deleteFile(?string $fileName, string $uploadPath): void
    {
        if(!$fileName) return;
        $filePath = public_path($uploadPath . $fileName);
        if(File::exists($filePath)){
            File::delete($filePath);
        }
    }

    public static function dateFormat(string $date, $format = 'F j, Y'): string
    {
        return Carbon::parse($date)->format($format);
    }
}

<?php

namespace App\Sanitizers;

use function preg_replace;

class PhoneSanitize
{
    public static function sanitize(?string $value) : ?string
    {
        if ($value === null) {
            return null;
        }
        $phone = preg_replace('/\D+/', '', $value);
        $phone[0] = '7';
        return $phone;
    }
}

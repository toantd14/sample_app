<?php

use Carbon\Carbon;

if (!function_exists('formatDateString')) {
    function formatDateString($date, string $format = 'Y/m/d')
    {
        if ($date instanceof \Carbon\Carbon) {
            return $date->format($format);
        }

        if (preg_match(config('constants.STRING_YYYY/MM/DD'), $date)) {
            $date = new Carbon($date);

            return $date->format($format);
        }

        return $date;
    }
}

if (!function_exists('formatPrice')) {
    function formatPrice($price)
    {
        return '¥' . number_format($price, 0, ',', ',');
    }
}

if (!function_exists('formatFullDateStringJapanese')) {
    function formatFullDateStringJapanese($date)
    {
        if ($date instanceof \Carbon\Carbon) {
            return $date->format('y年m月d日');
        }

        return $date;
    }
}

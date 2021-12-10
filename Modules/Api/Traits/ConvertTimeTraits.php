<?php

namespace Modules\Api\Traits;

trait ConvertTimeTraits
{
    public function convertHourToNumber($hour)
    {
        $arr = explode(":", $hour);

        return intval($arr[0]) + intval($arr[1]) / config('constants.PER_HOUR');
    }

    public function checkDateInWeek($date)
    {
        $date = strtotime($date);
        $date = date(config('constants.FULL_WEEKDAY'), $date);
        $date = strtolower($date);

        return $date;
    }
    public function checkDate($startDate)
    {
        $date = $this->checkDateInWeek($startDate);
        switch ($date) {
            case 'sunday':
                return config('constants.DATE_TYPE_PARKING_TIME_API.SUNDAY');
            case 'saturday':
                return config('constants.DATE_TYPE_PARKING_TIME_API.SATURDAY');
            default:
                return config('constants.DATE_TYPE_PARKING_TIME_API.WEEKDAY');
        }
    }

    public function replaceTime($time)
    {
        return str_replace("-", "/", $time);
    }

}

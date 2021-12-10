<?php

namespace Modules\Owner\Http\Traits;

use Carbon\Carbon;

trait DateTimeTraits
{
    public function compareTime($time1, $time2)
    {
        return Carbon::parse($time1) == Carbon::parse($time2);
    }

    public function compareMenuTimeWithBusinessHours($menuTime, $businessHours, $lengthArray)
    {
        if (
            !$this->compareTime($menuTime[0]['from_time'], $businessHours['from_time']) ||
            !$this->compareTime($menuTime[$lengthArray - 1]['to_time'], $businessHours['to_time'])
        ) {
            return false;
        }
        for ($i = 0; $i < $lengthArray - 1; $i++) {
            if (!$this->compareTime($menuTime[$i]['to_time'], $menuTime[$i + 1]['from_time'])) {
                return false;
            }
        }

        return true;
    }
}

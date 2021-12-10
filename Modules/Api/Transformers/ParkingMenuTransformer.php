<?php

namespace Modules\Api\Transformers;

use Carbon\Carbon;
use App\Models\ParkingMenu;
use League\Fractal\TransformerAbstract;

class ParkingMenuTransformer extends TransformerAbstract
{
    public function transform(ParkingMenu $parkingMenu)
    {
        return [
            'time' => $this->getTimeTypeFlagAndPrice($parkingMenu, 'time'),
            'day' => $this->getTimeTypeFlagAndPrice($parkingMenu, 'day'),
            'month' => $this->getTimeTypeFlagAndPrice($parkingMenu, 'month'),
            'period' => $this->getTimeTypeFlagAndPrice($parkingMenu, 'period'),
        ];
    }

    public function getTimeTypeFlagAndPrice(ParkingMenu $parkingMenu, string $timeType)
    {
        $flagSuffix = $timeType . '_flg';
        $priceSuffix = $timeType . '_price';
        $price = $parkingMenu[$priceSuffix];

        if ($timeType == 'time') {
            $price = [];
            $listDayTypes = array_keys($parkingMenu->parkingMenuTime->groupBy('day_type')->toArray());
            foreach ($listDayTypes as $dayType) {
                $price[] = (object)[
                    'dayType' => $dayType,
                    'timePrice' => $this->getTimePriceByDayType($parkingMenu, $dayType)
                ];
            }
        }

        if ($timeType == 'month') {
            return (object)[
                'isEnable' => boolval($parkingMenu[$flagSuffix]) ? false : true,
                'price' => $price,
                'minUse' => $parkingMenu['minimum_use'],
            ];
        }

        if ($timeType == 'period') {
            return (object)[
                'isEnable' => boolval($parkingMenu[$flagSuffix]) ? false : true,
                'price' => $price,
                'startTime' => $parkingMenu['period_fromtime'],
                "endTime" => $parkingMenu['period_totime'],
                "startDate" => Carbon::parse($parkingMenu['period_fromday'])->format(config('constants.API.DATE_FORMAT')),
                "endDate" => Carbon::parse($parkingMenu['period_today'])->format(config('constants.API.DATE_FORMAT')),
                "dayEnable" => boolval($parkingMenu['period_dayflg']) ? true : false,
                "weekEnable" => boolval($parkingMenu['period_week']) ? true : false,
                "weekDay" => [
                    boolval($parkingMenu['period_monday']) ? true : false,
                    boolval($parkingMenu['period_tuesday']) ? true : false,
                    boolval($parkingMenu['period_wednesday']) ? true : false,
                    boolval($parkingMenu['period_thursday']) ? true : false,
                    boolval($parkingMenu['period_friday']) ? true : false,
                    boolval($parkingMenu['period_saturday']) ? true : false,
                    boolval($parkingMenu['period_sunday']) ? true : false,
                    boolval($parkingMenu['period_holiday']) ? true : false,
                ]
            ];
        }

        return (object)[
            'isEnable' => boolval($parkingMenu[$flagSuffix]) ? false : true,
            'price' => $price,
        ];
    }

    public function getTimePriceByDayType(ParkingMenu $parkingMenu, int $dayType)
    {
        $result = [];
        $timePrices = $parkingMenu->parkingMenuTime->filter(function ($parkingMenuTime) use ($dayType) {
            return $parkingMenuTime->day_type == $dayType;
        });

        foreach ($timePrices as $timePrice) {
            $result[] = (object)[
                'from' => $timePrice->from_time,
                'to' => $timePrice->to_time,
                'price' => $timePrice->price,
            ];
        }

        return $result;
    }
}

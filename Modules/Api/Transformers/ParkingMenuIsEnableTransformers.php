<?php

namespace Modules\Api\Transformers;

use App\Models\ParkingMenu;
use League\Fractal\TransformerAbstract;

class ParkingMenuIsEnableTransformers extends TransformerAbstract
{
    public function transform(ParkingMenu $parkingMenu)
    {
        return [
            "time" => $this->isEnable($parkingMenu->time_flg),
            "day" => $this->isEnable($parkingMenu->day_flg),
            "month" => $this->isEnable($parkingMenu->month_flg),
            "period" => $this->isEnable($parkingMenu->period_flg)
        ];
    }

    protected function isEnable($isEnable)
    {
        return ['isEnable' => $isEnable ? false : true];
    }
}

<?php

namespace Modules\Admin\Repositories\ParkingMenuTime;

use App\Models\ParkingLot;
use App\Models\ParkingMenuTime;
use Modules\Api\Traits\ConvertTimeTraits;
use Modules\Admin\Repositories\RepositoryAbstract;

class AdminParkingMenuTimeRepository extends RepositoryAbstract implements AdminParkingMenuTimeRepositoryInterface
{
    use ConvertTimeTraits;

    public function __construct(ParkingMenuTime $parkingMenuTime)
    {
        $this->model = $parkingMenuTime;
    }

    public function getByOwnerCd($ownerCd)
    {
        return $this->model->find($ownerCd, 'owner_cd');
    }

    public function deleteById($id)
    {
        return $this->model->id($id)->delete();
    }

    public function deleteByMenuCdAndDayType($menuCd)
    {
        return $this->model->menuCd($menuCd)->delete();
    }

    public function getByMenuCd($menu_cd)
    {
        return $this->model->where('menu_cd', $menu_cd)->get();
    }

    public function replicateMenuTime($menuTime)
    {
        $getMenuTime = $this->model->where('id', $menuTime['id'])->first();
        $getMenuTime->from_time = $menuTime['from_time'];
        $getMenuTime->to_time = $menuTime['to_time'];
        $cloneMenuTime = $getMenuTime->replicate();
        $cloneMenuTime->save();

        return $cloneMenuTime;
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

    public function calculateTime($menuCD, $startDate, $startTime, $endTime)
    {
        $dateType = $this->checkDate($startDate);
        if ($startDate == config('constants.DATE_TYPE_PARKING_TIME_API.HOLIDAY')) {
            $dateType = config('constants.DATE_TYPE_PARKING_TIME_API.HOLIDAY');
        }

        $menuTimes = $this->model->where([
            ['menu_cd', $menuCD],
            ['day_type', $dateType]
        ])->get();

        $convertArrMenuTime = [];
        if ($startTime > $endTime)
            return false;

        //convert về mảng chỉ gồm 3 phần từ : from_time, to_time, money_per_one_time
        foreach ($menuTimes as $menuTime) {
            $convertArrMenuTime[] = array('from_time' => $menuTime->from_time, 'to_time' => $menuTime->to_time, 'money_per_one_time' => $menuTime->price);
        }
        sort($convertArrMenuTime);
        $total = 0;
        foreach ($convertArrMenuTime as $value) {
            $result = $this->countPeriodHours($startTime, $endTime, $value['from_time'], $value['to_time']);
            if ($result['hours'] > 0) {
                $startTime = $result['end'];
                $total += $value['money_per_one_time'];
            }
        }

        return $total;
    }

    public function countPeriodHours($startTimeA, $endTimeA, $startTimeB, $endTimeB)
    {
        $start = $startTimeA > $startTimeB ? $startTimeA : $startTimeB;
        $end = $endTimeA < $endTimeB ? $endTimeA : $endTimeB;

        $hours = $end <= $start ? 0 : $this->convertHourToNumber($end) - $this->convertHourToNumber($start);

        return [
            'hours' => $hours,
            'end' => $end
        ];
    }

    public function getMenuTimeByMenuCdAndCheck($parking, $menuCd)
    {
        $dataCheck = [
            'openTime' => config('constants.TIME.START_OF_DAY'),
            'closedTime' => config('constants.TIME.END_OF_DAY'),
            'menuCd' => $menuCd
        ];

        if ($parking->sales_division == ParkingLot::SALES_DIVISION_DISABLE) {
            $dataCheck['openTime'] = $parking->sales_start_time;
            $dataCheck['closedTime'] = $parking->sales_end_time;
        }

        $menuTime = $this->generateMenuTimeByTypeArray($dataCheck);

        return $menuTime;
    }

    public function generateMenuTimeByTypeArray($dataCheck)
    {
        $menuTimeArray = [];

        $dayType = [
            ParkingMenuTime::WEEKDAYS,
            ParkingMenuTime::SATURDAY,
            ParkingMenuTime::SUNDAY,
            ParkingMenuTime::HOLIDAYS
        ];

        foreach ($dayType as $item) {
            $menuTime = $this->getMenuTimeByType($dataCheck, $item);

            if (!empty($menuTime)) {
                $menuTimeArray = array_merge($menuTimeArray, $this->getMenuTimeByType($dataCheck, $item));
            }
        }

        return $menuTimeArray;
    }

    public function getMenuTimeByType($dataCheck, $item)
    {
        $dataMenuTimeOpen = [];
        $dataMenuTimeByType = [];
        $menuTimeWithType = $this->model->where('menu_cd', $dataCheck['menuCd'])
            ->where('day_type', $item)
            ->get()
            ->toArray();
        foreach ($menuTimeWithType as $item) {
            if ($item['from_time'] >= $dataCheck['openTime'] || $item['to_time'] >= $dataCheck['openTime']) {
                array_push($dataMenuTimeOpen, $item);
            }
        }

        if ($dataMenuTimeOpen && count($dataMenuTimeOpen) == 1) {
            $dataMenuTimeByType = $dataMenuTimeOpen;
        } else {
            foreach ($dataMenuTimeOpen as $val) {
                if ($val['to_time'] <= $dataCheck['closedTime'] || $val['from_time'] <= $dataCheck['closedTime']) {
                    array_push($dataMenuTimeByType, $val);
                }
            }
        }

        if (!empty($dataMenuTimeByType) && $dataMenuTimeByType[0]['from_time'] < $dataCheck['openTime']) {
            $dataMenuTimeByType[0]['from_time'] = $dataCheck['openTime'];
        }

        if (!empty($dataMenuTimeByType) && $dataMenuTimeByType[count($dataMenuTimeByType) - 1]['to_time'] > $dataCheck['closedTime']) {
            $dataMenuTimeByType[count($dataMenuTimeByType) - 1]['to_time'] = $dataCheck['closedTime'];
        }

        return $dataMenuTimeByType;
    }
}

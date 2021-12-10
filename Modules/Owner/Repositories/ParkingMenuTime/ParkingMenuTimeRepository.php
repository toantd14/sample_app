<?php

namespace Modules\Owner\Repositories\ParkingMenuTime;

use App\Models\ParkingLot;
use App\Models\ParkingMenuTime;
use Carbon\Carbon;
use Modules\Api\Repositories\Holiday\HolidayRepository;
use Modules\Api\Traits\ConvertTimeTraits;
use Modules\Owner\Repositories\RepositoryAbstract;

class ParkingMenuTimeRepository extends RepositoryAbstract implements ParkingMenuTimeRepositoryInterface
{
    use ConvertTimeTraits;

    protected $holidayRepository;

    public function __construct(
        ParkingMenuTime $parkingMenuTime,
        HolidayRepository $holidayRepository
    )
    {
        $this->model = $parkingMenuTime;
        $this->holidayRepository = $holidayRepository;
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

    public function getByMenuCd($menuCd)
    {
        return $this->model->where('menu_cd', $menuCd)->pluck('id')->toArray();
    }

    public function getMenuTimeByMenuCd($menuCd)
    {
        return $this->model->where('menu_cd', $menuCd)->orderBy('day_type', 'asc')->orderBy('from_time', 'asc')->get();
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

    public function getDayType($startDate)
    {
        return $this->holidayRepository->checkHoliday($startDate) ? config('constants.DATE_TYPE_PARKING_TIME_API.HOLIDAY') : $this->checkDate($startDate);
    }

    public function getMenuTimesByDayTypeAndMenuCd($menuCD, $dateType)
    {
        $menuTimes = $this->model->where([
            ['menu_cd', $menuCD],
            ['day_type', $dateType]
        ])->orderBy('from_time', 'asc')->get();

        $convertArrMenuTime = [];
        //convert về mảng chỉ gồm 3 phần từ : from_time, to_time, money_per_one_time
        foreach ($menuTimes as $menuTime) {
            $convertArrMenuTime[] = array('from_time' => $menuTime->from_time, 'to_time' => $menuTime->to_time, 'money_per_one_time' => $menuTime->price);
        }

        return $convertArrMenuTime;
    }

    public function calculateTime($menuCD, $startDate, $startTime, $endTime)
    {
        $dateType = $this->getDayType($startDate);
        $convertArrMenuTime = $this->getMenuTimesByDayTypeAndMenuCd($menuCD, $dateType);

        if ($startTime > $endTime) {
            $sum = $this->getPriceOnPeriod($convertArrMenuTime, $startTime, config('constants.TIME.END_OF_DAY'));
            $startDate = Carbon::parse($startDate)->addDay()->toDateString();
            $dateType = $this->getDayType($startDate);

            $convertArrMenuTime = $this->getMenuTimesByDayTypeAndMenuCd($menuCD, $dateType);
            $sum += ($endTime > config('constants.TIME.START_OF_DAY')) ? $this->getPriceOnPeriod($convertArrMenuTime, config('constants.TIME.START_OF_DAY'), $endTime) : 0;
        } else {
            if ($startTime === config('constants.TIME.START_OF_DAY') && $endTime === config('constants.TIME.START_OF_DAY')) {
                $sum = $this->getPriceOnPeriod($convertArrMenuTime, $startTime, config('constants.TIME.END_OF_DAY'));
            } else {
                $sum = $this->getPriceOnPeriod($convertArrMenuTime, $startTime, $endTime);
            }
        }

        return $sum;
    }

    public function getPriceOnPeriod($convertArrMenuTime, $startTime, $endTime)
    {
        $sum = 0;
        $bookingTimes = array_filter($convertArrMenuTime,
            function ($key) use ($startTime, $endTime) {
                return ($startTime >= $key['from_time'] && $startTime < $key['to_time'])
                    || ($endTime <= $key['to_time'] && $endTime > $key['from_time'])
                    || ($endTime >= $key['to_time'] && $startTime <= $key['from_time']);
            }
        );

        foreach ($bookingTimes as $value) {
            $sum += $value['money_per_one_time'];
        }

        return $sum;
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
            ->orderBy('from_time', 'asc')
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

<?php

namespace Modules\Owner\Repositories\ParkingMenu;

use Carbon\Carbon;
use App\Models\ParkingMenu;
use Illuminate\Support\Facades\Auth;
use Modules\Api\Traits\ConvertTimeTraits;
use Modules\Owner\Repositories\RepositoryAbstract;

class ParkingMenuRepository extends RepositoryAbstract implements ParkingMenuRepositoryInterface
{
    use ConvertTimeTraits;

    public function __construct(ParkingMenu $parkingMenu)
    {
        $this->model = $parkingMenu;
    }

    public function getByOwnerCd($owner_cd)
    {
        return $this->model->ownerCd($owner_cd)->first();
    }

    public function getMenuMaster($ownerCd)
    {
        return $this->model->menuMaster($ownerCd)->first();
    }

    public function replicateMenuMaster($parkingMenuMaster)
    {
        $cloneMenu = $parkingMenuMaster->replicate();
        $cloneMenu->save();

        return $cloneMenu;
    }

    public function getMenuByParkingCD($parkingCD)
    {
        return $this->model->where('parking_cd', $parkingCD)->first();
    }

    public function getFromAndToTime($parkingMenu)
    {
        return [
            'from_day' => $parkingMenu->period_fromday,
            'to_day' => $parkingMenu->period_today
        ];
    }

    public function calculatorPeriod($parkingMenu, $startDate, $endDate, $holidays)
    {
        $startDate = $this->replaceTime($startDate);
        $endDate = $this->replaceTime($endDate);
        $periodFrom = $parkingMenu->period_fromday;
        $periodTo = $parkingMenu->period_today;
        if ((
                $startDate < $periodFrom || $startDate > $periodTo ||
                $endDate < $periodFrom || $endDate > $periodTo ||
                $startDate > $endDate) && $parkingMenu->period_week == config('constants.STATUS_PERIOD.PRIVATE')
        ) {
            return false;
        }

        $endDate = Carbon::parse($endDate);
        $startDate = Carbon::parse($startDate);
        $diff = $endDate->diffInDays($startDate);

        if ($parkingMenu->period_week == config('constants.STATUS_PERIOD.PUBLIC')) {
            $dataPeriodWeeks = $this->getPeriodWeeksData($parkingMenu);
            $holidayPrice = 0;
            $count = 0;
            $arrDate = [];

            if ($parkingMenu->period_holiday == config('constants.STATUS_PERIOD.PUBLIC')) {
                $holidayPrice = $this->calculateHoliday($diff, (clone $startDate), $holidays, $dataPeriodWeeks) * $parkingMenu['period_price'];
            }

            foreach ($dataPeriodWeeks as $key => $value) {
                if ($value == config('constants.STATUS_PERIOD.PUBLIC')) {
                    $count++;
                    array_push($arrDate, $key);
                }
            }

            if ($diff < config('constants.DAY_IN_WEEK')) {
                $countDay = $this->calculateCountDayInWeek($diff, (clone $startDate), $arrDate);
                $price = intval($countDay * $parkingMenu['period_price'] + $holidayPrice);
                if ($price == config('constants.PRICE_ZERO')) {
                    return [
                        'code' => config('constants.CHECK_DATE_FIT'),
                        'message' => trans('message.check_date_fit')
                    ];
                }

                return $price;
            }

            $countWeek = intval($diff / config('constants.DAY_IN_WEEK'));
            $dayDiffWeek = intval($diff % config('constants.DAY_IN_WEEK'));

            $startDay = ((clone $endDate)->subDays($dayDiffWeek));
            $diff = (clone $endDate)->diffInDays((clone $startDay));
            $countDay = $this->calculateCountDayInWeek($diff, (clone $startDay), $arrDate);

            return intval(($count * $countWeek + $countDay) * $parkingMenu['period_price'] + $holidayPrice);
        }

        if (
            $parkingMenu->period_dayflg == config('constants.STATUS_PERIOD.PUBLIC') &&
            $parkingMenu->period_week == config('constants.STATUS_PERIOD.PRIVATE')
        ) {
            return intval(($diff + 1) * $parkingMenu['period_price']);
        }

        return false;
    }

    public function calculateCountDayInWeek($diff, $startDate, $arrDate)
    {
        $startDate = $startDate->subDay();
        $countDay = 0;
        for ($i = 0; $i <= $diff; $i++) {
            $addDate = $this->checkDateInWeek($startDate->addDay());
            foreach ($arrDate as $key => $value) {
                if ($value == $addDate) {
                    $countDay++;
                }
            }
        }

        return $countDay;
    }

    public function calculateHoliday($diff, $startDate, $holidays, $dataPeriodWeeks)
    {
        $dates = [];
        $arrDateHoliday = [];
        $count = 0;
        $startDate = $startDate->subDay();
        for ($i = 0; $i <= $diff; $i++) {
            $dates[] = $this->replaceTime($startDate->addDay()->toDateString());
        }

        foreach ($dates as $value) {
            if (in_array($value, $holidays)) {
                $count++;
                $arrDateHoliday[] = $value;
            }
        }

        foreach ($arrDateHoliday as $item) {
            foreach ($dataPeriodWeeks as $key => $value) {
                if ($value == config('constants.STATUS_PERIOD.PUBLIC') && $this->checkDateInWeek($item) == $key) {
                    $count--;
                }
            }
        }

        return $count;
    }

    public function getPeriodWeeksData($parkingMenu)
    {
        return [
            'monday' => $parkingMenu['period_monday'],
            'tuesday' => $parkingMenu['period_tuesday'],
            'wednesday' => $parkingMenu['period_wednesday'],
            'thursday' => $parkingMenu['period_thursday'],
            'friday' => $parkingMenu['period_friday'],
            'saturday' => $parkingMenu['period_saturday'],
            'sunday' => $parkingMenu['period_sunday'],
        ];
    }
}

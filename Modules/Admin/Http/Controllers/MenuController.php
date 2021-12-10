<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\ParkingLot;
use App\Models\ParkingMenu;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\ParkingMenuTime;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Modules\Owner\Http\Traits\DateTimeTraits;
use Modules\Owner\Http\Traits\ResponseTraits;
use Modules\Owner\Http\Requests\Menu\DayRequest;
use Modules\Owner\Http\Requests\Menu\TimeRequest;
use Modules\Owner\Http\Requests\Menu\PeriodRequest;
use Modules\Owner\Http\Requests\Menu\MonthlyRequest;
use Modules\Owner\Repositories\Parking\ParkingLotRepositoryInterface;
use Modules\Owner\Repositories\ParkingMenu\ParkingMenuRepositoryInterface;
use Modules\Owner\Repositories\ParkingMenuTime\ParkingMenuTimeRepositoryInterface;

class MenuController extends Controller
{
    //TODO after, must move to code to repository
    use DateTimeTraits;
    use ResponseTraits;

    protected $parkingMenuRepository;
    protected $parkingLotRepository;
    protected $parkingMenuTimeRepository;

    public function __construct(
        ParkingMenuRepositoryInterface $parkingMenuRepository,
        ParkingLotRepositoryInterface $parkingLotRepository,
        ParkingMenuTimeRepositoryInterface $parkingMenuTimeRepository
    ) {
        $this->parkingMenuRepository = $parkingMenuRepository;
        $this->parkingLotRepository = $parkingLotRepository;
        $this->parkingMenuTimeRepository = $parkingMenuTimeRepository;
    }

    public function createOrUpdateMenuMonth(MonthlyRequest $request)
    {
        $parkingMenu = $this->parkingMenuRepository->getMenuByParkingCD($request->parking_cd);
        if (!$parkingMenu) {
            return $this->handleNotFoundException(__('message.menu_parking_lot.not_found_exception'));
        }

        $dataUpdate = $this->dataUpdateMenuMonth($request->all());
        $this->parkingMenuRepository->update($parkingMenu->menu_cd, $dataUpdate);

        return response()->json([
            'message' =>  __('message.menu.month.update_success')
        ], Response::HTTP_OK);
    }

    public function createOrUpdateMenuDay(DayRequest $request)
    {
        $parkingMenu = $this->parkingMenuRepository->getMenuByParkingCD($request->parking_cd);

        $dataUpdate = $this->dataUpdateMenuDay($request->all());
        $this->parkingMenuRepository->update($parkingMenu->menu_cd, $dataUpdate);

        return response()->json([
            'message' =>  __('message.menu.day.update_success')
        ], Response::HTTP_OK);
    }

    public function createOrUpdateMenuPeriod(PeriodRequest $request)
    {
        $parkingMenu = $this->parkingMenuRepository->getMenuByParkingCD($request->parking_cd);
        $dataUpdate = $this->dataMenuPeriod($request->all());
        $this->parkingMenuRepository->update($parkingMenu->menu_cd, $dataUpdate);

        return response()->json([
            'message' =>  __('message.menu.period.update_success')
        ], Response::HTTP_OK);
    }

    public function createOrUpdateMenuTime(TimeRequest $request)
    {

        $request['openHour'] = config('constants.TIME.START_OF_DAY');
        $request['closedHour'] = config('constants.TIME.END_OF_DAY');

        if (!$request->menu_cd) {
            return $this->handleUnprocessableEntity(__('message.menu_parking_lot.create_menu_before'));
        }

        if ($request->parking_cd) {
            return $this->handleParkingMenuTime($request);
        }

        return $this->handleMenuTime($request);
    }

    public function updateMenuFlg(Request $request)
    {
        $parkingMenu = $this->parkingMenuRepository->getMenuByParkingCD($request->parking_cd);
        $menuCd = $request->menu_cd ?? $parkingMenu->menu_cd;
        if ($request->flg_data != null) {
            $lfgData = $request->flg_data == ParkingMenu::FLG_DISABLE ? ParkingMenu::FLG_ENABLE : ParkingMenu::FLG_DISABLE;
        } else {
            $lfgData = ParkingMenu::FLG_ENABLE;
        }

        $this->parkingMenuRepository->update($menuCd, [
            $request->flg_name => $lfgData
        ]);

        return response()->json(
            [
                'success' => __('message.menu_parking_lot.update_success')
            ],
            Response::HTTP_OK
        );
    }

    protected function dataUpdateMenuMonth($dataRequest)
    {
        return [
            'month_flg' => $dataRequest['month_flg'],
            'parking_cd' => $dataRequest['parking_cd'] ?? null,
            'month_price' => $dataRequest['month_price'] ?? 0,
            'minimum_use' => $dataRequest['minimum_use'] ?? 0,
            'registered_person' => $dataRequest['registered_person'] ?? null,
            'updater' => Auth::guard('admin')->user()->name_mei,
        ];
    }

    protected function dataUpdateMenuDay($dataRequest)
    {
        return [
            'day_flg' => $dataRequest['day_flg'],
            'parking_cd' => $dataRequest['parking_cd'] ?? null,
            'day_price' => $dataRequest['day_price'] ?? 0,
            'registered_person' => $dataRequest['registered_person'] ?? null,
            'updater' => Auth::guard('admin')->user()->name_mei,
        ];
    }

    protected function dataMenuPeriod($dataRequest)
    {
        $dataMenuPeriod = [
            'parking_cd' => $dataRequest['parking_cd'],
            'period_flg' => $dataRequest['period_flg'],
            'period_week' => $dataRequest['period_week'] ?? ParkingMenu::PERIOD_WEEK_FLG_DISABLE,
            'period_timeflg' => $dataRequest['period_timeflg'] ?? ParkingMenu::TIME_FLG_DISABLE,
            'period_fromtime' => $dataRequest['period_fromtime'] ?? null,
            'period_totime' => $dataRequest['period_totime'] ?? null,
            'period_dayflg' => $dataRequest['period_dayflg'] ?? ParkingMenu::PERIOD_DAY_FLG_DISABLE,
            'period_fromday' => $dataRequest['period_fromday'] ?? null,
            'period_today' => $dataRequest['period_today'] ?? null,
            'period_price' => $dataRequest['period_price'] ?? 0,
            'updater' => Auth::guard('admin')->user()->name_mei,
        ];

        $dayOfWeek = [
            0 => 'period_monday',
            1 => 'period_tuesday',
            2 => 'period_wednesday',
            3 => 'period_thursday',
            4 => 'period_friday',
            5 => 'period_saturday',
            6 => 'period_sunday',
            7 => 'period_holiday',
        ];

        foreach ($dayOfWeek as $key => $day) {
            $dataMenuPeriod[$day] = $dataRequest['period_week_data'][$key] ?? ParkingMenu::PARKING_MENU_OFF;
        }

        return $dataMenuPeriod;
    }

    public function dataMenuTime($dataRequest)
    {
        return [
            'menu_cd' => $dataRequest['menu_cd'] ?? null,
            'day_type' => $dataRequest['day_type'][0],
            'from_time' => $dataRequest['from_time'],
            'to_time' => $dataRequest['to_time'],
            'price' => $dataRequest['price'],
            'registered_person' => $dataRequest['registered_person'] ?? null,
            'updater' => $dataRequest['updater'] ?? null,
        ];
    }

    public function handleMenuTime($request)
    {
        // dissection data and check
        $checkMenuTime = $this->dissectionMenuTime($request);

        if (!$checkMenuTime) {
            return $this->handleUnprocessableEntity(__('message.menu_parking_lot.menu_time_errors'));
        }

        DB::beginTransaction();
        try {
            $this->handleCompreDataMenuTime($request);
            foreach ($request->all()['data'] as $data) {
                if (isset($data['id'])) {
                    $dataUpdate = $this->dataMenuTime($data);
                    $dataUpdate['menu_cd'] = $request->menu_cd;
                    $this->parkingMenuTimeRepository->update($data['id'], $dataUpdate);
                } else {
                    $dataCreate = $this->dataMenuTime($data);
                    $dataCreate['menu_cd'] = $request->menu_cd;
                    $this->parkingMenuTimeRepository->store($dataCreate);
                }
            }
            DB::commit();

            return response()->json([
                'menuTime' => $this->parkingMenuTimeRepository->getMenuTimeByMenuCd($request->menu_cd),
                'messageCreateTime' =>  __('message.menu_parking_lot.menu_time_success')
            ], Response::HTTP_OK);
        } catch (QueryException $e) {
            $this->rollBackTransaction($e);
        }
    }

    public function handleParkingMenuTime($request)
    {
        if ($this->parkingLotRepository->get($request->parking_cd)->sales_division == ParkingLot::SALES_DIVISION_DISABLE) {
            $request['openHour'] = $this->parkingLotRepository->get($request->parking_cd)->sales_start_time;
            $request['closedHour'] = $this->parkingLotRepository->get($request->parking_cd)->sales_end_time;
        }

        $checkMenuTime = $this->dissectionMenuTime($request);

        if (!$checkMenuTime) {
            return $this->handleUnprocessableEntity(__('message.menu_parking_lot.menu_time_errors'));
        }

        DB::beginTransaction();
        try {
            $this->handleCompreDataMenuTime($request);
            foreach ($request->all()['data'] as $data) {
                if (isset($data['id'])) {
                    $dataUpdate = $this->dataMenuTime($data);
                    $dataUpdate['menu_cd'] = $request->menu_cd;
                    $this->parkingMenuTimeRepository->update($data['id'], $dataUpdate);
                } else {
                    $dataCreate = $this->dataMenuTime($data);
                    $dataCreate['menu_cd'] = $request->menu_cd;
                    $this->parkingMenuTimeRepository->store($dataCreate);
                }
            }
            DB::commit();

            return response()->json([
                'menuTime' => $this->parkingMenuTimeRepository->getMenuTimeByMenuCd($request->menu_cd),
                'messageCreateTime' =>  __('message.menu_parking_lot.menu_time_success')
            ], Response::HTTP_OK);
        } catch (QueryException $e) {
            $this->rollBackTransaction($e);
        }
    }

    public function rollBackTransaction($e)
    {
        Log::error($e->getMessage());
        DB::rollBack();
        throw $e;
    }

    public function dissectionMenuTime($request)
    {
        // dissection menu time by day_type after check
        $menuTimeWithType = [
            'timeWeek' => [],
            'timeSat' => [],
            'timeSun' => [],
            'timeHoli' => [],
        ];

        foreach ($request->all()['data'] as $time) {
            if ($time['day_type'] == ParkingMenuTime::WEEKDAYS) {
                array_push($menuTimeWithType['timeWeek'], $time);
            } elseif ($time['day_type'] == ParkingMenuTime::SATURDAY) {
                array_push($menuTimeWithType['timeSat'], $time);
            } elseif ($time['day_type'] == ParkingMenuTime::SUNDAY) {
                array_push($menuTimeWithType['timeSun'], $time);
            } else {
                array_push($menuTimeWithType['timeHoli'], $time);
            }
        }

        foreach ($menuTimeWithType as $item) {
            if (empty($item)) {
                return false;
            }

            if (!$this->checkMenuTime($request, $item)) {
                return false;
            }
        }

        return true;
    }

    public function checkMenuTime($request, $times)
    {
        // get all from_time to_time push to string
        $timeStr = '';

        foreach ($times as $key => $item) {
            $timeStr .= $item['from_time'] . ', ';
            $timeStr .= $item['to_time'] . ', ';
        }

        $timeStr = rtrim($timeStr, ', '); // remove last ', '
        // string to array sort asc
        $timeArr = explode(", ", $timeStr);
        sort($timeArr);

        // check by open and closed time
        if (!($timeArr[0] == $request['openHour'] &&
            end($timeArr) == $request['closedHour'])) {
            return false;
        } else {
            return $this->handCheckMenuTime($timeArr);
        }
    }

    public function handCheckMenuTime($timeArr)
    {
        array_pop($timeArr);
        foreach ($timeArr as $key => $item) {
            if ($key == 0) {
                continue;
            }

            if ((isset($timeArr[2 * $key - 1]) && isset($timeArr[2 * $key]) &&
                    $timeArr[2 * $key - 1] != $timeArr[2 * $key]) ||
                (isset($timeArr[2 * $key + 1]) && isset($timeArr[2 * $key]) &&
                    $timeArr[2 * $key] == $timeArr[2 * $key + 1])
            ) {
                return false;
            }
        }

        return true; // menutime is ok
    }

    public function handleCompreDataMenuTime($request)
    {
        $dataMenuTime = $this->parkingMenuTimeRepository->getByMenuCd($request->menu_cd);
        $dataMenuTimeCompare = [];
        foreach ($request->all()['data'] as $item) {
            if (isset($item['id'])) {
                $dataMenuTimeCompare[] = $item['id'];
            }
        }
        $dataDelete = collect($dataMenuTime)->diff($dataMenuTimeCompare)->all();

        if ($dataDelete) {
            $this->parkingMenuTimeRepository->destroy($dataDelete);
        }
    }

    public function getParkingMenuMaster($request)
    {
        $parkingMenu = $this->parkingMenuRepository->getMenuMaster($request->parking_cd);

        if ($request->menu_cd) {
            $parkingMenu['menu_cd'] = $request->menu_cd;
        }

        return $parkingMenu;
    }
}

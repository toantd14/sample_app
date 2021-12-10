<?php

namespace Modules\Owner\Http\Controllers;

use Carbon\Carbon;
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
use Modules\Owner\Http\Requests\Menu\MenuRequest;
use Modules\Owner\Http\Requests\Menu\TimeRequest;
use Modules\Owner\Http\Requests\Menu\PeriodRequest;
use Modules\Owner\Http\Requests\Menu\MonthlyRequest;
use Modules\Owner\Repositories\Parking\ParkingLotRepositoryInterface;
use Modules\Owner\Repositories\ParkingMenu\ParkingMenuRepositoryInterface;
use Modules\Owner\Repositories\ParkingMenuTime\ParkingMenuTimeRepositoryInterface;

class MenuController extends Controller
{
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

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $parkingMenu = $this->getParkingMenuMaster($request);
        if ($parkingMenu) {
            $parkingMenuTime = $parkingMenu->parkingMenuTime()->orderBy('day_type', 'asc')->orderBy('from_time', 'asc')->get();
            return view('owner::menus.management', compact('parkingMenu', 'parkingMenuTime'));
        }

        return view('owner::menus.create');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(MenuRequest $request)
    {
        $dataUpdate = $this->dataMenu($request->all());
        try {
            $this->parkingMenuRepository->store($dataUpdate);

            return redirect()->back()->with('message', __('message.menu_parking_lot.update_success'));
        } catch (QueryException $e) {
            Log::error($e->getMessage());

            return redirect()->back()->with('editErrors', __('message.menu.error'));
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(MenuRequest $request, $menuParkingId)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function createOrUpdateMenuMonth(MonthlyRequest $request)
    {
        $parkingMenuMaster = $this->getParkingMenuMaster($request);
        $parkingMenu = $this->parkingMenuRepository->getMenuByParkingCD($request->parking_cd);
        try {
            if (!$parkingMenuMaster && !$parkingMenu) {
                $menu = $this->createParkingMenu($request);

                return response()->json([
                    'menuCd' => $menu->menu_cd,
                    'message' =>  __('message.menu.month.create_success')
                ], Response::HTTP_OK);
            }

            $dataUpdate = $this->dataUpdateMenuMonth($request->all());
            $this->parkingMenuRepository->update($parkingMenu->menu_cd, $dataUpdate);

            return response()->json([
                'message' =>  __('message.menu.month.update_success')
            ], Response::HTTP_OK);
        } catch (QueryException $e) {
            Log::error($e->getMessage());

            return $this->handleErrorResponse();
        }
    }

    public function createOrUpdateMenuDay(DayRequest $request)
    {
        $parkingMenuMaster = $this->getParkingMenuMaster($request);
        $parkingMenu = $this->parkingMenuRepository->getMenuByParkingCD($request->parking_cd);
        try {
            if (!$parkingMenuMaster && !$parkingMenu) {
                $menu = $this->createParkingMenu($request);

                return response()->json([
                    'menuCd' => $menu->menu_cd,
                    'message' =>  __('message.menu.day.create_success')
                ], Response::HTTP_OK);
            }

            $dataUpdate = $this->dataUpdateMenuDay($request->all());
            $this->parkingMenuRepository->update($parkingMenu->menu_cd, $dataUpdate);

            return response()->json([
                'message' =>  __('message.menu.day.update_success')
            ], Response::HTTP_OK);
        } catch (QueryException $e) {
            Log::error($e->getMessage());

            return $this->handleErrorResponse();
        }
    }

    public function createOrUpdateMenuPeriod(PeriodRequest $request)
    {
        $parkingMenuMaster = $this->getParkingMenuMaster($request);
        $parkingMenu = $this->parkingMenuRepository->getMenuByParkingCD($request->parking_cd);
        try {
            if (!$parkingMenuMaster && !$parkingMenu) {
                $menu = $this->createParkingMenu($request);

                return response()->json([
                    'menuCd' => $menu->menu_cd,
                    'message' =>  __('message.menu.period.create_success')
                ], Response::HTTP_OK);
            }

            $dataUpdate = $this->dataMenuPeriod($request->all());
            $this->parkingMenuRepository->update($parkingMenu->menu_cd, $dataUpdate);

            return response()->json([
                'message' =>  __('message.menu.period.update_success')
            ], Response::HTTP_OK);
        } catch (QueryException $e) {
            Log::error($e->getMessage());

            return $this->handleErrorResponse();
        }
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
        try {
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
        } catch (QueryException $e) {
            return response()->json(
                [
                    'errors' => __('message.menu_parking_lot.update_false')
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function dataMenu($dataRequest)
    {
        return [
            'owner_cd' => Auth::guard('owner')->user()->owner_cd,
            'month_flg' => isset($dataRequest['month_flg']) ? ParkingMenu::MONTH_FLG_ENABLE : ParkingMenu::MONTH_FLG_DISABLE,
            'parking_cd' => $dataRequest['parking_cd'] ?? null,
            'month_price' => $dataRequest['month_price'] ?? 0,
            'minimum_use' => $dataRequest['minimum_use'] ?? null,
            'period_flg' => isset($dataRequest['period_flg']) ? ParkingMenu::PERIOD_FLG_ENABLE : ParkingMenu::PERIOD_FLG_DISABLE,
            'period_week' => isset($dataRequest['period_week']) ? ParkingMenu::PERIOD_WEEK_FLG_ENABLE : ParkingMenu::PERIOD_WEEK_FLG_DISABLE,
            'period_monday' => isset($dataRequest['period_week_data'][0]) ? ParkingMenu::PARKING_MENU_ON : ParkingMenu::PARKING_MENU_OFF,
            'period_tuesday' => isset($dataRequest['period_week_data'][1]) ? ParkingMenu::PARKING_MENU_ON : ParkingMenu::PARKING_MENU_OFF,
            'period_wednesday' => isset($dataRequest['period_week_data'][2]) ? ParkingMenu::PARKING_MENU_ON : ParkingMenu::PARKING_MENU_OFF,
            'period_thursday' => isset($dataRequest['period_week_data'][3]) ? ParkingMenu::PARKING_MENU_ON : ParkingMenu::PARKING_MENU_OFF,
            'period_friday' => isset($dataRequest['period_week_data'][4]) ? ParkingMenu::PARKING_MENU_ON : ParkingMenu::PARKING_MENU_OFF,
            'period_saturday' => isset($dataRequest['period_week_data'][5]) ? ParkingMenu::PARKING_MENU_ON : ParkingMenu::PARKING_MENU_OFF,
            'period_sunday' => isset($dataRequest['period_week_data'][6]) ? ParkingMenu::PARKING_MENU_ON : ParkingMenu::PARKING_MENU_OFF,
            'period_holiday' => isset($dataRequest['period_week_data'][7]) ? ParkingMenu::PARKING_MENU_ON : ParkingMenu::PERIOD_TIME_FLG_DISABLE,
            'period_timeflg' => isset($dataRequest['period_timeflg']) ? ParkingMenu::PERIOD_TIME_FLG_ENABLE : ParkingMenu::TIME_FLG_DISABLE,
            'period_fromtime' => $dataRequest['period_fromtime'] ?? null,
            'period_totime' => $dataRequest['period_totime'] ?? null,
            'period_dayflg' => isset($dataRequest['period_dayflg']) ? ParkingMenu::PERIOD_DAY_FLG_ENABLE : ParkingMenu::PERIOD_DAY_FLG_DISABLE,
            'period_fromday' => $dataRequest['period_fromday'] ?? null,
            'period_today' => $dataRequest['period_today'] ?? null,
            'period_price' => $dataRequest['period_price'] ?? null,
            'day_flg' => isset($dataRequest['day_flg']) ? ParkingMenu::DAY_FLG_ENABLE : ParkingMenu::DAY_FLG_DISABLE,
            'day_price' => $dataRequest['day_price'] ?? 0,
            'time_flg' => isset($dataRequest['time_flg']) ? ParkingMenu::TIME_FLG_ENABLE : ParkingMenu::TIME_FLG_DISABLE,
            'registered_person' => $dataRequest['registered_person'] ?? null,
            'updater' => $dataRequest['updater'] ?? null,
        ];
    }

    protected function dataUpdateMenuMonth($dataRequest)
    {
        return [
            'owner_cd' => Auth::guard('owner')->user()->owner_cd,
            'month_flg' => isset($dataRequest['month_flg']) ? ParkingMenu::MONTH_FLG_ENABLE : ParkingMenu::MONTH_FLG_DISABLE,
            'parking_cd' => $dataRequest['parking_cd'] ?? null,
            'month_price' => $dataRequest['month_price'] ?? 0,
            'minimum_use' => $dataRequest['minimum_use'] ?? 0,
            'registered_person' => $dataRequest['registered_person'] ?? null,
            'updater' => Auth::guard('owner')->user()->name_c,
        ];
    }

    protected function dataUpdateMenuDay($dataRequest)
    {
        return [
            'owner_cd' => Auth::guard('owner')->user()->owner_cd,
            'day_flg' => isset($dataRequest['day_flg']) ? ParkingMenu::DAY_FLG_ENABLE : ParkingMenu::DAY_FLG_DISABLE,
            'parking_cd' => $dataRequest['parking_cd'] ?? null,
            'day_price' => $dataRequest['day_price'] ?? 0,
            'registered_person' => $dataRequest['registered_person'] ?? null,
            'updater' => Auth::guard('owner')->user()->name_c,
        ];
    }

    protected function dataMenuPeriod($dataRequest)
    {
        return [
            'owner_cd' => Auth::guard('owner')->user()->owner_cd,
            'parking_cd' => $dataRequest['parking_cd'] ?? null,
            'period_flg' => isset($dataRequest['period_flg']) ? ParkingMenu::PERIOD_FLG_ENABLE : ParkingMenu::PERIOD_FLG_DISABLE,
            'period_week' => isset($dataRequest['period_week']) ? ParkingMenu::PERIOD_WEEK_FLG_ENABLE : ParkingMenu::PERIOD_WEEK_FLG_DISABLE,
            'period_monday' => isset($dataRequest['period_week_data'][0]) ? ParkingMenu::PARKING_MENU_ON : ParkingMenu::PARKING_MENU_OFF,
            'period_tuesday' => isset($dataRequest['period_week_data'][1]) ? ParkingMenu::PARKING_MENU_ON : ParkingMenu::PARKING_MENU_OFF,
            'period_wednesday' => isset($dataRequest['period_week_data'][2]) ? ParkingMenu::PARKING_MENU_ON : ParkingMenu::PARKING_MENU_OFF,
            'period_thursday' => isset($dataRequest['period_week_data'][3]) ? ParkingMenu::PARKING_MENU_ON : ParkingMenu::PARKING_MENU_OFF,
            'period_friday' => isset($dataRequest['period_week_data'][4]) ? ParkingMenu::PARKING_MENU_ON : ParkingMenu::PARKING_MENU_OFF,
            'period_saturday' => isset($dataRequest['period_week_data'][5]) ? ParkingMenu::PARKING_MENU_ON : ParkingMenu::PARKING_MENU_OFF,
            'period_sunday' => isset($dataRequest['period_week_data'][6]) ? ParkingMenu::PARKING_MENU_ON : ParkingMenu::PARKING_MENU_OFF,
            'period_holiday' => isset($dataRequest['period_week_data'][7]) ? ParkingMenu::PARKING_MENU_ON : ParkingMenu::PERIOD_TIME_FLG_DISABLE,
            'period_timeflg' => isset($dataRequest['period_timeflg']) ? ParkingMenu::PERIOD_TIME_FLG_ENABLE : ParkingMenu::TIME_FLG_DISABLE,
            'period_fromtime' => $dataRequest['period_fromtime'] ?? null,
            'period_totime' => $dataRequest['period_totime'] ?? null,
            'period_dayflg' => isset($dataRequest['period_dayflg']) ? ParkingMenu::PERIOD_DAY_FLG_ENABLE : ParkingMenu::PERIOD_DAY_FLG_DISABLE,
            'period_fromday' => $dataRequest['period_fromday'] ?? null,
            'period_today' => $dataRequest['period_today'] ?? null,
            'period_price' => isset($dataRequest['period_price']) ? $dataRequest['period_price'] : 0,
            'updater' => Auth::guard('owner')->user()->name_c,
        ];
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
            Log::error($e->getMessage());
            DB::rollBack();

            return $this->handleUnprocessableEntity(__('message.menu_parking_lot.menu_time_errors'));
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
            Log::error($e->getMessage());
            DB::rollBack();

            return $this->handleUnprocessableEntity(__('message.menu_parking_lot.menu_time_errors'));
        }
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
            try {
                $this->parkingMenuTimeRepository->destroy($dataDelete);
            } catch (QueryException $e) {
                return $this->handleInternalServerException(__('message.menu_parking_lot.delete_false'));
            }
        }
    }

    public function getParkingMenuMaster($request)
    {
        $ownerCd = Auth::guard('owner')->user()->owner_cd;
        $parkingMenu = $this->parkingMenuRepository->getMenuMaster($ownerCd);

        if ($request->menu_cd) {
            $parkingMenu['menu_cd'] = $request->menu_cd;
        }

        return $parkingMenu;
    }

    public function createParkingMenu($request)
    {
        $dataCreate = $this->dataMenu($request->all());
        $parkingMenu = $this->parkingMenuRepository->store($dataCreate);

        return $parkingMenu;
    }
}

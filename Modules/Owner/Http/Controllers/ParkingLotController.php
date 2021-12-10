<?php

namespace Modules\Owner\Http\Controllers;

use App\Models\ParkingLot;
use App\Models\ParkingMenu;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use App\Traits\ImageTraits;
use Modules\Owner\Http\Requests\Parking\EditRequest;
use Modules\Owner\Http\Requests\Parking\RegisterRequest;
use Modules\Owner\Http\Requests\Parking\UpdateMenuParkingRequest;
use Modules\Owner\Repositories\Parking\ParkingLotRepositoryInterface;
use Modules\Owner\Repositories\Prefecture\PrefectureRepositoryInterface;
use Modules\Owner\Repositories\ParkingMenu\ParkingMenuRepositoryInterface;
use Modules\Owner\Repositories\ParkingSpace\ParkingSpaceRepositoryInterface;
use Modules\Owner\Repositories\ParkingMenuTime\ParkingMenuTimeRepositoryInterface;

class ParkingLotController extends Controller
{
    use ImageTraits;

    protected $parkingLotRepository;
    protected $parkingMenuRepository;
    protected $parkingMenuTimeRepository;
    protected $parkingSpaceRepository;
    protected $prefectureRepository;

    public function __construct(
        ParkingLotRepositoryInterface $parkingLotRepository,
        ParkingMenuRepositoryInterface $parkingMenuRepository,
        ParkingMenuTimeRepositoryInterface $parkingMenuTimeRepository,
        ParkingSpaceRepositoryInterface $parkingSpaceRepository,
        PrefectureRepositoryInterface $prefectureRepository
    ) {
        $this->parkingLotRepository = $parkingLotRepository;
        $this->parkingMenuRepository = $parkingMenuRepository;
        $this->parkingMenuTimeRepository = $parkingMenuTimeRepository;
        $this->parkingSpaceRepository = $parkingSpaceRepository;
        $this->prefectureRepository = $prefectureRepository;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $ownerCd = Auth::guard('owner')->user()->owner_cd;
        $parkings = $this->parkingLotRepository->getAll($ownerCd);

        return view('owner::parking.list', compact('parkings'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('owner::parking.register');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */

    public function store(RegisterRequest $request)
    {
        $checkLuTime = $this->checkStartAndLuTime($request->all());

        if (!$checkLuTime) {
            return redirect()->back()->withInput($request->input())->with('errorLutime', __('message.parking_lot.lutime_between_start_time'));
        }

        $numberVideos = count($request->isUpdateVideo);
        $urlImages = $this->getPathImages($request->image, $request->isUpdateImage);
        $urlVideos = $this->getPathVideos($request->video, $request->isUpdateVideo);
        $nameThumbnails = $this->getNameThumbnails($urlVideos);
        $urlThumbnails = $this->setNameThumbnail($nameThumbnails, $numberVideos);
        $this->getPathThumbnails($urlThumbnails, $request->thumbnail);
        $dataStore = $this->dataParkingLot($request->all(), $urlImages, $urlVideos, $urlThumbnails, $numberVideos);
        try {
            if (!$dataStore['prefectures_cd']) {
                return redirect()->back()->withInput($request->input())->with('error', __('message.prefecture_not_found'));
            }
            DB::beginTransaction();
            $dataStore['registered_person'] = Auth::guard('owner')->user()->name_c;
            $parking = $this->parkingLotRepository->store($dataStore);
            $this->createParkingMenuMaster($parking);
            DB::commit();

            return redirect()->route('parkinglot.create_slot_parking', ['parkingCd' => $parking->parking_cd]);
        } catch (QueryException $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->removeFile($urlVideos);
            $this->removeFile($urlImages);
            $thumbnails = [];
            foreach ($urlThumbnails as $key => $value) {
                if ($value != config('constants.IMAGES.DEFAULT')) $thumbnails[$key] = $value;
            }
            $this->removeFile($thumbnails);

            return redirect()->back()->withInput($request->input())->with('error', __('message.error'));
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $ownerCd = Auth::guard('owner')->user()->owner_cd;

        if (!$this->parkingLotRepository->isCreateByOwner($ownerCd, $id)) {
            return redirect(route('parkinglot.index'))->with('error', __('message.response.unauthorized'));
        }
        $parking = $this->parkingLotRepository->find($id);
        $parkingMenu = $parking->parkingMenu;

        if ($parkingMenu) {
            $parkingMenuTime = $parkingMenu->parkingMenuTime;

            return view('owner::parking.menu', compact('parking', 'parkingMenuTime'));
        }

        return view('owner::parking.menu', compact('parking'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $ownerCd = Auth::guard('owner')->user()->owner_cd;

        if (!$this->parkingLotRepository->isCreateByOwner($ownerCd, $id)) {
            return redirect(route('parkinglot.index'))->with('error', __('message.response.unauthorized'));
        }
        $parkingLot = $this->parkingLotRepository->show($id);
        $prefectures_name = $this->prefectureRepository->get($parkingLot->prefectures_cd)->prefectures_name;

        return view('owner::parking.edit', compact('parkingLot', 'prefectures_name'));
    }

    /**
     * Update the specified resource in storage.
     * @param EditRequest $request
     * @param $parkingCd
     * @return void
     */
    public function update(EditRequest $request, $parkingCd)
    {
        $checkLuTime = $this->checkStartAndLuTime($request->all());

        if (!$checkLuTime) {
            return redirect()->back()->withInput($request->input())->with('errorLutime', __('message.parking_lot.lutime_between_start_time'));
        }

        DB::beginTransaction();

        try {
            $parkingLot = $this->parkingLotRepository->find($parkingCd);
            $thumbnailVideos = json_decode($parkingLot->thumbnail_video, true);
            $numberVideos = count($request->isUpdateVideo);
            $urlImages = $this->getPathImages($request->image, $request->isUpdateImage);
            $urlVideos = $this->getPathVideos($request->video, $request->isUpdateVideo);
            $nameThumbnails = $this->getNameThumbnails($urlVideos);
            $urlThumbnails = $this->setNameThumbnail($nameThumbnails, $numberVideos, $thumbnailVideos);
            $this->getPathThumbnails($urlThumbnails, $request->thumbnail);
            $dataUpdate = $this->dataParkingLot($request->all(), $urlImages, $urlVideos, $urlThumbnails, $numberVideos);
            if (!$dataUpdate['prefectures_cd']) {
                $this->removeFileIfUpdateFailed($urlVideos, $urlImages, $parkingLot, $nameThumbnails, $thumbnailVideos);

                return redirect()->back()->with('error', __('message.prefecture_not_found'));
            }
            $dataUpdate['updater'] = Auth::guard('owner')->user()->name_c;
            if ($parkingLot) {
                $this->parkingLotRepository->update($parkingCd, $dataUpdate);
                $this->removeFileIfUpdateFailed($urlVideos, $urlImages, $parkingLot, $nameThumbnails, $thumbnailVideos);
            }
            DB::commit();

            if ($parkingLot->mgn_flg == ParkingLot::MGN_FLG_DISABLE) {
                return redirect()->route('parkinglot.index')->with('editSuccess', __('message.parking.edit_success'));
            }

            return redirect()->route('parkinglot.create_slot_parking', ['parkingCd' => $parkingCd]);
        } catch (QueryException $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            return redirect()->back()->withInput($request->input())->with('error', __('message.error'));
        }
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

    public function dataParkingLot($dataRequest, $urlImage, $urlVideos, $nameThumbnails, $numberVideos)
    {
        $resource = [
            'owner_cd' => Auth::guard('owner')->user()->owner_cd,
            'parking_name' => $dataRequest['name'],
            'zip_cd' => $dataRequest['code'],
            'municipality_name' => $dataRequest['municipality'],
            'townname_address' => $dataRequest['town_area'],
            'building_name' => $dataRequest['building_name'],
            'latitude' => $dataRequest['latitude'],
            'longitude' => $dataRequest['longitude'],
            'olc' => $dataRequest['olc'] ?? '',
            'tel_no' => $dataRequest['tel_no'],
            'fax_no' => $dataRequest['fax_no'],
            'sales_division' => isset($dataRequest['sales_division']) ? ParkingLot::SALES_DIVISION_ENABLE : ParkingLot::SALES_DIVISION_DISABLE,
            'sales_start_time' => $dataRequest['sales_start_time'] ?? '',
            'sales_end_time' => $dataRequest['sales_end_time'] ?? '',
            'lu_division' => isset($dataRequest['lu_division']) ? ParkingLot::LU_DIVISION_ENABLE : ParkingLot::LU_DIVISION_DISABLE,
            'lu_start_time' => $dataRequest['lu_start_time'] ?? '',
            'lu_end_time' => $dataRequest['lu_end_time'] ?? '',
            'net_payoff' => isset($dataRequest['net_payoff']) ? ParkingLot::NET_PAYOFF_ENABLE : ParkingLot::NET_PAYOFF_DISABLE,
            'local_payoff' => isset($dataRequest['local_payoff']) ? ParkingLot::LOCAL_PAYOFF_ENABLE : ParkingLot::LOCAL_PAYOFF_DISABLE,
            'warn' => $dataRequest['warn'] ?? null,
            'updater' => Auth::guard('owner')->user()->name_c,
        ];

        if ($resource['sales_start_time'] == "00:00" && $resource['sales_end_time'] == "24:00") {
            $resource['sales_division'] = ParkingLot::SALES_DIVISION_ENABLE;
        }

        if ($resource['lu_start_time'] == "00:00" && $resource['lu_end_time'] == "24:00") {
            $resource['lu_division'] = ParkingLot::LU_DIVISION_ENABLE;
        }

        $resource['prefectures_cd'] = $this->prefectureRepository->getByName($dataRequest['prefectures'])->prefectures_cd ?? '';

        if ($urlVideos) {
            foreach ($urlVideos as $key => $urlVideo) {
                $resource[$key . '_url'] = $urlVideo;
            }
        }

        foreach ($urlImage as $key => $value) {
            $resource[$key . '_url'] = $value;
        }

        $thumbnails = [];
        foreach ($nameThumbnails as $key => $name) {
            $thumbnails["thumbnail" . $key . "_url"] = $name ?? config('constants.IMAGES.DEFAULT');
        }
        $resource['thumbnail_video'] = json_encode($thumbnails);

        return $resource;
    }

    public function updateMenuParking(UpdateMenuParkingRequest $request, $menuParkingId)
    {
        try {
            $dataMenu = [
                'month_flg' => isset($request['month_flg']) ? $request['month_flg'] : ParkingMenu::MONTH_FLG_DISABLE,
                'period_flg' => isset($request['period_flg']) ? $request['period_flg'] : ParkingMenu::PERIOD_FLG_DISABLE,
                'time_flg' => isset($request['time_flg']) ? $request['time_flg'] : ParkingMenu::TIME_FLG_DISABLE
            ];

            if (isset($request['month_flg'])) {
                $dataMenu['month_price'] = $request['month_price'];
                $dataMenu['minimum_use'] = $request['minimum_use'];
            }
            $this->parkingMenuRepository->update($menuParkingId, $dataMenu);
        } catch (\Exception $e) {
            return redirect()->back()->with('message', trans('message.menu_parking_lot.update_false'));
        }

        return redirect()->back()->with('message', trans('message.menu_parking_lot.update_success'));
    }

    public function getByCode(Request $request)
    {
        $code = $request->get('code', null);

        try {
            $parkingLot = $this->parkingLotRepository->getByCode($code);
            $prefecture = $parkingLot->prefecture;

            return response()->json(
                [
                    'parkingLot' => $parkingLot,
                    'prefecture' => $prefecture
                ],
                Response::HTTP_OK
            );
        } catch (QueryException $e) {
            return response()->json(
                [
                    'message' => $e->getMessage()
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function createSlotParking($parkingCd)
    {
        $slotParkings = $this->parkingSpaceRepository->getAllSlotParking($parkingCd);

        return view('owner::slotsParking.create', compact('slotParkings', 'parkingCd'));
    }

    public function removeFileIfUpdateFailed($urlVideos, $urlImages, $parkingLot, $nameThumbnails, $thumbnailVideos)
    {
        $this->removeFileUpdate($urlVideos, $parkingLot);
        $this->removeFileUpdate($urlImages, $parkingLot);
        $this->removeFileThumbnail($nameThumbnails, $thumbnailVideos);
    }

    public function createParkingMenuMaster($parking)
    {
        $ownerCd = Auth::guard('owner')->user()->owner_cd;
        $parkingMenuMaster = $this->parkingMenuRepository->getMenuMaster($ownerCd);

        if (!$parkingMenuMaster) {
            return false;
        }

        $cloneMenu = $this->parkingMenuRepository->replicateMenuMaster($parkingMenuMaster);
        $parkingMenu = $this->parkingMenuRepository->update($cloneMenu->menu_cd, [
            'parking_cd' => $parking->parking_cd
        ]);
        $parkingMenuTime = $this->parkingMenuTimeRepository->getMenuTimeByMenuCdAndCheck($parking, $parkingMenuMaster->menu_cd);

        if ($parkingMenu) {
            foreach ($parkingMenuTime as $menuTime) {
                $cloneMenuTime = $this->parkingMenuTimeRepository->replicateMenuTime($menuTime);
                $parkingMenuTime = $this->parkingMenuTimeRepository->update($cloneMenuTime->id, [
                    'menu_cd' => $cloneMenu->menu_cd
                ]);
            }
        }

        return $parkingMenu;
    }

    public function checkStartAndLuTime($dataRequest)
    {
        if (isset($dataRequest['sales_division']) || ($dataRequest['sales_start_time'] == '00:00' && $dataRequest['sales_end_time'] == '24:00')) {
            return true;
        }

        if (!isset($dataRequest['sales_division']) && isset($dataRequest['lu_division'])) {
            return false;
        }

        if (
            !(strtotime($dataRequest['lu_start_time']) >= strtotime($dataRequest['sales_start_time']) &&
                strtotime($dataRequest['lu_end_time']) <= strtotime($dataRequest['sales_end_time']))
        ) {

            return false;
        }

        return true;
    }
}

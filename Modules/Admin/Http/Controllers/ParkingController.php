<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\ParkingLot;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use App\Traits\ImageTraits;
use Modules\Admin\Http\Requests\Parking\EditParkingRequest;
use Modules\Admin\Http\Requests\Parking\CreateParkingRequest;
use Modules\Admin\Http\Requests\Parking\SearchParkingRequest;
use Modules\Admin\Repositories\Owner\AdminOwnerRepositoryInterface;
use Modules\Admin\Repositories\Parking\AdminParkingLotRepositoryInterface;
use Modules\Admin\Repositories\Prefecture\AdminPrefectureRepositoryInterface;
use Modules\Admin\Repositories\ParkingMenu\AdminParkingMenuRepositoryInterface;
use Modules\Admin\Repositories\ParkingSpace\AdminParkingSpaceRepositoryInterface;
use Modules\Admin\Repositories\ParkingMenuTime\AdminParkingMenuTimeRepositoryInterface;

class ParkingController extends Controller
{
    use ImageTraits;

    protected $adminParkingLotRepository;
    protected $adminPrefectureRepository;
    protected $adminOwnerRepository;
    protected $adminParkingMenuRepository;
    protected $adminParkingMenuTimeRepository;
    protected $adminParkingSpaceRepository;

    public function __construct(
        AdminParkingLotRepositoryInterface $adminParkingLotRepository,
        AdminPrefectureRepositoryInterface $adminPrefectureRepository,
        AdminOwnerRepositoryInterface $adminOwnerRepository,
        AdminParkingMenuRepositoryInterface $adminParkingMenuRepository,
        AdminParkingMenuTimeRepositoryInterface $adminParkingMenuTimeRepository,
        AdminParkingSpaceRepositoryInterface $adminParkingSpaceRepository
    ) {
        $this->adminParkingLotRepository = $adminParkingLotRepository;
        $this->adminPrefectureRepository = $adminPrefectureRepository;
        $this->adminOwnerRepository = $adminOwnerRepository;
        $this->adminParkingMenuRepository = $adminParkingMenuRepository;
        $this->adminParkingMenuTimeRepository = $adminParkingMenuTimeRepository;
        $this->adminParkingSpaceRepository = $adminParkingSpaceRepository;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $prefectures = $this->adminPrefectureRepository->all();
        $allOwner = $this->adminOwnerRepository->all();
        $parkings = $this->adminParkingLotRepository->getLatest()->paginate(config('constants.SLOT_PARKING_PAGE_ITEM'));
        $allParking = $this->adminParkingLotRepository->all();

        return view('admin::parking.index', compact('parkings', 'prefectures', 'allOwner', 'allParking'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $allOwner = $this->adminOwnerRepository->all();
        return view('admin::parking.create', compact('allOwner'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(CreateParkingRequest $request)
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
            $dataStore['registered_person'] = Auth::guard('admin')->user()->name_mei;
            $parking = $this->adminParkingLotRepository->store($dataStore);
            $this->createParkingMenuMaster($parking);
            DB::commit();

            if ($dataStore['mgn_flg'] == ParkingLot::MGN_FLG_DISABLE) {
                return redirect()->route('parkings.index')->with('createSuccess', __('message.parking.create_success'));
            }

            return redirect()->route('parking.create_space_parking', ['parkingCd' => $parking->parking_cd]);
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
        $parking = $this->adminParkingLotRepository->find($id);
        $parkingMenu = $parking->parkingMenu;

        if ($parkingMenu) {
            $parkingMenuTime = $parkingMenu->parkingMenuTime;

            return view('admin::parking.menu', compact('parking', 'parkingMenuTime'));
        }

        return view('admin::parking.menu', compact('parking'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $parking = $this->adminParkingLotRepository->show($id);
        $prefecturesName = $this->adminPrefectureRepository->get($parking->prefectures_cd)->prefectures_name;
        $allOwner = $this->adminOwnerRepository->all();

        return view('admin::parking.edit', compact('parking', 'prefecturesName', 'allOwner'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(EditParkingRequest $request, $parkingCd)
    {
        $checkLuTime = $this->checkStartAndLuTime($request->all());

        if (!$checkLuTime) {
            return redirect()->back()->withInput($request->input())->with('errorLutime', __('message.parking_lot.lutime_between_start_time'));
        }

        DB::beginTransaction();

        try {
            $parkingLot = $this->adminParkingLotRepository->find($parkingCd);
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

                return redirect()->back()->withInput($request->input())->with('error', __('message.prefecture_not_found'));
            }
            if ($parkingLot) {
                $this->adminParkingLotRepository->update($parkingCd, $dataUpdate);
                $this->removeFileIfUpdateFailed($urlVideos, $urlImages, $parkingLot, $nameThumbnails, $thumbnailVideos);
            }
            DB::commit();

            if ($request->mgn_flg == ParkingLot::MGN_FLG_DISABLE) {
                return redirect()->route('parkings.index')->with('editSuccess', __('message.parking.edit_success'));
            }

            return redirect()->route('parking.create_space_parking', ['parkingCd' => $parkingCd]);
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
            'owner_cd' => $dataRequest['owner_cd'],
            'mgn_flg' => $dataRequest['mgn_flg'],
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
            're_enter' => isset($dataRequest['re_enter']) ? ParkingLot::REENTER_ENABLE : ParkingLot::REENTER_DISABLE,
            'net_payoff' => isset($dataRequest['net_payoff']) ? ParkingLot::NET_PAYOFF_ENABLE : ParkingLot::NET_PAYOFF_DISABLE,
            'local_payoff' => isset($dataRequest['local_payoff']) ? ParkingLot::LOCAL_PAYOFF_ENABLE : ParkingLot::LOCAL_PAYOFF_DISABLE,
            'warn' => $dataRequest['warn'] ?? null,
            'updater' => Auth::guard('admin')->user()->name_mei,
        ];

        if ($resource['sales_start_time'] == "00:00" && $resource['sales_end_time']) {
            $resource['sales_division'] = ParkingLot::SALES_DIVISION_ENABLE;
        }

        if ($resource['lu_start_time'] == "00:00" && $resource['lu_end_time']) {
            $resource['lu_division'] = ParkingLot::LU_DIVISION_ENABLE;
        }

        $resource['prefectures_cd'] = $this->adminPrefectureRepository->getByName($dataRequest['prefectures'])->prefectures_cd ?? '';

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

    public function removeFileIfUpdateFailed($urlVideos, $urlImages, $parking, $nameThumbnails, $thumbnailVideos)
    {
        $this->removeFileUpdate($urlVideos, $parking);
        $this->removeFileUpdate($urlImages, $parking);
        $this->removeFileThumbnail($nameThumbnails, $thumbnailVideos);
    }

    public function createParkingMenuMaster($parking)
    {
        $parkingMenuMaster = $this->adminParkingMenuRepository->getMenuMaster($parking->owner_cd);

        if (!$parkingMenuMaster) {
            return false;
        }

        $cloneMenu = $this->adminParkingMenuRepository->replicateMenuMaster($parkingMenuMaster);
        $parkingMenu = $this->adminParkingMenuRepository->update($cloneMenu->menu_cd, [
            'parking_cd' => $parking->parking_cd
        ]);
        $parkingMenuTime = $this->adminParkingMenuTimeRepository->getMenuTimeByMenuCdAndCheck($parking, $parkingMenuMaster->menu_cd);

        if ($parkingMenu) {
            foreach ($parkingMenuTime as $menuTime) {
                $cloneMenuTime = $this->adminParkingMenuTimeRepository->replicateMenuTime($menuTime);
                $parkingMenuTime = $this->adminParkingMenuTimeRepository->update($cloneMenuTime->id, [
                    'menu_cd' => $cloneMenu->menu_cd
                ]);
            }
        }

        return $parkingMenu;
    }

    public function searchParking(SearchParkingRequest $request)
    {
        $dataSearch = [
            "prefectures_cd" => $request->prefectures_cd,
            "municipality_name" => $request->municipality_name,
            "parking_cd" => $request->parking_cd,
            "owner_cd" => $request->owner_cd,
            "created_at_from" => $request->created_at_from,
            "created_at_to" => $request->created_at_to,
            "updated_at_from" => $request->updated_at_from,
            "updated_at_to" => $request->updated_at_to
        ];
        $parkings = $this->adminParkingLotRepository->search($dataSearch)->paginate(config('constants.SLOT_PARKING_PAGE_ITEM'));
        $prefectures = $this->adminPrefectureRepository->all();
        $allOwner = $this->adminOwnerRepository->all();
        $allParking = $this->adminParkingLotRepository->all();

        return view('admin::parking.index', compact('parkings', 'prefectures', 'allOwner', 'allParking'));
    }

    public function createSpaceParking($parkingCd)
    {
        $spaceParkings = $this->adminParkingSpaceRepository->getAllSlotParking($parkingCd);
        $parking = $this->adminParkingLotRepository->get($parkingCd);
        $owner = $this->adminOwnerRepository->get($parking->owner_cd);
        return view('admin::parking_space.create', compact('spaceParkings', 'parking', 'owner'));
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

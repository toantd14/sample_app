<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\Owner;
use App\Models\ParkingMenu;
use App\Traits\ImageTraits;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;
use Modules\Owner\Http\Traits\ResponseTraits;
use Modules\Admin\Http\Requests\Owner\OwnerRequest;
use Modules\Admin\Http\Requests\Owner\CreateOwnerRequest;
use Modules\Owner\Repositories\Owner\OwnerRepositoryInterface;
use Modules\Admin\Repositories\MstUser\AdminUserRepositoryInterface;
use Modules\Owner\Repositories\OwnerBank\OwnerBankRepositoryInterface;
use Modules\Owner\Repositories\OwnerPass\OwnerPassRepositoryInterface;
use Modules\Owner\Repositories\Prefecture\PrefectureRepositoryInterface;
use Modules\Admin\Repositories\ParkingMenu\AdminParkingMenuRepositoryInterface;

class OwnerController extends Controller
{
    use ImageTraits;
    use ResponseTraits;

    protected $ownerRepository;
    protected $ownerPassRepository;
    protected $prefectureRepository;
    protected $ownerBankRepository;
    protected $adminParkingMenuRepository;
    protected $adminUserRepository;

    public function __construct(
        OwnerRepositoryInterface $ownerRepository,
        PrefectureRepositoryInterface $prefectureRepository,
        OwnerBankRepositoryInterface $ownerBankRepository,
        OwnerPassRepositoryInterface $ownerPassRepository,
        AdminParkingMenuRepositoryInterface $adminParkingMenuRepository,
        AdminUserRepositoryInterface $adminUserRepository
    ) {
        $this->ownerRepository = $ownerRepository;
        $this->prefectureRepository = $prefectureRepository;
        $this->ownerPassRepository = $ownerPassRepository;
        $this->ownerBankRepository = $ownerBankRepository;
        $this->adminParkingMenuRepository = $adminParkingMenuRepository;
        $this->adminUserRepository = $adminUserRepository;
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $owners = $this->ownerRepository->searchOwner($request->all());
        $prefectures = $this->prefectureRepository->all();
        $pageSize = config('constants.LIMIT_TABLE_ADMIN');
        session()->flashInput($request->all());

        return view('admin::owners.list', compact('owners', 'prefectures', 'pageSize'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('admin::owners.create');
    }

    /**
     * Show the form for editing the specified resource.
     * @param $ownerCD
     * @return Response
     */
    public function edit($ownerCD)
    {
        $owner = $this->ownerRepository->getByOwnerCd($ownerCD);
        if ($owner) {
            $prefecture = $this->prefectureRepository->get($owner->prefectures_cd);

            return view('admin::owners.edit', compact('owner', 'prefecture', 'ownerCD'));
        }

        return redirect()->route('owners.index');
    }

    /**
     * @param OwnerRequest $request
     * @param $ownerId
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(OwnerRequest $request, $ownerId)
    {
        $dataUpdateOwner = $this->dataUpdateOwner($request->all());
        $dataUpdateOwner['stamp'] = $request->hasFile('stamp') ? $this->getBlobImage($request->stamp) : null;

        if (!$dataUpdateOwner['prefectures_cd']) {
            return response()->json([
                'message' => trans('message.prefecture_not_found')
            ], Response::HTTP_NOT_FOUND);
        }
        try {
            $this->ownerRepository->update($ownerId, $dataUpdateOwner);

            return response()->json([
                'message' => __('message.admin.update_success')
            ], Response::HTTP_OK);
        } catch (QueryException $e) {
            Log::error($e->getMessage());

            return response()->json([
                'message' => __('message.admin.error'),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function checkCertificationAndDelFfg($memberRole, $email)
    {
        if ($memberRole == config('owner.role_user')) {
            return $this->adminUserRepository->checkCertificationAndDelFfg($email);
        }

        return $this->ownerRepository->checkCertificationAndDelFfg($email);
    }

    /**
     * @param CreateOwnerRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateOwnerRequest $request)
    {
        $memberRole = $request->member ?? config('owner.role_owner');
        $checkMember = $this->checkCertificationAndDelFfg($memberRole, $request->mail_add);

        if (!$checkMember) {
            return response()->json([
                'errors' => [
                    'mail_add' => __('message.register.email_address_already_exists')
                ]
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $owner_cd = date(config('constants.YEAR')) . date(config('constants.HOUR')) . date(config('constants.MIN')) . rand(1000, 9999);
        $dataStorageOwner = $this->dataUpdateOwner($request->all());
        $dataStorageOwner['owner_cd'] = $owner_cd;
        $dataStorageOwner['stamp'] = $request->hasFile('stamp') ? $this->getBlobImage($request->file('stamp')) : null;

        if (!$dataStorageOwner['prefectures_cd']) {
            return response()->json([
                'message' => trans('message.prefecture_not_found')
            ], Response::HTTP_NOT_FOUND);
        }
        $dataStorageOwner['certification_result'] = Owner::CERTIFICATION_ACTIVE;

        DB::beginTransaction();
        try {
            $newOwner = $this->ownerRepository->store($dataStorageOwner);

            $this->adminParkingMenuRepository->store(
                [
                    'owner_cd' => $newOwner->owner_cd,
                    'month_flg' => ParkingMenu::MONTH_FLG_DISABLE,
                    'day-flg' => ParkingMenu::DAY_FLG_DISABLE,
                    'period_flg' => ParkingMenu::PERIOD_FLG_DISABLE,
                    'time_flg' => ParkingMenu::TIME_FLG_DISABLE
                ]
            );

            DB::commit();

            return response()->json([
                'message' => __('message.register.success'),
                'newOwner' => $newOwner->toArray()
            ], Response::HTTP_OK);
        } catch (QueryException $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            return response()->json([
                'message' => __('message.admin.error'),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    protected function dataUpdateOwner($requestData)
    {
        return  [
            "mgn_flg" => $requestData['mgn_flg'],
            "kubun" => $requestData['kubun'],
            "name_c" => $requestData['name_c'],
            "person_man" => $requestData['person_man'],
            "department" => $requestData['department'],
            "hp_url" => $requestData['hp_url'],
            "mail_add" => $requestData['mail_add'],
            "zip_cd" => $requestData['zip_cd'],
            "prefectures" => $requestData['prefectures'],
            "municipality_name" => $requestData['municipality_name'],
            "townname_address" => $requestData['townname_address'],
            "building_name" => $requestData['building_name'],
            "prefectures_cd" => $this->prefectureRepository->getByName($requestData['prefectures'])->prefectures_cd ?? '',
            "tel_no" => $requestData['tel_no'],
            "fax_no" => $requestData['fax_no'],
            "registered_person" => $requestData['registered_person'] ?? null,
            'updater' => Auth::guard('admin')->user()->name_mei,
            'stamp' => $requestData['stamp'] ?? null
        ];
    }

    protected function dataUpdateOwnerBank($request)
    {
        return  [
            'bank_cd' => $request['bank_cd'],
            'bank_name' => $request['bank_name'],
            'branch_cd' => $request['branch_cd'],
            'branch_name' => $request['branch_name'],
            'account_type' => $request['account_type'],
            'account_name' => $request['account_name'],
            'account_kana' => $request['account_kana'],
            "registered_person" => $requestData['registered_person'] ?? null,
            'updater' => Auth::guard('admin')->user()->name_mei,
        ];
    }

    protected function dataUpdateOwnerPass($requestData)
    {
        return  [
            'pass' => Hash::make($requestData['password']),
            'updater' => Auth::guard('admin')->user()->name_mei,
            "registered_person" => $requestData['registered_person'] ?? null,
        ];
    }

    public function getFlgOwner($ownerCD)
    {
        try {
            $owner = $this->ownerRepository->getByOwnerCd($ownerCD);

            if (!$owner) {
                return $this->handleNotFoundException(__('message.admin.error'));
            }

            return response()->json([
                'mgn_flg' => $owner->mgn_flg
            ], Response::HTTP_OK);
        } catch (QueryException $e) {

            return $this->handleInternalServerException(__('message.admin.error'));
        }
    }
}

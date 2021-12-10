<?php

namespace Modules\Owner\Http\Controllers;

use App\Models\Owner;
use App\Models\MstUser;
use App\Models\ParkingMenu;
use App\Traits\ImageTraits;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Session;
use Modules\Owner\Http\Traits\ResponseTraits;
use Modules\Owner\Http\Requests\Auth\LoginRequest;
use Modules\Owner\Http\Requests\Auth\RegisterRequest;
use Modules\Owner\Http\Requests\Auth\SetPasswordRequest;
use Modules\Owner\Repositories\Auth\AuthRepositoryInterface;
use Modules\Owner\Repositories\Owner\OwnerRepositoryInterface;
use Modules\Owner\Repositories\MstUser\UserRepositoryInterface;
use Modules\Owner\Repositories\Prefecture\PrefectureRepository;
use Modules\Owner\Repositories\OwnerPass\OwnerPassRepositoryInterface;
use Modules\Owner\Repositories\ParkingMenu\ParkingMenuRepositoryInterface;

class AuthController extends Controller
{
    use ResponseTraits;
    use ImageTraits;

    protected $ownerPassRepository;
    protected $authRepository;
    protected $ownerRepository;
    protected $prefectureRepository;
    protected $userRepository;
    protected $parkingMenuRepository;

    public function __construct(
        OwnerPassRepositoryInterface $ownerPassRepository,
        AuthRepositoryInterface $authRepository,
        OwnerRepositoryInterface $ownerRepository,
        PrefectureRepository $prefectureRepository,
        UserRepositoryInterface $userRepository,
        ParkingMenuRepositoryInterface $parkingMenuRepository
    ) {
        $this->ownerPassRepository = $ownerPassRepository;
        $this->authRepository = $authRepository;
        $this->ownerRepository = $ownerRepository;
        $this->prefectureRepository = $prefectureRepository;
        $this->userRepository = $userRepository;
        $this->parkingMenuRepository = $parkingMenuRepository;
    }


    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('owner::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('owner::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('owner::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('owner::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
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

    public function showLogin()
    {
        return view('owner::auth.login');
    }

    public function doLogin(LoginRequest $request)
    {
        $member = $request->member ?? config('owner.role_owner');

        if ($member == config('owner.role_user')) {
            return __('message.not_ready'); //hard-code do phần chức năng của user chưa làm.
        }

        $owner = $this->ownerPassRepository->getOwner($request->all());

        if (isset($owner)) {
            Auth::guard('owner')->login($owner);

            return redirect()->route('top.index');
        }

        return back()->withErrors(__('validation.login.error'))->withInput($request->all());
    }

    public function getRegister()
    {
        return view('owner::member.register');
    }

    public function postRegister(RegisterRequest $request)
    {
        $prefectures = $this->prefectureRepository->getByName($request['prefectures'])->prefectures_cd ?? '';
        if (!$prefectures) {
            return response()->json([
                'prefectures' =>  __('message.prefecture_not_found')
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $memberRole = $request->member ?? config('owner.role_owner');
        $checkMember = $this->checkCertificationAndDelFfg($memberRole, $request->mail_add);

        if (!$checkMember) {
            return response()->json([
                'errors' => [
                    'mail_add' => __('message.register.email_address_already_exists')
                ]
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        DB::beginTransaction();
        try {
            $dataRegisterMember = $this->dataRegisterUser($request);

            if ($memberRole == config('owner.role_user')) {
                $dataRegisterMember['howto_use'] = MstUser::ID_PASSWORD;
            }

            $member = $this->registeMember($dataRegisterMember);

            if ($memberRole != config('owner.role_user')) {
                $this->parkingMenuRepository->store(
                    [
                        'owner_cd' => $member['member_cd'],
                        'month_flg' => ParkingMenu::MONTH_FLG_DISABLE,
                        'day_flg' => ParkingMenu::DAY_FLG_DISABLE,
                        'period_flg' => ParkingMenu::PERIOD_FLG_DISABLE,
                        'time_flg' => ParkingMenu::TIME_FLG_DISABLE
                    ]
                );
            }

            DB::commit();

            if ($member['url_certification_or_exception']) {
                return response()->json([
                    'urlCertification' => $member['url_certification_or_exception'],
                    'successMessage' =>  __('message.register.success')
                ], Response::HTTP_OK);
            } else {
                return $this->handleErrorResponse();
            }
        } catch (QueryException $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            return redirect()->back()->with('editErrors', __('message.owner.error'));
        }
    }

    public function registeMember($dataRegisterMember)
    {
        try {
            $member = $this->authRepository->store($dataRegisterMember);

            return $member;
        } catch (QueryException $e) {

            return $e;
        }
    }

    public function dataRegisterOwner($request)
    {
        $ownerCd = date(config('constants.YEAR')) . date(config('constants.HOUR')) . date(config('constants.MIN')) . rand(1000, 9999);

        return [
            'owner_cd' => $ownerCd,
            "kubun" => $request['kubun'],
            "name_c" => $request['name_c'],
            "person_man" => $request['person_man'],
            "department" => $request['department']  ?? null,
            "hp_url" => $request['hp_url'],
            "mail_add" => $request['mail_add'],
            "zip_cd" => $request['zip_cd'],
            "prefectures_cd" => $this->prefectureRepository->getByName($request['prefectures'])->prefectures_cd ?? '',
            "municipality_name" => $request['municipality_name'],
            "townname_address" => $request['townname_address'],
            "building_name" => $request['building_name'] ?? null,
            "tel_no" => $request['tel_no'],
            "fax_no" => $request['fax_no'] ?? null,
            "confirm" => $request['confirm'],
            'certification_cd' => Str::random(4),
        ];
    }

    public function getSetPassword()
    {
        return view('owner::auth.set_password');
    }

    public function doSetPassword(SetPasswordRequest $request)
    {
        $memberCd = $request->member_cd;
        $certificationCd = $request->certification_cd;

        if ($request->member == config('owner.role_user')) {
            try {
                $user = $this->userRepository->getByUserCdAndCertificationCd($memberCd, $certificationCd);

                if (isset($user)) {
                    $this->userRepository->update($user->user_cd, [
                        'pass_word' => $request->password,
                        'certification_result' => MstUser::CERTIFICATION_ENABLE
                    ]);

                    return session()->flash('success', __('validation.set_password.success'));
                }
            } catch (QueryException $e) {
                Log::error($e->getMessage());

                return response()->json(
                    [
                        'error' => __('message.error')
                    ]
                );
            }
        } else {
            $ownerCertificationAvailable = $this->ownerRepository->getByOwnerCdAndCertificationCd($memberCd, $certificationCd);

            if (isset($ownerCertificationAvailable)) {
                $dataOwnerPass = [
                    'member_cd' => $ownerCertificationAvailable->owner_cd,
                    'pass' => $request->input('password'),
                    'registered_person' => $ownerCertificationAvailable->registered_person,
                    'updater' => $ownerCertificationAvailable->updater
                ];

                DB::beginTransaction();
                try {
                    $this->ownerRepository->updateCertificationResult($memberCd, $certificationCd, $certificationResult = Owner::CERTIFICATION_ACTIVE);
                    $this->ownerPassRepository->store($dataOwnerPass);
                    DB::commit();

                    return session()->flash('success', __('validation.set_password.success'));
                } catch (QueryException $e) {
                    DB::rollBack();
                    Log::error($e->getMessage());

                    return response()->json(
                        [
                            'error' => __('message.error')
                        ]
                    );
                }
            }
        }

        return response()->json(
            [
                'error' => __('validation.set_password.certification_error')
            ]
        );
    }

    public function dataRegisterUser($request)
    {
        $userCd = date(config('constants.YEAR')) . date(config('constants.HOUR')) . date(config('constants.MIN')) . rand(1000, 9999);

        return [
            'user_cd' => $userCd,
            "user_kbn" => $request['kubun'],
            "name_sei" => $request['name_c'][0],
            "name_mei" => $request['name_c'][1],
            "corporate_name" => $request['name_c'][2],
            "person_man" => $request['person_man'],
            "department" => $request['department'],
            "mail_add" => $request['mail_add'],
            "zip_cd" => $request['zip_cd'],
            "prefectures_cd" => $this->prefectureRepository->getByName($request['prefectures'])->prefectures_cd ?? '',
            "municipality_name" => $request['municipality_name'],
            "townname_address" => $request['townname_address'],
            "building_name" => $request['building_name'],
            "tel_no" => $request['tel_no'],
            'certification_cd' => Str::random(4),
        ];
    }

    public function checkCertificationAndDelFfg($memberRole, $email)
    {
        if ($memberRole == config('owner.role_user')) {
            return $this->userRepository->checkCertificationAndDelFfg($email);
        }

        return $this->ownerRepository->checkCertificationAndDelFfg($email);
    }

    public function logout()
    {
        Auth::guard('owner')->logout();
        request()->session()->flush();

        return redirect()->route('get.owner.login');
    }
}

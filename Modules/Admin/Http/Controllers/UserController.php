<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Admin\Http\Traits\ResponseTraits;
use Modules\Admin\Http\Traits\ResponseUnauthorizedTraits;
use Illuminate\Support\Facades\Log;
use Modules\Admin\Http\Requests\Users\UpdateRequest;
use Modules\Owner\Repositories\MstUser\UserRepositoryInterface;
use Modules\Owner\Repositories\Prefecture\PrefectureRepositoryInterface;

class UserController extends Controller
{
    use ResponseTraits;
    use ResponseUnauthorizedTraits;

    protected $prefectureRepository;
    protected $userRepository;

    public function __construct(
        PrefectureRepositoryInterface $prefectureRepository,
        UserRepositoryInterface $userRepository
    )
    {
        $this->prefectureRepository = $prefectureRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $users = $this->userRepository->searchUser($request->all());
        $prefectures = $this->prefectureRepository->all();
        session()->flashInput($request->all());

        return view('admin::users.list', compact('prefectures', 'users'));
    }

    public function edit(Request $request, $id)
    {
        try {
            $user = $this->userRepository->get($id);
            $prefecture = $this->prefectureRepository->get($user->prefectures_cd);

            return view('admin::users.edit', compact('user', 'prefecture'));
        } catch (QueryException $e) {
            Log::error($e->getMessage());

            return $this->handleErrorResponse();
        }
    }

    public function update(UpdateRequest $request, $id)
    {
        $user = $this->userRepository->get($id);

        if (!$user) {
            return $this->handleUnauthorizedResponse();
        }

        try {
            if ($user->user_cd != $id) {
                return $this->handleUnauthorizedResponse();
            }

            $dataUpdate = $this->dataUser($request->all());
            $this->userRepository->update($user->user_cd, $dataUpdate);

            return response()->json([
                'successMessage' =>  __('message.register.success')
            ], Response::HTTP_OK);
        } catch (QueryException $e) {
            Log::error($e->getMessage());

            return $this->handleErrorResponse();
        }
    }

    public function dataUser($request)
    {
        return [
            "user_kbn" => $request['kubun'],
            "name_sei" => $request['name_c'][0],
            "name_mei" => $request['name_c'][1],
            "corporate_name" => $request['corporate_name'],
            "department" => $request['department'],
            "mail_add" => $request['mail_add'],
            "zip_cd" => $request['zip_cd'],
            "prefectures_cd" => $this->prefectureRepository->getByName($request['prefectures'])->prefectures_cd ?? '',
            "municipality_name" => $request['municipality_name'],
            "townname_address" => $request['townname_address'],
            "building_name" => $request['building_name'],
            "tel_no" => $request['tel_no'],
        ];
    }
}

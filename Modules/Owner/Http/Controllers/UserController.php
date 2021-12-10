<?php

namespace Modules\Owner\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Modules\Owner\Http\Traits\ResponseTraits;
use Modules\Owner\Http\Requests\User\UpdateRequest;
use Modules\Owner\Http\Traits\ResponseUnauthorizedTraits;
use Modules\Owner\Repositories\MstUser\UserRepositoryInterface;
use Modules\Owner\Repositories\Prefecture\PrefectureRepositoryInterface;

class UserController extends Controller
{
    use ResponseTraits;
    use ResponseUnauthorizedTraits;

    protected $userRepository;
    protected $prefectureRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        PrefectureRepositoryInterface $prefectureRepository
    ) {
        $this->userRepository = $userRepository;
        $this->prefectureRepository = $prefectureRepository;
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
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit(Request $request, $id)
    {
        $responseMessageToNative   = [
            'code' => Response::HTTP_UNAUTHORIZED,
            'message' => __('message.post_message.unauthorized')
        ];

        if (!(Auth::guard('api')->user())) {
            return view('owner::users.unauthorized', compact('responseMessageToNative'));
        }

        try {
            $user = Auth::guard('api')->user();
            $prefecture = $this->prefectureRepository->get($user->prefectures_cd);

            if ($user->user_cd != $id) {
                return view('owner::users.unauthorized', compact('responseMessageToNative'));
            }

            return view('owner::users.edit', compact('user', 'prefecture'));
        } catch (QueryException $e) {
            Log::error($e->getMessage());

            return $this->handleErrorResponse();
        }
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(UpdateRequest $request, $id)
    {
        $checkEmailExits = $this->userRepository->checkEmailExits($request->mail_add, $id);

        if ($checkEmailExits) {
            return response()->json([
                "errors" => [
                    'mail_add' =>  __('message.register.email_address_already_exists'),
                ]
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user = Auth::guard('api')->user();

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
        ];
    }
}

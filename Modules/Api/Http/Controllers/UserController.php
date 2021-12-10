<?php

namespace Modules\Api\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Modules\Api\Repositories\MstUser\MstUserRepository;
use Modules\Owner\Repositories\Prefecture\PrefectureRepository;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    protected $mstUserRepository;
    protected $prefectureRepository;

    public function __construct(
        MstUserRepository $mstUserRepository,
        PrefectureRepository $prefectureRepository
    )
    {
        $this->mstUserRepository = $mstUserRepository;
        $this->prefectureRepository = $prefectureRepository;
    }

    public function getUserDetail()
    {
        try {
            $user = Auth::guard('api')->user();
            $prefectures = $this->prefectureRepository->show($user->prefectures_cd)->prefectures_name;

            return response()->json([
                'userID' => $user->user_cd,
                'userType' => $user->howto_use,
                'firstName' => $user->name_sei,
                'lastName' => $user->name_mei,
                'corporateName' => $user->corporate_name,
                'customerType' => $user->user_kbn,
                'departmentName' => $user->department,
                'contactName' => $user->person_man,
                'email' => $user->mail_add,
                'phoneNumber' => $user->tel_no,
                'zipCd' => $user->zip_cd,
                'prefectures' => $prefectures,
                'municipality' => $user->municipality_name,
                'townname' => $user->townname_address,
                'building' => $user->building_name,
            ]);
        } catch (QueryException $ex) {
            Log::error(__FILE__ . ' ' . __LINE__ . ': == Call api get detail user fail == ' . $ex->getMessage());

            return response()->json([
                "errors" => [
                    "message" => [__('message.response.http_internal_server_error')]
                ]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

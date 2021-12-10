<?php

namespace Modules\Api\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Modules\Api\Http\Requests\OwnerNotice\OwnerNoticeRequest;
use Modules\Api\Repositories\Parking\ApiParkingLotRepository;
use Modules\Api\Traits\ConvertTimeTraits;
use Modules\Api\Transformers\OwnerNoticeTransformer;
use Modules\Owner\Repositories\OwnerNotice\OwnerNoticeRepository;
use Symfony\Component\HttpFoundation\Response;

class OwnerNoticeController extends Controller
{
    use ConvertTimeTraits;
    protected $noticeRepository;
    protected $apiParkingLotRepository;

    public function __construct(
        OwnerNoticeRepository $noticeRepository,
        ApiParkingLotRepository $apiParkingLotRepository
    )
    {
        $this->noticeRepository = $noticeRepository;
        $this->apiParkingLotRepository = $apiParkingLotRepository;
    }

    public function getListNotice(OwnerNoticeRequest $request)
    {
        $parkingID = $request->get('parkingID');
        $page = $request->get('page');
        $pageSize = $request->get('pageSize');

        try {
            $countListNotices = $this->noticeRepository->countListNotice($parkingID);
            $parkingIsExist = $this->apiParkingLotRepository->checkExistParking($parkingID);

            if (!$parkingIsExist) {
                $errorMessage = trans('message.parking_lot.not_exists');
                Log::error(__FILE__ . ' ' . __LINE__ . ': ' . $errorMessage);

                return response()->json([
                    "errors" => [
                        'message' => [$errorMessage],
                    ]
                ], Response::HTTP_NOT_FOUND);
            }

            $countNotice = $countListNotices->count();
            $result = fractal(
                $countListNotices->forPage($page, $pageSize),
                new OwnerNoticeTransformer()
            )->serializeWith(new \App\Serializer\CustomSerializer);

            return response()->json([
                'data' => $result,
                'total' => $countNotice,
                'totalPage' => $this->getTotalPage($countNotice, $pageSize),
            ], Response::HTTP_OK);

        } catch (QueryException $exception) {
            Log::error(__FILE__ . ' ' . __LINE__ . ': == Call api get lists notice fail == ' . $exception->getMessage());

            return response()->json([
                "errors" => [
                    "message" => [__('message.response.http_internal_server_error')]
                ]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getTotalPage($notices, $pageSize)
    {
        return ceil($notices / $pageSize);
    }

    public function getDetail($noticeID)
    {
        try {
            $ownerNotice = $this->noticeRepository->show($noticeID);

            if (empty($ownerNotice)) {
                $errorMessage = trans('message.notice_not_exists');
                Log::error(__FILE__ . ' ' . __LINE__ . ': ' . $errorMessage);

                return response()->json([
                    "errors" => [
                        'message' => [$errorMessage],
                    ]
                ], Response::HTTP_NOT_FOUND);
            }

            return response()->json([
                'noticeID' => $ownerNotice->notics_cd,
                'noticeTitle' => $ownerNotice->notics_title,
                'noticeDetails' => $ownerNotice->notics_details,
                'createdAt' => ($ownerNotice->created_at)->format('Y-m-d\TH:m:sP')
            ], Response::HTTP_OK);
        } catch (QueryException $exception) {
            Log::error(__FILE__ . ' ' . __LINE__ . ': == Call api get detail notice fail == ' . $exception->getMessage());

            return response()->json([
                "errors" => [
                    "message" => [__('message.response.http_internal_server_error')]
                ]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

<?php

namespace Modules\Api\Http\Controllers;

use App\Exceptions\UserCreatedException;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Modules\Api\Http\Requests\Parking\ParkingLotRequest;
use Modules\Api\Http\Requests\Review\ReviewRequest;
use Modules\Api\Http\Requests\Review\StoreReviewRequest;
use Modules\Api\Http\Requests\Review\UpdateReviewRequest;
use Modules\Api\Traits\ResponseUnauthorizedTraits;
use Modules\Api\Repositories\Parking\ApiParkingLotRepositoryInterface;
use Modules\Api\Repositories\Review\ApiReviewRepositoryInterface;
use Modules\Api\Transformers\ParkingLotReviewTransformer;
use Modules\Api\Transformers\UserReviewTransformer;
use phpDocumentor\Reflection\Types\Object_;
use Symfony\Component\HttpFoundation\Response;

class ReviewController extends Controller
{
    use ResponseUnauthorizedTraits;

    protected $apiParkingLotRepository;
    protected $apiReviewRepository;

    public function __construct(
        ApiParkingLotRepositoryInterface $apiParkingLotRepository,
        ApiReviewRepositoryInterface $apiReviewRepository
    )
    {
        $this->apiParkingLotRepository = $apiParkingLotRepository;
        $this->apiReviewRepository = $apiReviewRepository;
    }

    public function index(ReviewRequest $request)
    {

        if ($request->header('Authorization') && (Auth::guard('api')->user() == null)) {
            return $this->handleResponseUnauthorized();
        }

        try {
            $parkingID = $request->get('parkingID');
            $page = $request->get('page');
            $pageSize = $request->get('pageSize');
            $parkingLots = $this->apiParkingLotRepository->find($parkingID);
            $result = fractal(
                $parkingLots,
                new ParkingLotReviewTransformer(
                    $this->apiParkingLotRepository,
                    $parkingID,
                    $page,
                    $pageSize
                )
            )->serializeWith(new \App\Serializer\ParkingLotReviewSerialize);

            return response()->json($result, Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                "errors" => [
                    "message" => [__('message.response.http_internal_server_error')]
                ]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(StoreReviewRequest $request)
    {
        $parking = $this->apiParkingLotRepository->get($request->parkingID);

        if(!$parking) {
            return response()->json(
                [
                    'message' => __('message.parking_lot.not_exists')
                ],
                Response::HTTP_NOT_FOUND
            );
        }

        $numberReviewOfUser = $this->apiReviewRepository->getReviewOfUser($request->parkingID)->get()->count();

        if ($numberReviewOfUser) {
            return response()->json(
                [
                    'message' => __('message.review.allow_one_review_for_parking')
                ],
                Response::HTTP_CONFLICT
            );
        }

        $user = Auth::guard('api')->user();
        $dataStore = [
            'parking_cd' => $request->parkingID,
            'evaluation_satisfaction' => $request->satisfation,
            'evaluation_location' => $request->location,
            'evaluation_ease_stopping' => $request->easeStopping,
            'evaluation_fee' => $request->fee,
            'comment' => $request->comment,
            'receipt_number' => 1, //Currently hard fix because no specs,
            'user_cd' => $user->user_cd,
            'registered_person' => $user->person_man,
            'updater' => $user->person_man
        ];

        try {
            $this->apiReviewRepository->store($dataStore);
            $review = $this->apiReviewRepository->getLatestBySerialNo();

            return response()->json(
                [
                    'message' => __('message.success'),
                    'reviewID' => $review->serial_no
                ],
                Response::HTTP_OK
            );
        } catch (QueryException $e) {
            Log::error($e->getMessage());

            return response()->json(
                [
                    'message' => __('message.error')
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function getReview(ParkingLotRequest $request)
    {
        try {
            $parkingCd = $request['parkingID'];
            $review = $this->apiReviewRepository->getReviewOfUser($parkingCd)->first();

            if (isset($review)) {
                return response()->json(
                    [
                        'data' => fractal($review, new UserReviewTransformer()),
                        "result" => true,
                    ], Response::HTTP_OK
                );
            } else {
                return response()->json(
                    [
                        'data' => new Object_(),
                        "result" => false,
                    ], Response::HTTP_OK
                );
            }

        } catch (QueryException $e) {
            return response()->json([
                "errors" => [
                    "message" => [__('message.response.http_internal_server_error')]
                ]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(UpdateReviewRequest $request, $id)
    {
        try {
            $dataUpdate = [
                'evaluation_satisfaction' => $request['satisfation'],
                'evaluation_location' => $request['location'],
                'evaluation_ease_stopping' => $request['easeStopping'],
                'evaluation_fee' => $request['fee'],
                'comment' => $request['comment'],
            ];

            $this->apiReviewRepository->update($id, $dataUpdate);

            return response()->json(
                [
                    'message' => __('message.success'),
                    'reviewID' => $id
                ],
                Response::HTTP_OK
            );
        } catch (QueryException $e) {
            Log::error($e->getMessage());

            return response()->json(
                [
                    'message' => __('message.error')
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        } catch (UserCreatedException $userCreatedException){
            Log::error($userCreatedException->getMessage());

            return response()->json(
                [
                    "errors" => [
                        'message' => __('message.response.unauthorized')
                    ]
                ],
                Response::HTTP_NOT_FOUND
            );
        }
    }
}

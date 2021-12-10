<?php

namespace Modules\Api\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Modules\Api\Http\Requests\Favorite\FavoriteRequest;
use Modules\Api\Repositories\Favorite\ApiFavoriteRepositoryInterface;
use Modules\Api\Repositories\Parking\ApiParkingLotRepositoryInterface;
use Symfony\Component\HttpFoundation\Response;

class FavoriteController extends Controller
{
    protected $apiFavoriteRepository;
    protected $apiParkingLotRepository;

    public function __construct(
        ApiFavoriteRepositoryInterface $apiFavoriteRepository,
        ApiParkingLotRepositoryInterface $apiParkingLotRepository
    )
    {
        $this->apiFavoriteRepository = $apiFavoriteRepository;
        $this->apiParkingLotRepository = $apiParkingLotRepository;
    }

    public function favorite(FavoriteRequest $request)
    {
        try {
            $parkingID = $request->get('parkingID');
            $isFavorite = $request->get('isFavorite');
            $isParklotExist = $this->apiParkingLotRepository->exist($parkingID);
            if (!$isParklotExist) {
                return response()->json([
                    "errors" => [
                        "message" => [__('message.parking_lot.not_exists')]
                    ]
                ], Response::HTTP_NOT_FOUND);;
            }

            $result = $this->apiFavoriteRepository->updateFavorite($parkingID, $isFavorite);

            return response()->json($result, Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                "errors" => [
                    "message" => [__('message.response.http_internal_server_error')]
                ]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

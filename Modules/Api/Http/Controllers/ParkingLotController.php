<?php

namespace Modules\Api\Http\Controllers;

use Modules\Api\Http\Requests\Parking\FavoriteParkingListRequest;
use Modules\Api\Repositories\Favorite\ApiFavoriteRepositoryInterface;
use Throwable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpFoundation\Response;
use Modules\Api\Transformers\ParkingTransformers;
use Modules\Api\Transformers\ParkingLotTransformer;
use Modules\Api\Traits\ResponseUnauthorizedTraits;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use Modules\Api\Http\Requests\Parking\ParkingListRequest;
use Modules\Api\Repositories\Parking\ApiParkingLotRepositoryInterface;

class ParkingLotController extends Controller
{
    use ResponseUnauthorizedTraits;
    protected $apiParkingLotRepository;
    protected $apiFavoriteRepository;

    public function __construct(ApiParkingLotRepositoryInterface $apiParkingLotRepository,
        ApiFavoriteRepositoryInterface $apiFavoriteRepository
    )
    {
        $this->apiParkingLotRepository = $apiParkingLotRepository;
        $this->apiFavoriteRepository = $apiFavoriteRepository;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(ParkingListRequest $request)
    {

        if ($request->header('Authorization') && (Auth::guard('api')->user() == null)) {
            return $this->handleResponseUnauthorized();
        }

        $params = $request->all();
        $perPage = $request->get('pageSize', config('constants.SLOT_PARKING_PAGE_ITEM'));
        $parkings = $this->apiParkingLotRepository->getCarParkingList($params, $perPage);
        $paginate = fractal()->collection($parkings)
            ->transformWith(new ParkingTransformers)
            ->paginateWith(new IlluminatePaginatorAdapter($parkings))
            ->toArray();

        return response()->json(
            [
                "data" => fractal()->collection($parkings, new ParkingTransformers())
                    ->parseIncludes('menu')
                    ->toArray(),
                'total' => $paginate["meta"]["pagination"]["total"],
                'totalPage' => $paginate["meta"]["pagination"]["total_pages"]
            ], Response::HTTP_OK
        );
    }

    public function show(Request $request, $parkingLotID)
    {

        if ($request->header('Authorization') && (Auth::guard('api')->user() == null)) {
            return $this->handleResponseUnauthorized();
        }

        try {
            $parkingLot = $this->apiParkingLotRepository->find($parkingLotID);
            $result = fractal($parkingLot, new ParkingLotTransformer($this->apiParkingLotRepository))
                ->parseIncludes(['menu']);

            return response()->json($result, Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                "errors" => [
                    "message" => [__('message.response.http_internal_server_error')]
                ]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getListFavorite(FavoriteParkingListRequest $request)
    {
        $params = $request->all();
        $perPage = $request->get('pageSize');
        $favorites = $this->apiFavoriteRepository->getListFavoriteOfUser();
        $parkings = $this->apiParkingLotRepository->getCarParkingInListFav($favorites, $perPage);

        $paginate = fractal()->collection($parkings)
            ->transformWith(new ParkingTransformers)
            ->paginateWith(new IlluminatePaginatorAdapter($parkings))
            ->toArray();

        return response()->json(
            [
                "data" => fractal()->collection($parkings, new ParkingTransformers())
                    ->parseIncludes('menu')
                    ->toArray(),
                'total' => $paginate["meta"]["pagination"]["total"],
                'totalPage' => $paginate["meta"]["pagination"]["total_pages"]
            ], Response::HTTP_OK
        );
    }
}

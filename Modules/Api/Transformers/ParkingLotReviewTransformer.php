<?php

namespace Modules\Api\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\ParkingLot;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use Modules\Api\Repositories\Parking\ApiParkingLotRepositoryInterface;

class ParkingLotReviewTransformer extends TransformerAbstract
{
    protected $defaultIncludes = ['review'];
    protected $apiParkingLotRepository;
    protected $parkingID;
    protected $page;
    protected $pageSize;

    public function __construct(
        ApiParkingLotRepositoryInterface $apiParkingLotRepository,
        int $parkingID,
        int $page,
        int $pageSize
    )
    {
        $this->apiParkingLotRepository = $apiParkingLotRepository;
        $this->parkingID = $parkingID;
        $this->page = $page;
        $this->pageSize = $pageSize;
    }

    public function transform(ParkingLot $parkingLot)
    {
        return [
            'evaluation' => [
                'total' => $this->getAvgTotal($parkingLot),
                'satisfation' => $parkingLot->reviews->avg('evaluation_satisfaction') ?? 0,
                'location' => $parkingLot->reviews->avg('evaluation_location') ?? 0,
                'easeStopping' => $parkingLot->reviews->avg('evaluation_ease_stopping') ?? 0,
                'fee' => $parkingLot->reviews->avg('evaluation_fee') ?? 0
            ],
            'total' => $this->getTotalRecord($parkingLot),
            'totalPage' => $this->getTotalPage($parkingLot),
        ];
    }

    public function includeReview(ParkingLot $parkingLot)
    {
        $reviews = $parkingLot->reviews()->latest()->paginate($this->pageSize);

        $paginate = new IlluminatePaginatorAdapter($reviews);
        $curPage = $paginate->getUrl($this->page) .
            '&parkingID=' . $this->parkingID .
            '&pageSize=' . $this->pageSize;

        $reviews->withPath($curPage);

        return $this->collection($reviews, new ReviewTransformer())
            ->setPaginator(new IlluminatePaginatorAdapter($reviews));
    }

    public function getAvgTotal(ParkingLot $parkingLot)
    {
        return $this->apiParkingLotRepository->getReviewEvaluation($parkingLot->reviews);
    }

    public function getTotalRecord(ParkingLot $parkingLot)
    {
        return $parkingLot->reviews->count();
    }

    public function getTotalPage(ParkingLot $parkingLot)
    {
        return ceil($this->getTotalRecord($parkingLot) / $this->pageSize);
    }
}

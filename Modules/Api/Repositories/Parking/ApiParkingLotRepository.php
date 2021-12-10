<?php

namespace Modules\Api\Repositories\Parking;

use App\Models\ParkingLot;
use App\Models\ParkingSpace;
use Modules\Api\Repositories\RepositoryAbstract;

class ApiParkingLotRepository extends RepositoryAbstract implements ApiParkingLotRepositoryInterface
{
    protected $model;

    public function __construct(ParkingLot $model)
    {
        $this->model = $model;
    }

    public function find($parkingCd)
    {
        return $this->model->find($parkingCd);
    }

    public function getReviewEvaluation($reviews)
    {
        $avg = [
            $reviews->avg('evaluation_satisfaction'),
            $reviews->avg('evaluation_location'),
            $reviews->avg('evaluation_ease_stopping'),
            $reviews->avg('evaluation_fee')
        ];

        return array_sum($avg) / count($avg);
    }

    public function getCarParkingList($params, $perPage)
    {
        $result = $this->model;

        $result = $this->findRadius($params['lat'], $params['lon'], $params['radius'], $result);

        if (isset($params['carType'])) {
            $carType = $params['carType'];
            switch ($carType) {
                case ParkingSpace::CARTYPE_KBN_STANDARD:
                    $result = $result->whereHas('parkingSpaces', function ($query) use ($carType) {
                        $query->where('kbn_standard', ParkingSpace::KBN_STANDARD_ENABLE);
                    });
                    break;
                case ParkingSpace::CARTYPE_KBN_3NO:
                    $result = $result->whereHas('parkingSpaces', function ($query) use ($carType) {
                        $query->where('kbn_3no', ParkingSpace::KBN_3NO_ENABLE);
                    });
                    break;
                default:
                    $result = $result->whereHas('parkingSpaces', function ($query) use ($carType) {
                        $query->where('kbn_lightcar', ParkingSpace::KBN_LIGHTCAR_ENABLE);
                    });
                    break;
            }
        }
        if (isset($params['parkingForm'])) {
            $parkingForm = $params['parkingForm'];
            $result = $result->whereHas('parkingSpaces', function ($query) use ($parkingForm) {
                $query->where('parking_form', $parkingForm);
            });
        }
        if (isset($params['useDate'])) {
            $result = $result->useDate($params['useDate']);
        }
        if (isset($params['loanType'])) {
            $result = $result->loanType($params['loanType']);
        }
        if (isset($params['is24Hour']) && $params['is24Hour']) {
            $result = $result->where('sales_division', $params['is24Hour']);
        }
        if (isset($params['sort'])) {
            switch ($params['sort']) {
                case ParkingLot::SORT_BY_DISTANCE:
                    $result = $result->orderBy("distance", config('constants.TYPE_SORT.ASCENDING'));
                    break;
                case ParkingLot::SORT_BY_EVALUATION:
                    $result = $this->queryReviewEvaluation($result)->orderBy('evaluation', config('constants.TYPE_SORT.DESCENDING'));
                    break;
                case ParkingLot::SORT_BY_COUNT_REVIEW:
                    $result = $this->queryCountReview($result)->orderBy('countReview', config('constants.TYPE_SORT.DESCENDING'));
                    break;
                default:
            }
        }

        return $result->paginate($perPage);
    }

    protected function findRadius($lat, $lon, $radius, $result)
    {
        return $result->with('reviews')->selectRaw("tbl_parking_lot.* ,
            6371e3 * 2 * atan2(
            sqrt(
                pow(sin(((latitude-$lat) * pi()/180)/2), 2) +
                cos($lat * pi()/180) *
                cos(latitude * pi()/180) *
                pow(sin(((longitude-$lon) * pi()/180)/2), 2)
            ), sqrt(
                1-(
                    pow(sin(((latitude-$lat) * pi()/180)/2), 2) +
                    cos($lat * pi()/180) *
                    cos(latitude * pi()/180) *
                    pow(sin(((longitude-$lon) * pi()/180)/2), 2)
                )
            )
        ) as distance ")
            ->having("distance", "<", $radius);
    }

    protected function queryCountReview($result)
    {
        return $result->leftJoin('tbl_review', 'tbl_review.parking_cd', 'tbl_parking_lot.parking_cd')
            ->selectRaw("COUNT(tbl_review.serial_no) as countReview")
            ->groupBy('tbl_parking_lot.parking_cd', 'tbl_parking_lot.parking_name');
    }

    protected function queryReviewEvaluation($result)
    {
        $result = $result->leftJoin('tbl_review', 'tbl_review.parking_cd', 'tbl_parking_lot.parking_cd');
        return $result->selectRaw("(
        AVG(tbl_review.evaluation_satisfaction) +
        AVG(tbl_review.evaluation_location) +
        AVG(tbl_review.evaluation_ease_stopping) +
        AVG(tbl_review.evaluation_fee)) / 4
         as evaluation")
            ->groupBy('tbl_parking_lot.parking_cd', 'tbl_parking_lot.parking_name');
    }

    public function getCarParkingInListFav($favorites, $perPage)
    {
        $arrParkingCd = [];
        foreach ($favorites as $favorite) {
            $arrParkingCd[] = $favorite->parking_cd;
        }

        return $this->model->whereIn('parking_cd', $arrParkingCd)->paginate($perPage);
    }

    public function checkExistParking($parkingID)
    {
        return $this->model->where('parking_cd', $parkingID)->exists();
    }
}

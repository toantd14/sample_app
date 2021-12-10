<?php

namespace Modules\Api\Repositories\Parking;

use Modules\Api\Repositories\RepositoryInterface;

interface ApiParkingLotRepositoryInterface extends RepositoryInterface
{
    public function find($parkingCd);

    public function getReviewEvaluation($reviews);

    public function getCarParkingList($params, $perPage);

    public function getCarParkingInListFav($favorites, $perPage);

    public function checkExistParking($parkingID);
}

<?php

namespace Modules\Owner\Repositories\Parking;

use Modules\Owner\Repositories\RepositoryInterface;

interface ParkingLotRepositoryInterface extends RepositoryInterface
{
    public function getParkingLots();

    public function getByOwnerCd($ownerCd);

    public function find($parkingCd);

    public function getByCode($code);

    public function getAll($ownerCd);

    public function isCreateByOwner($ownerCd, $parkingCd);
}

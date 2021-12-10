<?php

namespace Modules\Admin\Repositories\Parking;

use Modules\Admin\Repositories\RepositoryInterface;

interface AdminParkingLotRepositoryInterface extends RepositoryInterface
{
    public function getParkingLots();

    public function getByOwnerCd($ownerCd);

    public function find($parkingCd);

    public function getByCode($code);

    public function getAll($ownerCd);

    public function isCreateByOwner($ownerCd, $parkingCd);

    public function search($dataSearch);
}

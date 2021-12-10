<?php

namespace Modules\Owner\Repositories\Parking;

use App\Models\ParkingLot;
use Modules\Owner\Repositories\RepositoryAbstract;

class ParkingLotRepository extends RepositoryAbstract implements ParkingLotRepositoryInterface
{
    public function __construct(ParkingLot $parking)
    {
        $this->model = $parking;
    }

    public function getParkingLots()
    {
        $parkings = $this->model->with('parkingSpace')->get();

        return $parkings;
    }

    public function getByOwnerCd($ownerCd)
    {
        return $this->model->ownerCd($ownerCd)->first();
    }

    public function find($parkingCd)
    {
        return $this->model->with('parkingMenu.parkingMenuTime')->find($parkingCd);
    }

    public function getByCode($code)
    {
        return $this->model->code($code)->first();
    }

    public function getAll($ownerCd)
    {
        return $this->model->ownerCd($ownerCd)->latest()->get();
    }

    public function isCreateByOwner($ownerCd, $parkingCd)
    {
        return $this->model->ownerCd($ownerCd)->find($parkingCd);
    }
}

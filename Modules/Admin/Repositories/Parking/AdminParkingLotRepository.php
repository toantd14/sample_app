<?php

namespace Modules\Admin\Repositories\Parking;

use App\Models\ParkingLot;
use Modules\Admin\Repositories\RepositoryAbstract;

class AdminParkingLotRepository extends RepositoryAbstract implements AdminParkingLotRepositoryInterface
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
        return $this->model->ownerCd($ownerCd)->get();
    }

    public function isCreateByOwner($ownerCd, $parkingCd)
    {
        return $this->model->ownerCd($ownerCd)->find($parkingCd);
    }

    public function search($dataSearch)
    {
        return $this->model->PrefecturesCd($dataSearch['prefectures_cd'])
            ->when(!empty($dataSearch['municipality_name']), function ($query) use ($dataSearch) {
                $query->where('municipality_name', 'LIKE', '%'.$dataSearch["municipality_name"].'%')
                    ->orWhere('townname_address', 'LIKE', '%'.$dataSearch["municipality_name"].'%');
            })
            ->ParkingCd($dataSearch['parking_cd'])
            ->OwnerCd($dataSearch['owner_cd'])
            ->CreatedAt($dataSearch['created_at_from'], $dataSearch['created_at_to'])
            ->UpdatedAt($dataSearch['updated_at_from'], $dataSearch['updated_at_to']);
    }
}

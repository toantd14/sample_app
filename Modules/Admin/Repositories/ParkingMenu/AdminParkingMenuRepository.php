<?php

namespace Modules\Admin\Repositories\ParkingMenu;

use App\Models\ParkingMenu;
use Modules\Admin\Repositories\RepositoryAbstract;

class AdminParkingMenuRepository extends RepositoryAbstract implements AdminParkingMenuRepositoryInterface
{
    public function __construct(ParkingMenu $parkingMenu)
    {
        $this->model = $parkingMenu;
    }

    public function getByOwnerCd($owner_cd)
    {
        return $this->model->ownerCd($owner_cd)->first();
    }

    public function getMenuMaster($ownerCd)
    {
        return $this->model->menuMaster($ownerCd)->first();
    }

    public function replicateMenuMaster($parkingMenuMaster)
    {
        $cloneMenu = $parkingMenuMaster->replicate();
        $cloneMenu->save();

        return $cloneMenu;
    }

    public function getMenuByParkingCD($parkingCD)
    {
        return $this->model->where('parking_cd', $parkingCD)->firstOrFail();
    }
}

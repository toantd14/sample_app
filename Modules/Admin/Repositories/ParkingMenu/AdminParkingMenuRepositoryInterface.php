<?php

namespace Modules\Admin\Repositories\ParkingMenu;

use Modules\Admin\Repositories\RepositoryInterface;

interface AdminParkingMenuRepositoryInterface extends RepositoryInterface
{
    public function getByOwnerCd($owner_cd);

    public function getMenuMaster($ownerCd);

    public function replicateMenuMaster($parkingMenuMaster);

    public function getMenuByParkingCD($parkingCD);
}

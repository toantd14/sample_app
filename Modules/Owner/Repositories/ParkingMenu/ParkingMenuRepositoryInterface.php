<?php

namespace Modules\Owner\Repositories\ParkingMenu;

use Modules\Owner\Repositories\RepositoryInterface;

interface ParkingMenuRepositoryInterface extends RepositoryInterface
{
    public function getByOwnerCd($owner_cd);

    public function getMenuMaster($ownerCd);

    public function calculatorPeriod($parkingMenu, $startDate, $endDate, $holidays);

    public function replicateMenuMaster($parkingMenuMaster);

    public function getMenuByParkingCD($parkingCD);

    public function getFromAndToTime($parkingMenu);
}

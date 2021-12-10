<?php

namespace Modules\Owner\Repositories\ParkingMenuTime;

use Modules\Owner\Repositories\RepositoryInterface;

interface ParkingMenuTimeRepositoryInterface extends RepositoryInterface
{
    public function getByOwnerCd($ownerCd);

    public function getByMenuCd($menuCd);

    public function deleteById($id);

    public function deleteByMenuCdAndDayType($menuCd);

    public function replicateMenuTime($menuTime);

    public function calculateTime($menuCD, $startDate, $startTime, $endTime);

    public function getMenuTimeByMenuCdAndCheck($parking, $menuCd);

    public function getMenuTimeByMenuCd($menuCd);
}

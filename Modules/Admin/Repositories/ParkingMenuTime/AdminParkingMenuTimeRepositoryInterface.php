<?php

namespace Modules\Admin\Repositories\ParkingMenuTime;

use Modules\Admin\Repositories\RepositoryInterface;

interface AdminParkingMenuTimeRepositoryInterface extends RepositoryInterface
{
    public function getByOwnerCd($ownerCd);

    public function deleteById($id);

    public function deleteByMenuCdAndDayType($menuCd);

    public function replicateMenuTime($menuTime);

    public function calculateTime($menuCD, $startDate, $startTime, $endTime);

    public function getMenuTimeByMenuCdAndCheck($parking, $menuCd);
}

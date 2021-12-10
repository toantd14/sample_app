<?php

namespace Modules\Owner\Repositories\ParkingSpace;

use Modules\Owner\Repositories\RepositoryInterface;

interface ParkingSpaceRepositoryInterface extends RepositoryInterface
{
    public function getAllSlotParking($parkingCd);

    public function destroy($ids);

    public function show($id);

    public function getSpaceNo($spaceNo);

    public function handleSpaceForm($spaceNoForm, $spaceNoTo);

    public function checkParkingSpaceExist($parkingCd, $symbol, $spaceNo);

    public function checkParkingSpaceUpdateExist($parkingCd, $symbol, $spaceNo, $serialNo);

    public function getSpacesExceptSpaceNo($parkingCd, $serialNo = null);
}

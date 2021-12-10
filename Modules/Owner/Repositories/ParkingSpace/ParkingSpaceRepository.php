<?php

namespace Modules\Owner\Repositories\ParkingSpace;

use App\Models\ParkingSpace;
use Modules\Owner\Repositories\RepositoryAbstract;

class ParkingSpaceRepository extends RepositoryAbstract implements ParkingSpaceRepositoryInterface
{
    public function __construct(ParkingSpace $parkingSpace)
    {
        $this->model = $parkingSpace;
    }

    public function getAllSlotParking($parkingCd)
    {
        $pageItem = config('constants.SLOT_PARKING_PAGE_ITEM');

        return $this->model->slotParking($parkingCd)
            ->orderBy('space_symbol', 'ASC')
            ->orderByRaw('LENGTH(space_no)', 'ASC')
            ->orderBy('space_no', 'ASC')
            ->paginate($pageItem);
    }

    public function getSpaceNo($spaceNo)
    {
        $spaceNoFormTo = [
            'spaceNoForm' => isset(explode('~', $spaceNo)[0]) ? explode('~', $spaceNo)[0] : '',
            'spaceNoTo' => isset(explode('~', $spaceNo)[1]) ? explode('~', $spaceNo)[1] : ''
        ];

        return $spaceNoFormTo;
    }

    public function handleSpaceForm($spaceNoForm, $spaceNoTo)
    {
        $spaceNo = $spaceNoForm;
        if ($spaceNoTo) {
            $spaceNo = $spaceNoForm . '~' . $spaceNoTo;
        }

        return $spaceNo;
    }

    public function checkParkingSpaceExist($parkingCd, $symbol, $spaceNo)
    {
        return $this->model
            ->slotParking($parkingCd)
            ->spaceSymbol($symbol)
            ->first();
    }

    public function checkParkingSpaceUpdateExist($parkingCd, $symbol, $spaceNo, $serialNo)
    {
        return $this->model
            ->notSerialNo($serialNo)
            ->slotParking($parkingCd)
            ->spaceSymbol($symbol)
            ->first();
    }

    public function getSpacesExceptSpaceNo($parkingCd, $serialNo = null)
    {
        if (!$serialNo) {
            return $this->model->slotParking($parkingCd)->get();
        }

        return $this->model->notSerialNo($serialNo)->slotParking($parkingCd)->get();
    }
}

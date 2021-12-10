<?php

namespace Modules\Api\Transformers;

use Carbon\Carbon;
use App\Models\ParkingLot;
use Modules\Api\Traits\FavoriteTraits;
use League\Fractal\TransformerAbstract;
use Modules\Api\Transformers\ParkingMenuIsEnableTransformers;

class ParkingTransformers extends TransformerAbstract
{
    use FavoriteTraits;

    protected $availableIncludes = ['menu'];

    public function transform(ParkingLot $parkingLot)
    {
        return [
            "parkingID" => $parkingLot->parking_cd,
            "parkingName" => $parkingLot->parking_name,
            "lat" => (double)$parkingLot->latitude,
            "lon" => (double)$parkingLot->longitude,
            "evaluation" => $parkingLot->getEvaluation(),
            "reviewNumber" => $parkingLot->reviews()->count(),
            "is24Hour" => (bool)$parkingLot->sales_division,
            "openTime" => $parkingLot->sales_start_time,
            "endTime" => $parkingLot->sales_end_time,
            "isFav" => $this->checkFavorite($parkingLot),
            "mgnFlg" => intval($parkingLot->mgn_flg)
        ];
    }

    public function includeMenu(ParkingLot $parkingLot)
    {
        if (!$parkingLot->parkingMenu){
            return null;
        }
        
        return $this->item($parkingLot->parkingMenu, new ParkingMenuIsEnableTransformers());
    }
}

<?php


namespace Modules\Api\Transformers;


use App\Models\UseSituation;
use League\Fractal\TransformerAbstract;

class BookingHistoriesTransformer extends TransformerAbstract
{
    public function transform(UseSituation $useSituation)
    {
        if ($useSituation->use_day) {
            $date = $useSituation->useDay;
        } else {
            $date = ($useSituation->visit_no == 0 || $useSituation->visit_no == 1) ? $useSituation->start_day : $useSituation->reservation_day;
        }

        $fromTime = $useSituation->use_day ? $useSituation->usetime_from : ($useSituation->from_reservation_time ?? $useSituation->putin_time);

        $toTime = $useSituation->use_day ? $useSituation->usetime_to : ($useSituation->to_reservation_time ?? $useSituation->putout_time);

        $price = $useSituation->use_day ? $useSituation->parking_fee : $useSituation->money_reservation;

        return [
            "bookingID" => $useSituation->bookingID,
            "bookingType" => $useSituation->bookingType,
            "parkingID" => $useSituation->parkingID,
            "parkingName" => $useSituation->parkingName,
            "date" => $date,
            "fromTime" => $fromTime,
            "toTime" => $toTime,
            "price" => $price,
            "isUse" => isset($useSituation->use_day),
            "customerType" => $useSituation->division,
        ];
    }
}

<?php

namespace Modules\Api\Traits;

use App\Models\UseSituation;
use App\Rules\EndTime;

// TODO update trait location
trait RequestBookingCar
{
    public function requestBookingCar($request) {
        $bookingTime = [];
        if (!empty($request) && isset($request['bookingType'])) {
            switch ($request['bookingType']) {
                case UseSituation::RENT_BY_MONTH :
                    $bookingTime = [
                        'bookingTime.month' => 'required|int|min:1',
                    ];
                    break;
                case UseSituation::RENT_BY_DAY :
                    $bookingTime = [
                        'bookingTime.startTime' => 'required|date_format:H:i',
                    ];
                    break;
                case UseSituation::RENT_BY_PERIOD :
                    $bookingTime = [
                        'bookingTime.endDate' => 'required|date_format:Y-m-d|after_or_equal:bookingTime.startDate',
                    ];
                    break;
                case UseSituation::RENT_BY_HOUR :
                    $bookingTime = [
                        'bookingTime.startTime' => 'required|date_format:H:i',
                        'bookingTime.endTime' => [
                            'required',
                            new EndTime
                        ],
                    ];
                    break;
            }

        } else {
            $bookingTime = [
                'bookingTime.month' => 'required_if:bookingTime.bookingType,' . UseSituation::RENT_BY_MONTH . '|nullable|int|min:1',
                'bookingTime.startTime' => 'required_if:bookingTime.bookingType,' . UseSituation::RENT_BY_DAY . '|required_if:bookingTime.bookingType,' . UseSituation::RENT_BY_HOUR . '|date_format:H:i|nullable',
                'bookingTime.endDate' => 'required_if:bookingTime.bookingType,' . UseSituation::RENT_BY_PERIOD . '|date_format:Y-m-d|nullable',
                'bookingTime.endTime' => 'required_if:bookingTime.bookingType,' . UseSituation::RENT_BY_HOUR . '|date_format:H:i|nullable',
            ];
        }

        return $bookingTime;
    }
}

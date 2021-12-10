<?php

namespace Modules\Api\Http\Requests\UseSituation;

use App\Models\UseSituation;
use Modules\Api\Http\Requests\BaseRequest;
use Modules\Api\Traits\RequestBookingCar;

class CalculateRequest extends BaseRequest
{
    use RequestBookingCar;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $baseRules = [
            'parkingID' => 'required|int|min:1',
            'bookingTime.bookingType' => 'required|int|min:0|in:' . implode(',', config('constants.BOOKING_TYPE')),
            'bookingTime.startDate' => 'required|date_format:Y-m-d',
        ];

        $bookingTime = $this->requestBookingCar(request()->bookingTime);
        $baseRules = array_merge($baseRules, $bookingTime);
        return $baseRules;
    }
}

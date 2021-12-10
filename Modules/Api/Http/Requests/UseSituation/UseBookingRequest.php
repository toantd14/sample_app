<?php

namespace Modules\Api\Http\Requests\UseSituation;

use Modules\Api\Http\Requests\BaseRequest;

class UseBookingRequest extends BaseRequest
{
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
        return [
            'bookingID' => 'required|int|min:1',
            'paymentPrice' => 'required|int',
            'useDay' => 'required|date_format:Y-m-d',
        ];
    }
}

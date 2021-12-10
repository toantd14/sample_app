<?php

namespace Modules\Owner\Http\Requests\Parking;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMenuParkingRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'month_price' => 'required_if:month_flg,0|max:5',
            'minimum_use' => 'required_if:month_flg,0|max:1',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}

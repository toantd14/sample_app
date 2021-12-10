<?php

namespace Modules\Owner\Http\Requests\Parking;

use Illuminate\Foundation\Http\FormRequest;

class ParkingSpaceRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'parking_form' => 'required',
            'car_type' => 'required',
            'car_width' => 'required|numeric|between:0,999.99|regex:/^\d*(\.\d{1,2})?$/',
            'car_length' => 'required|numeric|between:0,999.99|regex:/^\d*(\.\d{1,2})?$/',
            'car_height' => 'required|numeric|between:0,999.99|regex:/^\d*(\.\d{1,2})?$/',
            'car_weight' => 'required|numeric|between:0,999.99|regex:/^\d*(\.\d{1,2})?$/',
            'space_symbol' => 'required|max:5',
            'space_no_from' => 'required|integer|lte:space_no_to|min:1|digits_between:1, 2',
            'space_no_to' => 'required|integer|digits_between:1, 2',
        ];

        if (request()->routeIs('slots-parking.update')) {
            $rules['space_no_from'] = 'required|integer|min:1|digits_between:1, 2';
            unset($rules['space_no_to']);
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'parking_form.required' => __('message.slot_parking.message_select'),
            'car_type.required' => __('message.slot_parking.message_select'),
            'car_width.required' => __('validation.data_required'),
            'car_length.required' => __('validation.data_required'),
            'car_height.required' => __('validation.data_required'),
            'car_weight.required' => __('validation.data_required'),
            'space_symbol.required' => __('validation.data_required'),
            'space_no_from.required' => __('validation.data_required'),
            'space_no_from.lte' => __('validation.space_no_error'),
            'space_no_to.required' => __('validation.data_required'),
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

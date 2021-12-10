<?php

namespace Modules\Owner\Http\Requests\Menu;

use Illuminate\Foundation\Http\FormRequest;

class TimeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'data' => 'required',
            'data.*.day_type' => 'required',
            'data.*.from_time' => 'required',
            'data.*.to_time' => 'required|after:from_time',
            'data.*.price' => 'required|integer|min:1',
        ];
    }

    public function messages()
    {
        return [
            'data.*.day_type.required' => __('message.menu_parking_lot.menu_time_errors'),
            'data.required' => __('message.menu_parking_lot.menu_time_errors'),
            'data.*.from_time.required' => __('message.menu_parking_lot.menu_time_errors'),
            'data.*.to_time.required' => __('message.menu_parking_lot.menu_time_errors'),
            'data.*.price.required' => __('message.menu_parking_lot.menu_time_errors'),
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

<?php

namespace Modules\Owner\Http\Requests\Menu;

use Illuminate\Foundation\Http\FormRequest;

class DayRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'day_price' => 'required_if:day_flg,0|integer|between:1,99999',
        ];
    }

    public function messages()
    {
        return [
            'day_price.required_if' => __('validation.data_required'),
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

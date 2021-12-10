<?php

namespace Modules\Owner\Http\Requests\Menu;

use Illuminate\Foundation\Http\FormRequest;

class MenuRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'month_price' => 'required_if:month_flg,0|integer|between:1,99999',
            'minimum_use' => 'required_if:month_flg,0|integer|between:1,24',
            'period_price' => 'required_if:period_flg,0|integer|between:1,99999',
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

<?php

namespace Modules\Owner\Http\Requests\Menu;

use App\Models\ParkingMenu;
use Illuminate\Foundation\Http\FormRequest;

class PeriodRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'period_week_data' => 'required_if:period_week,' . ParkingMenu::PERIOD_WEEK_FLG_ENABLE,
            'period_fromtime' => 'required_if:period_timeflg,' . ParkingMenu::PERIOD_TIME_FLG_ENABLE,
            'period_totime' => 'required_if:period_timeflg,' . ParkingMenu::PERIOD_TIME_FLG_ENABLE . '|after:period_fromtime',
            'period_fromday' => 'required_if:period_dayflg,' . ParkingMenu::PERIOD_DAY_FLG_ENABLE,
            'period_price' => 'required_if:period_flg,' .ParkingMenu::PERIOD_FLG_ENABLE . '|integer|between:1,99999',
        ];

        if (request()->get('period_dayflg') == ParkingMenu::PERIOD_DAY_FLG_ENABLE) {
            $rules['period_today'] = 'required|after:period_fromday';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'period_fromtime.required_if' => __('validation.data_required'),
            'period_totime.required_if' => __('validation.data_required'),
            'period_fromday.required_if' => __('validation.data_required'),
            'period_today.required_if' => __('validation.data_required'),
            'period_price.required_if' => __('validation.data_required'),
            'period_week_data.required_if' => __('validation.data_required'),
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

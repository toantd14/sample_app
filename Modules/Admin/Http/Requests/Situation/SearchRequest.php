<?php

namespace Modules\Admin\Http\Requests\Situation;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "year" => 'required_without_all:month,use_day_from,reservation_day_from,payment_day_from,use_day_to,reservation_day_to,payment_day_to',
            "month" => 'required_without_all:year,use_day_from,reservation_day_from,payment_day_from,use_day_to,reservation_day_to,payment_day_to',
            "use_day_from" => 'required_without_all:month,year,reservation_day_from,payment_day_from,use_day_to,reservation_day_to,payment_day_to',
            "reservation_day_from" => 'required_without_all:month,use_day_from,year,payment_day_from,use_day_to,reservation_day_to,payment_day_to',
            "payment_day_from" => 'required_without_all:month,use_day_from,reservation_day_from,year,use_day_to,reservation_day_to,payment_day_to',
            "use_day_to" => "nullable|after_or_equal:use_day_from",
            "reservation_day_to" => "nullable|after_or_equal:reservation_day_from",
            "payment_day_to" => "nullable|after_or_equal:payment_day_from",
        ];
    }

    /**
     * @return array|string[]
     */
    public function messages()
    {
        return [
            "required_without_all" => __('message.search_use_situation.required_without_all'),
            'use_day_to.after_or_equal' => __('validation.search_use_situation.use_day_validate'),
            'reservation_day_to.after_or_equal' => __('validation.search_use_situation.reservation_day_validate'),
            'payment_day_to.after_or_equal' => __('validation.search_use_situation.payment_day_validate'),
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

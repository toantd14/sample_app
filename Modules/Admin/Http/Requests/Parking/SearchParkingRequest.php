<?php

namespace Modules\Admin\Http\Requests\Parking;

use Illuminate\Foundation\Http\FormRequest;

class SearchParkingRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'municipality_name' => 'nullable|min:2',
            'created_at_from' => 'nullable|date',
            'created_at_to' => 'nullable|date|after_or_equal:created_at_from',
            'updated_at_from' => 'nullable|date',
            'updated_at_to' => 'nullable|date|after_or_equal:updated_at_from',
        ];
    }

    public function messages()
    {
        return [
            'created_at_to.after_or_equal' => __('validation.created_from_to_validate'),
            'updated_at_to.after_or_equal' => __('validation.updated_from_to_validate'),
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

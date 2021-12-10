<?php

namespace Modules\Owner\Http\Requests\Notification;

use Illuminate\Foundation\Http\FormRequest;

class StoreNotificationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "created_at" => 'required',
            "announce_period" => 'required|integer|min:1|max:127',
            "notics_title" => 'required|max:100',
            "notics_details" => 'required|min:3',
            "parking_cd" => 'required',
        ];
    }

    public function messages()
    {
        return [
            'created_at.required' => __('validation.data_required'),
            'announce_period.required' => __('validation.data_required'),
            'notics_title.required' => __('validation.data_required'),
            'parking_cd.required' => __('validation.data_required'),
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

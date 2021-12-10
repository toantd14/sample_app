<?php

namespace Modules\Owner\Http\Requests\Notification;

use Illuminate\Foundation\Http\FormRequest;

class SearchNotificationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "date_public_from" => "required_without_all:date_public_to,title,parking_cd",
            "date_public_to" => "nullable|after_or_equal:date_public_from",
            "title" => "required_without_all:date_public_from,date_public_to,parking_cd|nullable|min:2",
            "parking_cd" => "required_without_all:date_public_from,date_public_to,title",
        ];
    }

    public function messages()
    {
        return [
            'date_public_from.required_without_all' => __('validation.notification.required_without_all'),
            'date_public_to.required_without_all' => __('validation.notification.required_without_all'),
            'date_public_to.after_or_equal' => __('validation.notification.date_from_to'),
            'title.required_without_all' => __('validation.notification.required_without_all'),
            'parking_cd.required_without_all' => __('validation.notification.required_without_all'),
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

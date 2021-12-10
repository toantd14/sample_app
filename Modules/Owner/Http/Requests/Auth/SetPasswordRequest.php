<?php

namespace Modules\Owner\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class SetPasswordRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'certification_cd' => 'required',
            'password' => 'required|min:6',
        ];
    }

    public function messages()
    {
        return [
            'certification_cd' => __('validation.data_required'),
            'password.required' => __('validation.set_password.password_error'),
            'password.min' => __('validation.set_password.password_error'),
            'password.integer' => __('validation.set_password.password_error'),
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

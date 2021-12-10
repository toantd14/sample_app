<?php

namespace Modules\Api\Http\Requests\Auth;

use Modules\Api\Http\Requests\BaseRequest;

class GoogleLoginRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'idToken' => 'required'
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

    public function messages()
    {
        return [
            'lat.required' => __('validation.auth.required'),
        ];
    }
}

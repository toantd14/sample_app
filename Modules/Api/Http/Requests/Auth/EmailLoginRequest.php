<?php

namespace Modules\Api\Http\Requests\Auth;

use Illuminate\Support\Facades\Request;
use Modules\Api\Http\Requests\BaseRequest;

class EmailLoginRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email:rfc,dns',
            'password' => 'required'
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

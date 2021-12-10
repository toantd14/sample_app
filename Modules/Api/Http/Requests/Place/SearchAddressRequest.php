<?php

namespace Modules\Api\Http\Requests\Place;


use Illuminate\Foundation\Http\FormRequest;
use Modules\Api\Http\Requests\BaseRequest;

class SearchAddressRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'zipcode' => 'required|max:7',
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

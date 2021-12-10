<?php

namespace Modules\Api\Http\Requests\Place;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Api\Http\Requests\BaseRequest;

class GetAutocompleteRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'keyword' => 'required',
            'lat' => 'required|numeric',
            'lon' => 'required|numeric'
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

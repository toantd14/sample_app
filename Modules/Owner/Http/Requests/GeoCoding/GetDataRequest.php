<?php

namespace Modules\Owner\Http\Requests\GeoCoding;

use Illuminate\Foundation\Http\FormRequest;

class GetDataRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'code' => 'required|max:7',
            'prefectures' => 'required',
            'municipality' => 'required',
            'town-area' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'olc' => 'required',
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

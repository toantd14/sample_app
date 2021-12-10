<?php

namespace Modules\Api\Http\Requests\Parking;

use Modules\Api\Http\Requests\BaseRequest;

class ParkingListRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'lat' => 'required:numeric',
            'lon' => 'required:numeric',
            'radius' => 'required:numeric',
            'page' => 'required|integer|min:1',
            'pageSize' => 'required|integer|min:1',
            'sort' => 'required|integer'
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

<?php

namespace Modules\Api\Http\Requests\Review;

use Modules\Api\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'parkingID' => 'required|integer|min:1',
            'page' => 'required|integer|min:1',
            'pageSize' => 'required|integer|min:1',
        ];
    }
}

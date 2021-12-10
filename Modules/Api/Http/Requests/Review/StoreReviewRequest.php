<?php

namespace Modules\Api\Http\Requests\Review;

use Modules\Api\Http\Requests\BaseRequest;

class StoreReviewRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'parkingID' => 'required|integer',
            'satisfation' => 'required|integer',
            'location' => 'required|numeric',
            'easeStopping' => 'required|integer',
            'fee' => 'required|integer',
            'comment' => 'required'
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

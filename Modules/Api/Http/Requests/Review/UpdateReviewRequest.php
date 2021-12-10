<?php

namespace Modules\Api\Http\Requests\Review;

use Modules\Api\Http\Requests\BaseRequest;

class UpdateReviewRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'satisfation' => 'required|numeric',
            'location' => 'required|numeric',
            'easeStopping' => 'required|numeric',
            'fee' => 'required|numeric',
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

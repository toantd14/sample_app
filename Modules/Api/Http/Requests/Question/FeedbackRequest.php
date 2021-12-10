<?php

namespace Modules\Api\Http\Requests\Question;

use Modules\Api\Http\Requests\BaseRequest;

class FeedbackRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'feedback' => 'required|min:3',
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

<?php

namespace Modules\Api\Http\Requests\Question;

use Modules\Api\Http\Requests\BaseRequest;

class GetQuestiosByCategoryRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'categoryID' => 'required',
            'page' => 'required|integer|min:1',
            'pageSize' => 'required|integer|min:1',
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

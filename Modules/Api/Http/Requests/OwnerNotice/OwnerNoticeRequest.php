<?php

namespace Modules\Api\Http\Requests\OwnerNotice;

use Modules\Api\Http\Requests\BaseRequest;

class OwnerNoticeRequest extends BaseRequest
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
            'parkingID' => 'required|int|min:1',
            'page' => 'required|int|min:1',
            'pageSize' => 'required|int|min:1',
        ];
    }
}

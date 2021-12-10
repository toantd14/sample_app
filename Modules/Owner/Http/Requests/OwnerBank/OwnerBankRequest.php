<?php

namespace Modules\Owner\Http\Requests\OwnerBank;

use Illuminate\Foundation\Http\FormRequest;

class OwnerBankRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "bank_name" => "required|max:150",
            "bank_cd" => "max:4",
            "branch_name" => "required|max:150",
            "branch_cd" => "max:5",
            "account_type" => "required",
            "account_name" => "required|max:250",
            "account_kana" => "required|max:300",
            "account_no" => "nullable|digits_between:4,15",
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

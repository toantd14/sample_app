<?php

namespace Modules\Admin\Http\Requests\OwnerBank;

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
            "bank_cd" => "required|max:4",
            "branch_name" => "required|max:150",
            "branch_cd" => "required|max:5",
            "account_type" => "required",
            "account_name" => "required|max:250",
            "account_kana" => "required|max:300",
            "account_no" => "nullable|digits_between:4,15",
        ];
    }

    public function messages()
    {
        return [
            'bank_name.required' => __('validation.data_required'),
            'branch_cd.required' => __('validation.data_required'),
            'required.required' => __('validation.data_required'),
            'branch_name.required' => __('validation.data_required'),
            'account_type.required' => __('validation.data_required'),
            'account_name.required' => __('validation.data_required'),
            'account_kana.required' => __('validation.data_required'),
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

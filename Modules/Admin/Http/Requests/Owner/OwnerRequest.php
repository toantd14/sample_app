<?php

namespace Modules\Admin\Http\Requests\Owner;

use App\Rules\TelNo;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class OwnerRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'kubun' => 'required|bool',
            'mgn_flg' => 'required|bool',
            'name_c' => 'required|max:100',
            'person_man' => 'exclude_if:kubun,0|required|max:50',
            'department' => 'exclude_if:kubun,0|max:50',
            'hp_url' => 'exclude_if:kubun,0|max:150',
            'mail_add' => 'required|max:150|email:rfc,dns',
            'zip_cd' => 'required',
            'prefectures' => 'required|max:200',
            'municipality_name' => 'required|max:200',
            'townname_address' => 'required|max:200',
            'building_name' => 'max:200',
            'tel_no' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', new TelNo],
            'fax_no' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/|min:9|max:12',
        ];
    }

    public function messages()
    {
        return [
            'kubun.required' => __('validation.data_required'),
            'mgn_flg.required' => __('validation.data_required'),
            'name_c.required' => __('validation.data_required'),
            'person_man.required' => __('validation.data_required'),
            'mail_add.required' => __('validation.data_required'),
            'zip_cd.required' => __('validation.data_required'),
            'prefectures.required' => __('validation.data_required'),
            'municipality_name.required' => __('validation.data_required'),
            'tel_no.required' => __('validation.data_required'),
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

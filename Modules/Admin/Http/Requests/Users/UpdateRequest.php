<?php

namespace Modules\Admin\Http\Requests\Users;

use App\Models\MstUser;
use App\Rules\TelNo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'name_c.0' => 'required_if:kubun,0|max:100',
            'name_c.1' => 'required_if:kubun,0|max:100',
            'corporate_name' => 'required_if:kubun, ==, 1|max:100',
            'department' => 'exclude_if:kubun,0|max:50',
            'mail_add' => 'required_if:facebook_id, google_id, line_id|max:150|email:rfc,dns|unique:mst_user,mail_add,' . $this->user_cd . ',user_cd',
            'zip_cd' => 'required|max:7',
            'prefectures' => 'required',
            'municipality_name' => 'required|max:200',
            'townname_address' => 'required|max:200',
            'building_name' => 'max:200',
            'tel_no' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', new TelNo],
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

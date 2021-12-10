<?php

namespace Modules\Admin\Http\Requests\Parking;

use App\Rules\TelNo;
use Illuminate\Foundation\Http\FormRequest;

class CreateParkingRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'owner_cd' => 'required',
            'mgn_flg' => 'required',
            'name' => 'required',
            'code' => 'required|max:7',
            'prefectures' => 'required',
            'municipality' => 'required',
            'town_area' => 'required',
            'latitude' => ['required', 'regex:/^(\-?([0-8]?[0-9](\.\d+)?|90(.[0]+)?))$/'],
            'longitude' => ['required', 'regex:/^(\-?([1]?[0-7]?[0-9](\.\d+)?|180((.[0]+)?)))$/'],
            'tel_no' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', new TelNo],
            'fax_no' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/|min:9|max:12',
            'sales_start_time' => 'exclude_if:sales_division,on|required',
            'sales_end_time' => 'exclude_if:sales_division,on|required|after:sales_start_time',
            'lu_start_time' => 'exclude_if:lu_division,on|required',
            'lu_end_time' => 'exclude_if:lu_division,on|required|after:lu_start_time',
            'video.*' => 'nullable|file|mimetypes:video/avi,video/mpeg,video/quicktime,video/mp4|max:' . config('constants.IMAGES.MAX_LENGTH'),
            'image.*' => 'nullable|mimes:jpeg,png,bmp,svg,webp'
        ];
    }

    public function messages()
    {
        return [
            'owner_cd.required' => __('validation.parkinglot.required'),
            'mgn_flg.required' => __('validation.parkinglot.required'),
            'name.required' => __('validation.parkinglot.required'),
            'code.required' => __('validation.parkinglot.required'),
            'code.size' => __('validation.parkinglot.required'),
            'prefectures.required' => __('validation.parkinglot.required'),
            'municipality.required' => __('validation.parkinglot.required'),
            'town_area.required' => __('validation.parkinglot.required'),
            'longitude.required' => __('validation.parkinglot.required'),
            'latitude.required' => __('validation.parkinglot.required'),
            'tel_no.required' => __('validation.parkinglot.required'),
            'sales_start_time.required' => __('validation.parkinglot.required'),
            'sales_end_time.required' => __('validation.parkinglot.required'),
            'sales_end_time.after' => __('validation.parkinglot.format_err'),
            'lu_start_time.required' => __('validation.parkinglot.required'),
            'lu_end_time.required' => __('validation.parkinglot.required'),
            'video.*.max' => __('validation.parkinglot.format_err'),
            'video.*.file' => __('validation.parkinglot.format_err'),
            'video.*.mimetypes' => __('validation.parkinglot.format_err'),
            'image.*.mimes' => __('validation.parkinglot.format_err'),
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

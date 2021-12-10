<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class TelNo implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return (preg_match('/^09|^08|^05/', $value))
        ? strlen($value) == 11
        : strlen($value) == 10;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '電話番号は１０〜１１桁の数字とハイフンを入力してください。';
    }
}

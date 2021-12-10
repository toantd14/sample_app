<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class EndTime implements Rule
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
        if (preg_match('/^$|^(([01][0-9])|(2[0-4])):[0-5][0-9]$/', $value)) {
            $a = explode(":", $value);
            if ($a[0] == 24 && $a[1] > 0) {
                return false;
            }

            return true;
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '予約開始時間は\"H:i\"書式と一致していません。';
    }
}

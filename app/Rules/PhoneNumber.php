<?php

namespace App\Rules;

use App\User;
use Illuminate\Contracts\Validation\Rule;

class PhoneNumber implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $formatted_phone = phone($value, 'GB');

        if (count(User::where('phone_number', $formatted_phone)->exists())) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'That phone number has already been recorded.';
    }
}

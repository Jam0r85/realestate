<?php

namespace App\Rules;

use App\BankAccount;
use Illuminate\Contracts\Validation\Rule;

class BankAccountNumber implements Rule
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
        $accounts = BankAccount::select('account_number','sort_code')->get();

        foreach ($accounts as $account) {
            if ($account->sort_code == request()->input('sort_code')) {
                if ($account->account_number == $value) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'There is already an account with that number assigned to that bank sort code.';
    }
}

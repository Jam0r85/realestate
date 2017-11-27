<?php

namespace App\Http\Requests;

use App\Tenancy;
use Illuminate\Foundation\Http\FormRequest;

class BaseTenancyRequest extends FormRequest
{
    /**
     * Configure the validation instance.
     *
     * @param \Illuminate\Validation\Validator $$validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            // Get the tenancy.
            $tenancy = Tenancy::findOrFail($this->tenancy_id);

            // Make sure that the tenancy has a current rent amount.
            if (!$tenancy->currentRent) {
                $validator->errors()->add('none', 'This tenancy does not have a rent amount set');
            }

            // Make sure the tenancy has a next statement date.
            if (!$tenancy->present()->nextStatementStartDate) {
                $validator->errors()->add('none', 'This tenancy does not have next statement date');
            }

        });
    }
}

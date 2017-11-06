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

            $this->tenancy = Tenancy::findOrFail($this->tenancy_id);

            // Make sure that the tenancy has a current rent amount.
            if (!$this->tenancy->currentRent) {
                $validator->errors()->add('none', 'This tenancy does not have a rent amount set');
            }

            // Make sure the tenancy has a next statement date.
            if (!$this->tenancy->nextStatementDate()) {
                $validator->errors()->add('none', 'This tenancy does not have next statement date');
            }

        });
    }
}

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

            if (!$this->tenancy->currentRent) {
                $validator->errors()->add('none', 'This tenancy does not have a rent amount set');
            }

            if (!$this->tenancy->nextStatementDate()) {
                $validator->errors()->add('none', 'This tenancy does not have next statement date');
            }

        });
    }
}

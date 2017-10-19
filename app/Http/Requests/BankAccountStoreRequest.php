<?php

namespace App\Http\Requests;

use App\Rules\BankAccountNumber;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BankAccountStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'bank_name' => 'required',
            'account_name' => 'required',
            'account_number' => [
                'required',
                new BankAccountNumber
            ],
            'sort_code' => 'required'
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BankAccountDestroyRequest extends FormRequest
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
            'confirmation' => [
                'required',
                'in:' . $this->route()->parameter('id')
            ]
        ];
    }

    /**
     * Get the validation rule messages that apply to the request.
     * 
     * @return array
     */
    public function messages()
    {
        return [
            'confirmation.required' => 'Please enter the ID of the bank account to confirm you want to archive it',
            'confirmation.in' => 'The ID provided does not match the ID of this bank account'
        ];
    }
}

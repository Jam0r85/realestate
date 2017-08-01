<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StatementPaymentSentRequest extends FormRequest
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
            'payment_id' => 'required'
        ];
    }

    /**
     * Get the validation messages that apply to the rules.
     * 
     * @return array
     */
    public function messages()
    {
        return [
            'payment_id.required' => 'Please select at least one payment to mark as sent'
        ];
    }
}

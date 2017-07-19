<?php

namespace App\Http\Requests;

use App\Rules\UniqueInvoiceNumber;
use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceRequest extends FormRequest
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
            'property_id' => 'required',
            'invoice_group_id' => 'required',
            'number' => new UniqueInvoiceNumber()
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
            'property_id.required' => 'You must select a property for this invoice.'
        ];
    }
}

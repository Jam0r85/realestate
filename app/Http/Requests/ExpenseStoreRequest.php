<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExpenseStoreRequest extends FormRequest
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
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     * 
     * @return array
     */
    public function messages()
    {
        return [
            'property_id.required' => 'Please select a property for this expense',
            'files.mimes' => 'The invoice(s) must be either .jpeg, .png or .pdf type'
        ];
    }
}

<?php

namespace App\Http\Requests;

use App\Invoice;
use App\InvoiceGroup;
use App\Rules\UniqueInvoiceNumber;
use Illuminate\Foundation\Http\FormRequest;

class InvoiceStoreRequest extends FormRequest
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
            'invoice_group_id' => 'required|numeric',
            'property_id' => 'numeric'
        ];
    }

    /**
     * Configure the validator instance.
     * 
     * @param \Illuminate\Validation\Validator $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            $next_number = InvoiceGroup::findOrFail($this->invoice_group_id)->next_number;
            $invoice_number = $this->number ?? $next_number;

            $invoices = Invoice::where('number', $invoice_number)->where('invoice_group_id', $this->invoice_group_id)->get();

            if (count($invoices)) {
                $validator->errors()->add('none', 'Invoice with that number already exists for that group');
            }

        });
    }
}

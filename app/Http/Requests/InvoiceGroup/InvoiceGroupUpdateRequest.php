<?php

namespace App\Http\Requests\InvoiceGroup;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceGroupUpdateRequest extends FormRequest
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
            'name' => 'required|unique:invoice_groups,name,' . $this->id,
            'next_number' => 'required|numeric',
            'format' => 'required',
            'branch_id' => 'required|sometimes'
        ];
    }
}

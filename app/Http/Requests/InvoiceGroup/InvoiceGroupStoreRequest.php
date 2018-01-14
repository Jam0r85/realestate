<?php

namespace App\Http\Requests\InvoiceGroup;

use App\Rules\UniqueName;
use Illuminate\Foundation\Http\FormRequest;

class InvoiceGroupStoreRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:invoice_groups',
            'next_number' => 'required|numeric|min:1',
            'format' => 'required|string',
            'branch_id' => 'required|numeric'
        ];
    }
}

<?php

namespace App\Http\Requests;

use App\Rules\UniqueName;
use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceGroupRequest extends FormRequest
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
            'name' => [
                'required',
                new UniqueName('invoice_groups','name')
            ],
            'next_number' => 'required|numeric',
            'format' => 'required',
            'branch_id' => 'required'
        ];
    }
}

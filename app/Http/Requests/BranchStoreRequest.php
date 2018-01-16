<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BranchStoreRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:branches',
            'email' => 'required|string|email|max:255|unique:branches',
            'phone_number' => 'required|string|max:255|unique:branches',
            'address' => 'required|string|unique:branches',
            'vat_number' => 'string|nullable|unique:branches'
        ];
    }
}
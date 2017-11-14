<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TenancyRentStoreRequest extends FormRequest
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
            'tenancy_id' => 'required|numeric',
            'starts_at' => 'required',
            'amount' => 'required|numeric'
        ];
    }
}

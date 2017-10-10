<?php

namespace App\Http\Requests;

use App\TaxRate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class RestoreTaxRateRequest extends FormRequest
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
        $name = TaxRate::onlyTrashed()->find(Request::segment(3))->name;

        return [
            'confirmation' => 'required|in:' . $name
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
            'confirmation.in' => 'The entered text does not match the required tax rate name.'
        ];
    }
}

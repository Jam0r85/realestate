<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOldStatementRequest extends FormRequest
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
            'created_at' => 'required|date_format:Y-m-d',
            'period_start' => 'required|date_format:Y-m-d|unique:statements,period_start',
            'period_end' => 'required|date_format:Y-m-d|unique:statements,period_end',
            'amount',
            'invoice_number' => 'required|unique:invoices,number'
        ];
    }
}

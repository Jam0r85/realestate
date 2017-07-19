<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCalendarRequest extends FormRequest
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
            'name' => 'required',
            'branch_id' => 'required'
        ];
    }

    /**
     * Get the validation messages for the request.
     * 
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'The calendar name is required',
            'branch_id.required' => 'The calendar requires a branch'
        ];
    }
}

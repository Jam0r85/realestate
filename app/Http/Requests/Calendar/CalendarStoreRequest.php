<?php

namespace App\Http\Requests\Calendar;

use Illuminate\Foundation\Http\FormRequest;

class CalendarStoreRequest extends FormRequest
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
            'name' => 'required|string|max:191|unique:calendars',
            'branch_id' => 'required|int'
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

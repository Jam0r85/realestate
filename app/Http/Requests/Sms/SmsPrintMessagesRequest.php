<?php

namespace App\Http\Requests\Sms;

use Illuminate\Foundation\Http\FormRequest;

class SmsPrintMessagesRequest extends FormRequest
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
            'sms_print_ids' => 'required'
        ];
    }
}

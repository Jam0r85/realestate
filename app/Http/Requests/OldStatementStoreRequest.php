<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OldStatementStoreRequest extends FormRequest
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
            'period_start' => 'required|date_format:Y-m-d',
            'period_end' => 'required|date_format:Y-m-d',
            'amount'
        ];
    }

    /**
     * Configure the validator instance.
     * 
     * @param \Illuminate\Validator\Validator $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (!get_setting('invoice_default_group')) {
                $validator
                    ->errors()
                    ->add('none', 'No default invoice group has been set, please do this in settings.');
            }
        });
    }
}

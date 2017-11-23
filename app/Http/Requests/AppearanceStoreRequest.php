<?php

namespace App\Http\Requests;

use App\Appearance;
use Illuminate\Foundation\Http\FormRequest;

class AppearanceStoreRequest extends FormRequest
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
            'section_id' => 'required|numeric',
            'status_id' => 'required|numeric',
            'property_id' => 'required|numeric',
            'price' => 'required|numeric',
            'summary' => 'required',
            'description' => 'required'
        ];
    }

    /**
     * Configure the validator instance.
     * 
     * @param  \Illuminate\Validation\Validator  $validator
     * @return  void
     */ 
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->checkDuplicate()) {
                $validator->errors()->add('none', 'An appearance already exists with that property in that section');
            }
        });
    }

    /**
     * Check whether an existing appearance already exists for this property and section.
     * 
     * @return  boolean
     */
    private function checkDuplicate()
    {
        if (Appearance::where('section_id', $this->section_id)->where('property_id', $this->property_id)->exists()) {
            return true;
        } else {
            return false;
        }
    }
}

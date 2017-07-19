<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBranchRoleRequest extends FormRequest
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
                'unique'
            ],
            'branch_id' => 'required',
            'permission_id[]' => 'required'
        ];
    }

    /**
     * Get the validation messages that apply to the rules.
     * 
     * @return array
     */
    public function messages()
    {
        return [
            'permission_id[].required' => 'Please select at least one permission for this role'
        ];
    }
}

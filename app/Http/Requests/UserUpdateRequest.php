<?php

namespace App\Http\Requests;

use App\Rules\PhoneNumber;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class UserUpdateRequest extends FormRequest
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
            'first_name' => 'sometimes|required_without_all:company_name,last_name',
            'last_name' => 'sometimes|required_without_all:company_name,first_name',
            'company_name' => [
                'sometimes',
                'required_without_all:first_name,last_name',
                'nullable',
                'unique:users,company_name,' . Request::segment(2)
            ],
            'phone_number' => [
                'nullable',
                new PhoneNumber
            ]
        ];
    }
}

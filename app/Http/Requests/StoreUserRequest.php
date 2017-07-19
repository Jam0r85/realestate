<?php

namespace App\Http\Requests;

use App\Rules\UniqueWithSoftDeletes;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'company_name' => 'required_without_all:first_name,last_name',
            'first_name' => 'required_without:company_name,last_name',
            'last_name' => 'required_without_all:first_name,company_name',
            'email' => new UniqueWithSoftDeletes('users','email')
        ];
    }
}

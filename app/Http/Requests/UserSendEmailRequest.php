<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class UserSendEmailRequest extends FormRequest
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
            'subject' => 'required',
            'message' => 'required'
        ];
    }

    /**
     * @param  \Illuminate\Validation\Validator
     * @return void
     */
    public function withValidator($validator)
    {
        $user = User::findOrFail(Request::segment(2));

        $validator->after(function ($validator) use ($user) {
            if (!$user->email) {
                $validator->errors()->add('none', 'User does not have a valid e-mail address');
            }
        });
    }
}

<?php

namespace App\Http\Requests;

use App\Gas;
use Illuminate\Foundation\Http\FormRequest;

class GasInspectionStoreRequest extends FormRequest
{
    /**
     * Handle a failed authorization attempt.
     *
     * @return void
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    protected function failedAuthorization()
    {
        throw new AuthorizationException('This action is unauthorized.');
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Gas::where('property_id', request()->input('property_id'))->exists()) {
            return false;
        }

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
            'expires_on' => 'required',
            'property_id' => 'required|numeric'
        ];
    }
}

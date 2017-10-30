<?php

namespace App\Http\Requests;

use App\Expense;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class ExpenseDeleteRequest extends FormRequest
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
        $name = Expense::find(Request::segment(2))->name;

        return [
            'confirmation' => 'required|in:' . $name
        ];
    }
}

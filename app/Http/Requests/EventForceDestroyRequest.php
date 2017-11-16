<?php

namespace App\Http\Requests;

use App\Event;
use Illuminate\Foundation\Http\FormRequest;

class EventForceDestroyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $event = Event::onlyTrashed()->find($this->route()->parameter('id'));
        
        return $this->user()->id == $event->user_id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'confirmation' => [
                'required',
                'in:' . $this->route()->parameter('id')
            ]
        ];
    }
}

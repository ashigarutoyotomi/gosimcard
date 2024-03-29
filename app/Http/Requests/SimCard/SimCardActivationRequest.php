<?php

namespace App\Http\Requests\SimCard;

use Illuminate\Foundation\Http\FormRequest;

class SimCardActivationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'available_days' => 'required|integer',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'number' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'number.required' => 'Please enter correct Activation Code',
            'start_date.required' => 'Please select start date'
        ];
    }
}

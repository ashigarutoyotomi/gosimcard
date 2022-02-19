<?php

namespace App\Http\Requests\SimCard\SimCardActivation;

use Illuminate\Foundation\Http\FormRequest;

class CreateSimCardActivationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'iccid' => 'required|string|exists:sim_cards',
            'available_days' => 'required|integer',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'email' => 'nullable',
        ];
    }

    public function messages(): array
    {
        return [
            'iccid.required' => 'Please enter correct Activation Code',
            'iccid.exists' => 'Sim card with this ICCID not found',
            'start_date.required' => 'Please select start date'
        ];
    }
}

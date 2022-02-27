<?php

namespace App\Http\Requests\SimCard\SimCardRecharge;

use Illuminate\Foundation\Http\FormRequest;

class RechargeSimCardRechargeRequest extends FormRequest
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
            'payment_intent' => 'required|string',
            'payment_intent_client_secret' => 'required|string',
        ];
    }
}

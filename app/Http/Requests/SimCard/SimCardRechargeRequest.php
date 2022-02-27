<?php

namespace App\Http\Requests\SimCard;

use Illuminate\Foundation\Http\FormRequest;

class SimCardRechargeRequest extends FormRequest
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
            'iccid' => 'required|string',
            'start_date' => 'required|string',
            'end_date' => 'required|string',
            'available_days' => 'required|integer',
            'status' => 'required|integer',
            'user_id' => 'required|integer',
            'price' => 'required|integer',
            'email' => 'nullable|email',
            'sim_card_id' => 'required|integer',
        ];
    }
}

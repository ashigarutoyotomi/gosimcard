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
            'available_days' => 'require|integer',
            'start_date' => 'nullable|integer',
            'user_id' => 'required|integer',
            'end_date'=>'required',
            'sim_card_id'=>'required'
        ];
    }
}

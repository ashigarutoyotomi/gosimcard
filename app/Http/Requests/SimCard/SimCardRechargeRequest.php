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
            'number' => 'required|string',
            'status' => 'required|integer',
            'sim_card_id' => 'required|integer',
            'days'=>'required|integer',
            'email'=>'nullable|email',
            'user_id'=>'required|integer'
        ];
    }
}

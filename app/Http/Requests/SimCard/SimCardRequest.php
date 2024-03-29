<?php

namespace App\Http\Requests\SimCard;

use Illuminate\Foundation\Http\FormRequest;

class SimCardRequest extends FormRequest
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
            'days' => 'nullabe|integer',
            'user_id' => 'nullable|integer',
            'status' => 'nullable|integer'
        ];
    }
}

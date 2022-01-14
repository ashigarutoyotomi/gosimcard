<?php

namespace App\Domains\SimCard\DTO\SimCardDTO;

use App\Http\Requests\SimCard\SimCardRechargeRequest;
use Spatie\DataTransferObject\DataTransferObject;

class UpdateSimCardRechargeData extends DataTransferObject
{
    public int $sim_number;
    public int $status;
    public string $email;
    public int $sim_card_id;
    public int $days;

    public static function fromRequest(int $simcardRechargeId,
        SimCardRechargeRequest $request) : UpdateSimCardRechargeData {
        $data = [
            'id' => $simcardRechargeId,
            'days' => (int)$request->get('days'),
            'status' => (int) $request->get('status'),
            'email'=> $request->get('email'),
            'sim_card_id'=>(int)$request->get('sim_card_id'),
            'sim_number'=>$request->get('sim_number')
        ];        
        return new self($data);
    }
}

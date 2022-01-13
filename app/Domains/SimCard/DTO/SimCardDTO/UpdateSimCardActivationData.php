<?php

namespace App\Domains\SimCard\DTO\SimCardDTO;

use App\Http\Requests\SimCard\SimCardActivationRequest;
use Spatie\DataTransferObject\DataTransferObject;

class UpdateSimCardActivationData extends DataTransferObject
{
    public int $start_date;
    public int $end_date;
    public int $user_id;
    public int $sim_card_id;
    public int $avaliable_days;

    public static function fromRequest(int $simcardId,
        SimCardActivationRequest $request) : UpdateSimCardActivationData {
        $data = [
            'id' => $simcardId,
            'available_days' => (int)$request->get('available_days'),
            'start_date' => (int) $request->get('start_date'),
            'end_date'=>(int) $request->get('end_date'),
            'user_id'=>(int)$request->get('user_id'),
            'sim_card_id'=>(int)$request->get('sim_card_id')
        ];        
        return new self($data);
    }
}

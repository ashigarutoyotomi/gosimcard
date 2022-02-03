<?php

namespace App\Domains\SimCard\DTO\SimCardDTO;

use App\Http\Requests\SimCard\SimCardRechargeRequest;
use Spatie\DataTransferObject\DataTransferObject;

class UpdateSimCardRechargeData extends DataTransferObject
{
    public int $id;
    public string $number;
    public int $status;
    public ?string $email;
    public int $sim_card_id;
    public int $days;

    public static function fromRequest(
        int $simcardRechargeId,
        SimCardRechargeRequest $request
    ): UpdateSimCardRechargeData {
        $data = [
            'id' => (int)$simcardRechargeId,
            'days' => (int)$request->get('days'),
            'status' => (int) $request->get('status'),
            'email' => $request->email,
            'sim_card_id' => (int)$request->get('sim_card_id'),
            'number' => (string)$request->get('number')
        ];
        return new self($data);
    }
}

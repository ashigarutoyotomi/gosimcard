<?php

namespace App\Domains\SimCard\DTO\SimCardDTO;

use App\Http\Requests\SimCard\SimCardActivationRequest;
use Spatie\DataTransferObject\DataTransferObject;

class CreateSimCardActivationData extends DataTransferObject
{
    public int $available_days;
    public string $end_date;
    public string $start_date;
    public ?int $user_id;
    public int $sim_card_id;
    public ?string $number;
    public ?int $status;

    public static function fromRequest(SimCardActivationRequest $request): CreateSimCardActivationData
    {
        $data = [
            'end_date' => $request->end_date,
            'start_date' =>  $request->start_date,
            'user_id' => $request->user_id,
            'available_days' => $request->available_days,
            'sim_card_id' => $request->sim_card_id,
            'number' => $request->number,
        ];
        return new self($data);
    }
}

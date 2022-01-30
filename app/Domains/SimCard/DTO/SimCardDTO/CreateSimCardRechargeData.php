<?php

namespace App\Domains\SimCard\DTO\SimCardDTO;

use App\Http\Requests\SimCard\SimCardRechargeRequest;
use Spatie\DataTransferObject\DataTransferObject;

class CreateSimCardRechargeData extends DataTransferObject
{
    public string $number;
    public ?string $email;
    public ?int $days;
    public ?int $status;
    public int $sim_card_id;
    public int $user_id;

    public static function fromRequest(SimCardRechargeRequest $request): CreateSimCardRechargeData
    {
        $data = [
            'number' =>  $request->number,
            'days' =>  $request->days,
            'user_id' => $request->user_id,
            'status' => $request->status,
            'email' => $request->email,
            'sim_card_id' => $request->sim_card_id
        ];
        return new self($data);
    }
}

<?php

namespace App\Domains\SimCard\DTO\SimCardDTO;

use App\Domains\SimCard\Models\SimCardActivation;
use App\Http\Requests\SimCard\SimCardActivation\CreateSimCardActivationRequest;
use App\Http\Requests\SimCard\SimCardRecharge\SimCardRechargeRequest;
use Spatie\DataTransferObject\DataTransferObject;

class CreateSimCardRechargeData extends DataTransferObject
{
    public string $iccid;
    public string $start_date;
    public string $end_date;
    public int $available_days;
    public int $status;
    public ?string $email;
    public int $sim_card_id;
    public ?int $user_id;
    public float $price;

    public static function fromRequest(SimCardRechargeRequest $request, int $simCardId): CreateSimCardRechargeData
    {
        $data = [
            'iccid' => $request->get('iccid'),
            'start_date' =>  $request->get('start_date'),
            'end_date' => $request->get('end_date'),
            'available_days' => $request->get('available_days'),
            'sim_card_id' => $simCardId,
            'status' => SimCardActivation::STATUS_NEW,
            'email' => $request->get('email'),
            'price' => (float)$request->get('price'),
        ];

        return new self($data);
    }
}

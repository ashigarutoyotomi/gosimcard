<?php

namespace App\Domains\SimCard\DTO\SimCardDTO;

use App\Http\Requests\SimCard\SimCardRecharge\RechargeSimCardRechargeRequest;
use Spatie\DataTransferObject\DataTransferObject;

class RechargeSimCardRechargeData extends DataTransferObject
{
    public int $id;
    public string $payment_intent;
    public string $payment_intent_client_secret;

    public static function fromRequest(RechargeSimCardRechargeRequest $request, int $simCardRechargeId): RechargeSimCardRechargeData
    {
        $data = [
            'id' => $simCardRechargeId,
            'payment_intent' => $request->get('payment_intent'),
            'payment_intent_client_secret' => $request->get('payment_intent_client_secret'),
        ];

        return new self($data);
    }
}

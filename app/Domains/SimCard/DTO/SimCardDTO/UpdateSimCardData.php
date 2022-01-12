<?php

namespace App\Domains\SimCard\DTO\SimCardDTO;

use App\Http\Requests\SimCard\SimCardRequest;
use Spatie\DataTransferObject\DataTransferObject;

class UpdateSimCardData extends DataTransferObject
{
    public int $days;
    public string $number;
    public int $user_id;
    public int $status;

    public static function fromRequest(int $simcardId,
        SimCardRequest $request) : UpdateSimCardData {
        $data = [
            'id' => $simcardId,
            'number' => $request->get('number'),
            'days' => (int) $request->get('days'),
            'status'=>(int) $request->get('status'),
            'user_id'=>(int)$request->get('user_id')
        ];        
        return new self($data);
    }
}

<?php

namespace App\Domains\SimCard\DTO\SimCardDTO;

use App\Http\Requests\SimCard\CreateSimCardRequest;
use App\Http\Requests\SimCard\SimCardRequest;
use Illuminate\Support\Facades\Auth;
use Spatie\DataTransferObject\DataTransferObject;

class CreateSimCardData extends DataTransferObject
{
    public string $iccid;
    public int $valid_days;
    public int $expiration_days;
    public int $creator_id;

    public static function fromRequest(CreateSimCardRequest $request): CreateSimCardData
    {
        $user = Auth::user();

        $data = [
            'iccid' => $request->iccid,
            'valid_days' => (int)$request->valid_days,
            'expiration_days' => (int)$request->expiration_days,
            'creator_id' => $user->id,
        ];

        return new self($data);
    }
}

<?php
namespace App\Domains\SimCard\DTO\SimCardDTO;

use App\Http\Requests\SimCard\SimCardRequest;
use Spatie\DataTransferObject\DataTransferObject;

class CreateSimCardData extends DataTransferObject
{
    public int $user_id;
    public string $number;
    public int $days;
    public int $status;

    public static function fromRequest(SimCardRequest $request) : CreateSimCardData
    {
        $data = [
            'number' => $request->number,
            'days' => (int) $request->days,
            'user_id'=>(int)$request->user_id,
            'status'=>(int)$request->status
        ];        
        return new self($data);
    }
}

<?php
namespace App\Domains\SimCard\DTO\SimCardDTO;

use App\Http\Requests\SimCard\SimCardRechargeRequest;
use Spatie\DataTransferObject\DataTransferObject;

class CreateSimCardRechargeData extends DataTransferObject
{
    public string $sim_number;
    public string $email;
    public int $days;
    public int $status;
    public int $sim_card_id;

    public static function fromRequest(SimCardRechargeRequest $request) : CreateSimCardRechargeData
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

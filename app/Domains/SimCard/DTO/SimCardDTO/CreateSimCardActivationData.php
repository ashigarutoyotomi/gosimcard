<?php
namespace App\Domains\SimCard\DTO\SimCardDTO;

use App\Http\Requests\SimCard\SimCardActivationRequest;
use Spatie\DataTransferObject\DataTransferObject;

class CreateSimCardActivationData extends DataTransferObject
{
    public int $available_days;
    public int $end_date;
    public int $start_date;
    public int $user_id;
    public int $sim_card_id;    

    public static function fromRequest(SimCardActivationRequest $request) : CreateSimCardActivationData
    {
        $data = [
            'end_date' => (int)$request->end_date,
            'start_date' => (int) $request->start_date,
            'user_id'=>(int)$request->user_id,
            'available_days'=>(int)$request->available_days,
            'sim_card_id'=>$request->sim_card_id
        ];        
        return new self($data);
    }
}

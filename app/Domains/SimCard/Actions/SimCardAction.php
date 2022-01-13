<?php

namespace App\Domains\SimCard\Actions;

use App\Domains\SimCard\DTO\SimCardDTO\CreateSimCardData;
use App\Domains\SimCard\DTO\SimCardDTO\UpdateSimCardData;
use App\Domains\SimCard\Gateways\SimCardGateway;
use App\Domains\SimCard\Models\SimCard;

class SimCardAction
{
    public function create(CreateSimCardData $data)
    {
        return SimCard::create($data->toArray());
    }
    public function update(UpdateSimCardData $data)
    {
        $simcard = (new SimCardGateway)->getById($data->id);
        abort_unless((bool) $simcard, 404, "Simcard not found");
        $simcard->number = $data->number;
        $simcard->days = $data->days;
        $simcard->status = $data->status;
        $simcard->user_id = $data->user_id;
        $simcard->save();
        return $simcard;
    }
    public function delete(int $simcardId)
    {
        $simcard = (new SimcardGateway)->getById($simcardId);
        abort_unless((bool) $simcard, 404, "Simcard not found");
        $simcard->delete();
        return $simcard;
    }

}

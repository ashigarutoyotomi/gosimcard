<?php

namespace App\Domains\SimCard\Actions;

use App\Domains\SimCard\DTO\SimCardDTO\CreateSimCardData;
use App\Domains\SimCard\DTO\SimCardDTO\UpdateSimCardData;
use App\Domains\SimCard\Gateways\SimCardGateway;
use App\Domains\SimCard\Models\SimCard;

// use Illuminate\Support\Facades\Storage;

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
        $simcard->name = $data->name;
        $simcard->quantity = $data->quantity;
        // if (!$data->image_src) {
        //     Storage::delete($simcard->image_src);
        // }
        $simcard->image_src = $data->image_src;
        $simcard->save();
        return $simcard;
    }
    public function delete(int $simcardId)
    {
        $simcard = (new SimcardGateway)->getById($simcardId);
        abort_unless((bool) $simcard, 404, "Simcard not found");
        // if ($simcard->image_src) {
        //     Storage::delete($simcard->image_src);
        // }
        $simcard->delete();
        return $simcard;
    }

}

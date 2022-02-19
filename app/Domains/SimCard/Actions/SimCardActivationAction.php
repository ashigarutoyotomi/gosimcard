<?php

namespace App\Domains\SimCard\Actions;

use App\Domains\SimCard\Models\SimCard;
use App\Domains\SimCard\DTO\SimCardDTO\CreateSimCardActivationData;
use App\Domains\SimCard\DTO\SimCardDTO\UpdateSimCardActivationData;
use App\Domains\SimCard\Gateways\SimCardActivationGateway;
use App\Domains\SimCard\Models\SimCardActivation;

class SimCardActivationAction
{
    public function create(CreateSimCardActivationData $data)
    {
        return SimCardActivation::create($data->toArray());
    }

    public function update(UpdateSimCardActivationData $data)
    {
        $simCard = (new SimCardActivationGateway)->getById($data->id);
        abort_unless((bool) $simCard, 404, "Sim card not found");

        $simActivations = [
            'start_date' => $simCard->start_date,
            'end_date'=>$simCard->end_date,
            'sim_card_id' => $simCard->sim_card_id,
            'status'=>$simCard->status,
            'available_days'=>$simCard->available_days,
            'user_id'=>$simCard->user_id
        ];

        $simActivation = SimCardActivation::find($data->id);
        $simActivation->sim_card_id = $simActivations['sim_card_id'];
        $simActivation->user_id = $simActivations['user_id'];
        $simActivation->start_date= $simActivations['start_date'];
        $simActivation->end_date = $simActivations['end_date'];
        $simActivation->status = $simActivations['status']?$simActivations['status']:SimCard::STATUS_NEW;
        $simActivation->available_days = $simActivations['available_days'];
        $simActivation->save();
        return $simActivation;
    }

    public function delete(int $simcardActivationId)
    {
        $simcardActivation = (new SimcardActivationGateway)->getById($simcardActivationId);
        abort_unless((bool) $simcardActivation, 404, "Simcard not found");
        $simcardActivation->delete();
        return $simcardActivation;
    }

}

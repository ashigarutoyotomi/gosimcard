<?php

namespace App\Domains\SimCard\Actions;

use App\Domains\SimCard\DTO\SimCardDTO\CreateSimCardActivationData;
use App\Domains\SimCard\DTO\SimCardDTO\UpdateSimCardActivationData;
use App\Domains\SimCard\Gateways\SimCardActivationGateway;
use App\Domains\SimCard\Models\SimActivation;

class SimCardActivationAction
{
    public function create(CreateSimCardActivationData $data)
    {
        return SimActivation::create($data->toArray());
    }
    public function update(UpdateSimCardActivationData $data)
    {
        $simcard = (new SimCardActivationGateway)->getById($data->id);
        abort_unless((bool) $simcard, 404, "Simcard not found");
        $simActivations = [
            'start_date' => $simcard->start_date,
            'end_date'=>$simcard->end_date,
            'sim_card_id'=>$simcard->sim_card_id,
            'status'=>$simcard->status,
            'available_days'=>$simcard->available_days,
            'sim_card_id'=>$simcard->sim_card_id,
            'user_id'=>$simcard->user_id
            ];
        $simActivation = new SimActivation;
        $simActivation->sim_card_id = $simActivations['sim_card_id'];
        $simActivation->user_id = $simActivations['user_id'];
        $simActivation->start_date= $simActivations['start_date'];
        $simActivation->end_date = $simActivations['end_date'];
        $simActivation->status = $simActivations['status']?$simActivations['status']:1;        
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

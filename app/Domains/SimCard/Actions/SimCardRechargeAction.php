<?php

namespace App\Domains\SimCard\Actions;

use App\Domains\SimCard\DTO\SimCardDTO\CreateSimCardRechargeData;
use App\Domains\SimCard\DTO\SimCardDTO\UpdateSimCardRechargeData;
use App\Domains\SimCard\Gateways\SimCardRechargeGateway;
use App\Domains\SimCard\Models\SimCardRecharge;

class SimCardRechargeAction
{
    public function create(CreateSimCardRechargeData $data)
    {
        return SimCardRecharge::create($data->toArray());
    }
    public function update(UpdateSimCardRechargeData $data)
    {
        $simcardRecharge = (new SimCardRechargeGateway)->getById($data->id);
        abort_unless((bool) $simcardRecharge, 404, "Simcard not found");
        $simcardRecharge->days = $data->days;
        $simcardRecharge->status = $data->status;
        $simcardRecharge->user_id = $data->user_id;
        $simcardRecharge->sim_card_id = $data->sim_card_id;
        $simcardRecharge->save();
        return $simcardRecharge;
    }
    public function delete(int $simcardRechargeId)
    {
        $simcardRecharge = (new SimcardRechargeGateway)->getById($simcardRechargeId);
        abort_unless((bool) $simcardRecharge, 404, "Simcard activation not found");
        $simcardRecharge->delete();
        return $simcardRecharge;
    }

}

<?php

namespace App\Domains\SimCard\Actions;

use App\Domains\SimCard\DTO\SimCardDTO\CreateSimCardRechargeData;
use App\Domains\SimCard\DTO\SimCardDTO\RechargeSimCardRechargeData;
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
        $simcardRecharge->sim_card_id = $data->sim_card_id;
        $simcardRecharge->number = $data->number;
        $simcardRecharge->email = $data->email;
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

    public function recharge(RechargeSimCardRechargeData $data)
    {
        $item = (new SimCardRechargeGateway)->getById($data->id);
        abort_unless((bool)$item, 404, "Sim card recharge not found");

        $item->payment_intent = $data->payment_intent;
        $item->payment_intent_client_secret = $data->payment_intent_client_secret;
        $item->status = SimCardRecharge::STATUS_ACTIVATED;
        $item->save();

        return $item;
    }
}

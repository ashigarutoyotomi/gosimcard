<?php

namespace App\Domains\SimCard\Gateways;

use App\Domains\SimCard\Models\SimRecharge;
use App\Traits\BasicGatewaysTrait;

class SimCardRechargeGateway
{
    use BasicGatewaysTrait;

    /**
     * get all devices
     *
     * @return void
     */
    public function all()
    {
        $query = SimRecharge::query();
        if ($this->with) {
            $query->with($this->with);
        }
        if ($this->paginate) {
            return $query->paginate($this->paginate);
        }
        return $query->get();
    }
    public function getById(int $simcardId)
    {
        $query = SimRecharge::query();
        if ($this->with) {
            $query->with($this->with);
        }
        $query->where([
            'id' => $simcardId,
        ]);
        return $query->first();
    }
}

<?php

namespace App\Domains\SimCard\Gateways;

use App\Domains\SimCard\Models\SimCard;
use App\Traits\BasicGatewaysTrait;

class SimCardGateway
{
    use BasicGatewaysTrait;

    /**
     * get all devices
     *
     * @return void
     */
    public function all()
    {
        $query = SimCard::query();
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
        $query = SimCard::query();
        if ($this->with) {
            $query->with($this->with);
        }
        $query->where([
            'id' => $simcardId,
        ]);
        return $query->first();
    }
}

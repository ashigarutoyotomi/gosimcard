<?php

namespace App\Domains\SimCard\Gateways;

use App\Domains\SimCard\Models\SimCardActivation;
use App\Traits\BasicGatewaysTrait;

class SimCardActivationGateway
{
    use BasicGatewaysTrait;

    public function all()
    {
        $query = SimCardActivation::query();

        if ($this->with) {
            $query->with($this->with);
        }

        if ($this->limit) {
            $query->limit($this->limit);
        }

        if ($this->search['keywords'] && count($this->search['columns'])) {
            $this->appendSearch($query);
        }

        if (count($this->filters)) {
            $this->appendFilters($query);
        }

        if ($this->paginate) {
            return $query->paginate($this->paginate);
        }

        return $query->get();
    }

    public function getById(int $id)
    {
        $query = SimCardActivation::query();

        if ($this->with) {
            $query->with($this->with);
        }

        $query->where([
            'id' => $id,
        ]);

        return $query->first();
    }

    protected function appendFilters($query)
    {
        if (array_key_exists('start_created_at', $this->filters)) {
            $query->where('created_at', '>=', $this->filters['start_created_at']);
        }

        if (array_key_exists('end_created_at', $this->filters)) {
            $query->where('created_at', '<=',  $this->filters['end_created_at']);
        }

        if (array_key_exists('start_date', $this->filters)) {
            $query->where('start_date', '>=', $this->filters['start_date']);
        }

        if (array_key_exists('end_date', $this->filters)) {
            $query->where('end_date', '<=', $this->filters['end_date']);
        }

        if (array_key_exists('status', $this->filters)) {
            $query->where('status', '>=', $this->filters['status']);
        }

        return $query;
    }
}

<?php

namespace App\Domains\User\Gateways;

use App\Domains\User\Models\User;
use App\Traits\BasicGatewaysTrait;

class UserGateway
{
    use BasicGatewaysTrait;

    /**
     * Get all users
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function all(int $user_id)
    {
        $query = User::query();

        $query->where('id', '!=', $user_id);

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

    protected function appendFilters($query)
    {
        if (array_key_exists('start_created_at', $this->filters)) {
            $query->where('created_at', '>=', $this->filters['start_created_at']);
        }

        if (array_key_exists('end_created_at', $this->filters)) {
            $query->where('created_at', '>=',  $this->filters['end_created_at']);
        }

        return $query;
    }
}

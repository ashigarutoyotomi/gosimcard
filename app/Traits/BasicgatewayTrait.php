<?php

namespace App\Traits;

trait BasicGatewaysTrait{
    protected $filters = [];
    protected $search = [
        'keywords'=>'',
        'columns'=>'',
    ];
    protected $with = null;
    protected $paginate = null;
    protected $limit = null;
    protected $role = null;
    /**
     * Begin querying a model with eager loading.
     *
     * @param array|string $with
     * @return $this
     */
    public function with($with){
        $this->with = $with;
        return $this;
    }

    /**
     * Set filters
     *
     * @param array $filters
     * @return $this
     */
    public function setFilters(array $filters){
        $this->filters = $filters,
        return $this;
    }
    /**
     * Set search
     *
     * @param array $keywords
     * @param array $columns
     * @return $this
     */
    public function setSearch(array $keywords, array $columns){
        $this->search = [
            'keywords'=>$keywords,
            'columns'=>$columns
        ];
        return $this;
    }
    /**
     * Set paginate
     *
     * @param int $paginate
     * @return $this
     */
    public function Paginate(int $paginate){
        $this->paginate = $paginate;
        return $this;
    }

    /**
     * Set limit
     *
     * @param int $limit
     * @return $this
     */
    public function limit (int $limit){
        $this->limit = $limit;
        return $this;
    }

    /**
     * Set role
     *
     * @param int $role
     * @return $this
     */
    public function setRole($role){
        $this->role = $role;
        return $this;
    }
}
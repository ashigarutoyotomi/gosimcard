<?php

namespace App\Traits;

use App\Classes\Helpers\StringHelper;

trait BasicGatewaysTrait
{
    protected $filters = [];
    protected $search = [
        'keywords' => '',
        'columns' => [],
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
    public function with($with)
    {
        $this->with = $with;
        return $this;
    }

    /**
     * Set filters
     *
     * @param array $filters
     * @return $this
     */
    public function setFilters(array $filters)
    {
        $this->filters = $filters;
        return $this;
    }

    /**
     * Set search
     *
     * @param string $keywords
     * @param array $columns
     * @return $this
     */
    public function setSearch(string $keywords, array $columns)
    {
        $this->search = [
            'keywords' => $keywords,
            'columns' => $columns,
        ];
        return $this;
    }

    /**
     * Append search
     */
    public function appendSearch($query)
    {
        $keywords = $this->search['keywords'];
        $columns = $this->search['columns'];

        $query->where(function ($q) use ($keywords, $columns) {
            $keywordParts = preg_split('/ /', $keywords, -1, PREG_SPLIT_NO_EMPTY);

            foreach ($keywordParts as $index => $possiblePart) {
                $like = "%" . StringHelper::escapeLike($possiblePart) . "%";
                $whereClause = $index == 0 ? 'where' : 'orWhere';
                $q->$whereClause(function ($q) use ($like, $columns) {
                    foreach ($columns as $j => $column) {
                        $whereClauseForColumns = $j == 0 ? 'where' : 'orWhere';
                        $q->$whereClauseForColumns($column, 'like', $like);
                    }
                });
            }
        });

        return $query;
    }

    /**
     * Set paginate
     *
     * @param int $paginate
     * @return $this
     */
    public function paginate(int $paginate)
    {
        $this->paginate = $paginate;
        return $this;
    }

    /**
     * Set limit
     *
     * @param int $limit
     * @return $this
     */
    public function limit(int $limit)
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * Set role
     *
     * @param int $role
     * @return $this
     */
    public function setRole(int $role)
    {
        $this->role = $role;
        return $this;
    }
}

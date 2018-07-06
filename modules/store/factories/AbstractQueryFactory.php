<?php

namespace modules\store\factories;

use craft\db\Query;

/**
 * Class AbstractQueryFactory
 */
abstract class AbstractQueryFactory
{
    /** @var string $able */
    protected $table;

    /** @var int $limit */
    protected $limit = 0;

    /** @var int $offset */
    protected $offset = 0;

    /** @var int $whereKey */
    protected $whereKey = 0;

    /** @var array $where */
    protected $where = [];

    /** @var int $likeKey */
    protected $likeKey = 0;

    /** @var array $like */
    protected $like = [];

    /** @var array $order */
    protected $orderBy = [];

    /**
     * Gets an instance of the factory
     * @return static
     */
    public static function getFactory(): self
    {
        return new static();
    }

    /**
     * Sets limit on the query
     * @param int $limit
     * @return self
     */
    public function limit(int $limit): self
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * Sets offset on the query
     * @param int $offset
     * @return self
     */
    public function offset(int $offset): self
    {
        $this->offset = $offset;
        return $this;
    }

    /**
     * Sets a where on the query
     * @param string $property
     * @param string $value
     * @param bool $groupAsOrWithLast Defaults to false
     * @return self
     */
    public function where(
        string $property,
        string $value,
        bool $groupAsOrWithLast = false
    ): self {
        if (! $groupAsOrWithLast) {
            $this->whereKey++;
        }

        $this->where[$this->whereKey][$property] = $value;

        return $this;
    }

    /**
     * @param string $property
     * @param string $value
     * @param bool $groupAsOrWithLast Defaults to false
     * @return self
     */
    public function like(
        string $property,
        string $value,
        bool $groupAsOrWithLast = false
    ): self {
        if (! $groupAsOrWithLast) {
            $this->likeKey++;
        }

        $this->like[$this->likeKey][$property] = $value;

        return $this;
    }

    /**
     * Adds an order by parameter
     * @param string $prop
     * @param string $dir
     * @return self
     */
    public function orderBy(string $prop, $dir = 'desc'): self
    {
        $this->orderBy[$prop] = $dir;
        return $this;
    }

    /**
     * Gets the total count of the query without the limit parameter
     * @return int
     */
    public function count(): int
    {
        return $this->buildQuery()->count();
    }

    /**
     * Gets all matching results
     * @return array
     */
    protected function getQueryResults(): array
    {
        $query = $this->buildQuery();

        if ($this->limit > 0) {
            $query->limit($this->limit);
        }

        if ($this->offset > 0) {
            $query->offset($this->offset);
        }

        return $query->all();
    }

    /**
     * Builds the query
     * @return Query
     */
    protected function buildQuery(): Query
    {
        $query = (new QueryFactory)->getQuery()
            ->from("{{%$this->table}}");

        foreach ($this->where as $whereGroup) {
            /** @var array $whereGroup */

            $str = '';
            $vars = [];

            foreach ($whereGroup as $prop => $val) {
                $var = uniqid('', false);

                if ($str) {
                    $str .= ' OR ';
                }

                $str .= "`{$prop}` = :{$var}";
                $vars[":{$var}"] = $val;
            }

            if (! $query->where) {
                $query->where("({$str})", $vars);
                continue;
            }

            $query->andWhere("({$str})", $vars);
        }

        foreach ($this->like as $likeGroup) {
            /** @var array $likeGroup */

            $str = '';
            $vars = [];

            foreach ($likeGroup as $prop => $val) {
                $var = uniqid('', false);

                if ($str) {
                    $str .= ' OR ';
                }

                $str .= "`{$prop}` LIKE :{$var}";
                $vars[":{$var}"] = "%{$val}%";
            }

            if (! $query->where) {
                $query->where("({$str})", $vars);
                continue;
            }

            $query->andWhere("({$str})", $vars);
        }

        foreach ($this->orderBy as $prop => $dir) {
            if (! $this->orderBy) {
                $query->orderBy("{$prop} {$dir}");
                continue;
            }

            $query->addOrderBy("{$prop} {$dir}");
        }

        return $query;
    }

    /**
     * Gets all query results
     * @return array
     */
    public function all(): array
    {
        return $this->getQueryResults();
    }

    /**
     * Gets the first query result
     * @return mixed
     */
    public function one()
    {
        $oldLimit = $this->limit;
        $this->limit = 1;

        $queryResult = $this->getQueryResults();

        $this->limit = $oldLimit;

        if (! $queryResult) {
            return null;
        }

        return $queryResult[0];
    }
}

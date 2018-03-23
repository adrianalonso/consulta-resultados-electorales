<?php

namespace App\Transformer;

/**
 * Class Model
 * @package App\Transformer
 */
class ModelRow
{

    /**
     * @var string
     */
    protected $column;

    /**
     * @var int
     */
    protected $offset;

    /**
     * @var int
     */
    protected $limit;

    /**
     * ModelRow constructor.
     * @param $column
     * @param $offset
     * @param $limit
     */
    public function __construct(string $column, int $offset, int $limit)
    {
        $this->column = $column;
        $this->offset = $offset;
        $this->limit = $limit;
    }

    /**
     * @return string
     */
    public function getColumn()
    {
        return $this->column;
    }

    /**
     * @param string $column
     */
    public function setColumn($column)
    {
        $this->column = $column;
    }

    /**
     * @return int
     */
    public function getOffset()
    {
        return $this->offset-1;
    }

    /**
     * @param int $offset
     */
    public function setOffset($offset)
    {
        $this->offset = $offset;
    }

    /**
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @param int $limit
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;
    }
}

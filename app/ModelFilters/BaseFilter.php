<?php

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class BaseFilter extends ModelFilter
{
    /**
     * ModelFilter constructor.
     *
     * @param $query
     * @param array $input
     * @param bool $relationsEnabled
     */
    public function __construct($query, array $input = [], $relationsEnabled = true)
    {
        parent::__construct($query, $input, $relationsEnabled);

        if (!property_exists($this, 'filterDateColumn')) {
            $this->filterDateColumn = 'created_at';
        }
    }

    /**
     * Filter results by month.
     * 
     * @param  string  $month
     * @return  $this
     */
    public function month($month)
    {
        $date = date_parse($month);
        return $this->whereMonth($this->filterDateColumn, $date['month']);
    }

    /**
     * Filter results by month.
     * 
     * @param  string  $month
     * @return  $this
     */
    public function year($year)
    {
        return $this->whereYear($this->filterDateColumn, $year);
    }

    /**
     * Filter results by status.
     * 
     * @param  string  $value
     * @return  $this
     */
    public function status($value)
    {
        if ($value == 'archived') {
            return $this->whereNotNull('deleted_at');
        }
    }
}
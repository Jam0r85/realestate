<?php

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class BaseFilter extends ModelFilter
{
    public function __construct($query, array $input = [], $relationsEnabled = true)
    {
        parent::__construct($query, $input, $relationsEnabled);

        if (!$this->filterDateColumn) {
            $this->filterDateColumn = 'created_at';
        }
    }

    /**
     * Filter invoices by month.
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
     * Filter invoices by month.
     * 
     * @param  string  $month
     * @return  $this
     */
    public function year($year)
    {
        return $this->whereYear($this->filterDateColumn, $year);
    }
}
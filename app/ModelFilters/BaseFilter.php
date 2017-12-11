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
     * Filter results by their deleted_at column
     * 
     * @return  $this
     */
    public function archived()
    {
        return $this->whereNotNull('deleted_at');
    }

    /**
     * Filter records to only show paid
     * 
     * @return  $this
     */
    public function paid($status = false)
    {
        if ($status) {
            return $this->whereNotNull('paid_at');
        } else {
            return $this->whereNull('paid_at')
                ->latest('paid_at');
        }
    }

    /**
     * Filter records to only show sent
     * 
     * @return  $this
     */
    public function sent($status = false)
    {
        if ($status) {
            return $this->whereNotNull('sent_at');
        } else {
            return $this->whereNull('sent_at')
                ->latest('sent_at');
        }
    }
}
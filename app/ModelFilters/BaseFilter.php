<?php

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class BaseFilter extends ModelFilter
{
    /**
     * The date column we use to filter results against.
     * 
     * @var string
     */
    public $filterDateColumn = 'created_at';

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
     * Filter archived results
     * 
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function archived($status)
    {
        if ($status == false) {
            return $this->whereNull('deleted_at');
        } else {
            return $this->whereNotNull('deleted_at');
        }
    }

    /**
     * Filter records to only show paid
     * 
     * @return  $this
     */
    public function paid($status = false)
    {
        if ($status) {
            return $this->whereNotNull('paid_at')
                ->latest('paid_at');
        } else {
            return $this->whereNull('paid_at');
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
            return $this->whereNotNull('sent_at')
                ->latest('sent_at');
        } else {
            return $this->whereNull('sent_at')
                ->latest('created_at');
        }
    }
}
<?php

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class BaseFilter extends ModelFilter
{
    /**
     * Filter invoices by month.
     * 
     * @param  string  $month
     * @return  $this
     */
    public function month($month)
    {
        $date = date_parse($month);
        return $this->whereMonth('created_at', $date['month']);
    }

    /**
     * Filter invoices by month.
     * 
     * @param  string  $month
     * @return  $this
     */
    public function year($year)
    {
        return $this->whereYear('created_at', $year);
    }
}
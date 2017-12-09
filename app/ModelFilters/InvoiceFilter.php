<?php

namespace App\ModelFilters;

class InvoiceFilter extends BaseFilter
{
    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];

    /**
     * Filter invoices by group slug.
     *
     * @param  string  $slug
     * @return  $this
     */
    public function group($slug)
    {
    	return $this->related('invoiceGroup', 'slug', '=', $slug);
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

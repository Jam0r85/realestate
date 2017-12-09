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
     * @return  \App\Invoice
     */
    public function group($slug)
    {
    	return $this->related('invoiceGroup', 'slug', '=', $slug);
    }
}

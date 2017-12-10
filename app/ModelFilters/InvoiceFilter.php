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
     * Setup the filter.
     * 
     * @return  $this
     */
    public function setup()
    {
        if (!request('archived')) {
            $this->whereNull('deleted_at');
        }

        return $this;
    }

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
}

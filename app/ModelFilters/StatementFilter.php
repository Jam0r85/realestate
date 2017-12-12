<?php

namespace App\ModelFilters;

class StatementFilter extends BaseFilter
{
	public $filterDateColumn = 'period_start';

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

        if (!request('sent')) {
        	$this->whereNull('sent_at');
        }

        return $this;
    }
}

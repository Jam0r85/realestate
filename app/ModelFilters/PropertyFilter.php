<?php

namespace App\ModelFilters;

class PropertyFilter extends BaseFilter
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
            return $this->whereNull('deleted_at');
        }
    }
}

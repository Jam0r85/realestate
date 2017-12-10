<?php

namespace App\ModelFilters;

class TenancyFilter extends BaseFilter
{
    /**
     * The table column we want to use when filtering the year the month.
     * 
     * @var  string
     */
    protected $filterDateColumn = 'started_on';

    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];

    /**
     * Filter results by service slug.
     * 
     * @param  string  $slug
     * @return 
     */
    public function service($slug)
    {
    	return $this->related('service', 'slug', '=', $slug);
    }
}

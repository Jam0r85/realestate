<?php

namespace App\ModelFilters;

class EventFilter extends BaseFilter
{
    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];

   	/**
	 * The date column we want to use when filtering by month and year.
	 * 
	 * @var string
	 */
	public $filterDateColumn = 'start';
}

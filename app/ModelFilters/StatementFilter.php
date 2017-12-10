<?php

namespace App\ModelFilters;

class StatementFilter extends BaseFilter
{
	protected $filterDateColumn = 'period_start';
	
    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];
}

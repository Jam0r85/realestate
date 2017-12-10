<?php

namespace App\ModelFilters;

use Carbon\Carbon;

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

    public function hasRent()
    {

    }

    public function owesRent()
    {

    }

    public function owesDeposit()
    {

    }

    /**
     * Show only overdue results.
     * 
     * @return  $this
     */
    public function overdue()
    {
        return $this->where('is_overdue', '>', 0)->orderBy('is_overdue', 'desc');
    }

    /**
     * Show only vacated results.
     * 
     * @return [type] [description]
     */
    public function vacated()
    {
        return $this->whereNotNull('vacated_on')->where('vacated_on', '<=', Carbon::now());
    }
}

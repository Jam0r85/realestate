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
    public $filterDateColumn = 'started_on';

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

    /**
     * Show only rent balance results.
     * 
     * @return  $this
     */
    public function hasRentBalance()
    {
        return $this->where('rent_balance', '>', 0)->orderBy('rent_balance');
    }

    /**
     * Show only negative rent balance results.
     * 
     * @return  $this
     */
    public function owesRent()
    {
        return $this->where('rent_balance', '<', 0)->orderBy('rent_balance', 'desc');
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
     * @return  $this
     */
    public function vacated()
    {
        return $this->whereNotNull('vacated_on')->where('vacated_on', '<=', Carbon::now());
    }

    /**
     * Show only vacating results.
     * 
     * @return. $this
     */
    public function vacating()
    {
        return $this->whereNotNull('vacated_on')->where('vacated_on', '>', Carbon::now());
    }
}

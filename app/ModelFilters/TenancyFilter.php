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
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function service($slug)
    {
    	return $this
            ->related('service', 'slug', '=', $slug);
    }

    /**
     * Show only rent balance results.
     * 
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function hasRentBalance()
    {
        return $this
            ->where('rent_balance', '>', 0)
            ->orderBy('rent_balance', 'desc');
    }

    /**
     * Show only negative rent balance results.
     * 
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function owesRent()
    {
        return $this
            ->where('rent_balance', '<', 0)
            ->orderBy('rent_balance', 'desc');
    }

    public function owesDeposit()
    {

    }

    /**
     * Show only overdue results.
     * 
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function overdue()
    {
        return $this
            ->where('is_overdue', '>', 0)
            ->orderBy('is_overdue', 'desc');
    }

    /**
     * Filter results by their status
     * 
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function status($status)
    {
        return $this->$status();
    }

    /**
     * Show only vacated results.
     * 
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function vacated()
    {
        return $this
            ->whereNotNull('vacated_on')
            ->where('vacated_on', '<=', Carbon::now());
    }

    /**
     * Show only vacating results.
     * 
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function vacating()
    {
        return $this
            ->whereNotNull('vacated_on')
            ->where('vacated_on', '>', Carbon::now());
    }

    /**
     * Show tenancies which have not started yet.
     * 
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function starting()
    {
        return $this
            ->whereNull('started_on');
    }
}

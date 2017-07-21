<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
	/**
	 * The attrbites that should be included in the collection.
	 * 
	 * @var array
	 */
	protected $appends = ['charge_formatted'];

	/**
	 * A service can have a tax rate.
	 */
    public function tax_rate()
    {
    	return $this->belongsTo('App\TaxRate');
    }

    /**
     * Get the service's charge formatted.
     * 
     * @return string
     */
    public function getChargeFormattedAttribute()
    {
    	if ($this->charge < 1) {
    		return $this->charge * 100 . '%';
    	} else {
    		return currency($this->charge);
    	}
    }
}

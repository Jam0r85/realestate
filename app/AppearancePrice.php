<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppearancePrice extends Model
{
    public $fillable = ['amount'];
    
	/**
	 * A price belongs to an appearance.
	 */
    public function appearance()
    {
    	return $this->belongsTo('App\Appearance');
    }

    /**
     * A price has a qualifier.
     */
    public function qualifier()
    {
    	return $this->belongsTo('App\AppearancePriceQualifier', 'qualifier_id');
    }
}

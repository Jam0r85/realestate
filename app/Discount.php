<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Discount extends Model
{
    use SoftDeletes;

    /**
     * Get the discount amount formatted.
     * 
     * @return string
     */
    public function getAmountFormattedAttribute()
    {
    	return $this->amount;
    }
}

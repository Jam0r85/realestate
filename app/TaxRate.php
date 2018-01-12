<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;

class TaxRate extends BaseModel
{
    use SoftDeletes;
    
    /**
     * Indicates if the model should be timestamped.
     * 
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that should be mutated to dates.
     * 
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Calculate tax for the given amount.
     *
     * @param  int  $amount
     * @return int
     */
    public function getTaxAmount($net = 0)
    {
        if (! $this->amount) {
            return 0;
        }
        
        return $net * ($this->amount / 100);
    }

    /**
     * Return the amount including the tax amount.
     * 
     * @param  int  $net
     * @return int
     */
    public function getAmountIncludingTax($net = 0)
    {
        return $this->net + $this->getTaxAmount($net);
    }
}

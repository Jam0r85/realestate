<?php

namespace App;

class TaxRate extends BaseModel
{
    /**
     * Indicates if the model should be timestamped.
     * 
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attrbites that should be included in the collection.
     * 
     * @var array
     */
    protected $appends = ['name_formatted'];

	/**
	 * Get the tax rate formatted name.
	 * 
	 * @return string
	 */
    public function getNameFormattedAttribute()
    {
    	return $this->name . ' (' . (float) $this->amount . '%)';
    }
}

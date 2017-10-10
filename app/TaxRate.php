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
}

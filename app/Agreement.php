<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;

class Agreement extends BaseModel
{
	use SoftDeletes;
	
    /**
     * The attributes that should be mutated to dates.
     * 
     * @var array
     */
    protected $dates = ['starts_at','ends_at'];

	/**
	 * The attributes that are mass assignable.
	 * 
	 * @var array
	 */
    protected $fillable = ['user_id','tenancy_id','starts_at','length','ends_at'];

    /**
     * An agreement belongs to a tenancy.
     */
    public function tenancy()
    {
    	return $this->belongsTo('App\Tenancy');
    }

   	/**
   	 * An agreement was created by a user.
   	 */
    public function owner()
    {
    	return $this->belongsTo('App\User');
    }
}

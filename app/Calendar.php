<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;

class Calendar extends BaseModel
{
	use SoftDeletes;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
	protected $casts = [
		'is_private' => 'boolean'
	];
	
	/**
	 * The attributes that are mass assignable.
	 * 
	 * @var array
	 */
    protected $fillable = ['name','is_private','branch_id'];

    /**
     * A calendar belongs to a branch.
     */
    public function branch()
    {
    	return $this->belongsTo('App\Branch');
    }

    /**
     * A calendar can have many events.
     */
    public function events()
    {
        return $this->hasMany('App\Event');
    }

    /**
     * A calendar can have many archived events.
     */
    public function archivedEvents()
    {
        return $this->hasMany('App\Event')->onlyTrashed();
    }
}
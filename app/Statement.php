<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Statement extends Model
{
	/**
	 * A statement can belong to a tenancy.
	 */
	public function tenancy()
	{
		return $this->belongsTo('App\Tenancy');
	}

	/**
	 * A statement can belong to a property through it's tenancy.
	 */
	public function property()
	{
		return $this->belongsToThrough('App\Property', 'App\Tenancy');
	}

	/**
	 * A statement can belong to many users.
	 */
    public function users()
    {
    	return $this->belongsToMany('App\User');
    }
}

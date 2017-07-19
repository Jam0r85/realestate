<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
	/**
	 * Set the page limit for pagination.
	 * 
	 * @var integer
	 */
	protected $perPage = 45;

	/**
	 * Model can have many settings.
	 */
	public function settings()
	{
		return $this->morphMany('App\Setting');
	}	
}
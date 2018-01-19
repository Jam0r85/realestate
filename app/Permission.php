<?php

namespace App;

class Permission extends BaseModel
{
	/**
	 * Indicates if the model should be timestamped.
	 * 
	 * @var bool
	 */
	public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = [
		'name', 'slug', 'description'
	];

	/**
	 * Set the name.
	 * 
	 * @param string  $value
	 */
	public function setNameAttribute($value)
	{
		$this->attributes['name'] = ucfirst($value);
	}

	/**
	 * Set the permission slug.
	 * 
	 * @param string  $value
	 */
	public function setSlugAttribute($value)
	{
		$this->attributes['slug'] = str_slug($value);
	}
}

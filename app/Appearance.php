<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laracasts\Presenter\PresentableTrait;

class Appearance extends Model
{
	use SoftDeletes;
	use PresentableTrait;

	protected $presenter = 'App\Presenters\AppearancePresenter';

	protected $dates = ['live_at','ended_at','deleted_at'];

	protected $casts = [
		'hidden' => 'boolean',
		'data' => 'array'
	];

	/**
	* An appearance was created by it's owner.
	*/
	public function owner()
	{
		return $this->belongsTo('App\User', 'user_id');
	}

	/**
	* An appearance has a property.
	*/
	public function property()
	{
		return $this->hasOne('App\Property');
	}

	/**
	* An appearance can have a status.
	*/
	public function status()
	{
		return $this->belongsTo('App\AppearanceStatus', 'status_id');
	}

	/**
	* An appearance belongs to a section.
	*/
	public function section()
	{
		return $this->belongsTo('App\AppearanceSection', 'section_id');
	}

	/**
	* An appearance has many prices.
	*/
	public function prices()
	{
		return $this->hasMany('App\AppearancePrice');
	}
}
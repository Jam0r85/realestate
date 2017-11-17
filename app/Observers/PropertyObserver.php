<?php

namespace App\Observers;

use App\Property;
use Illuminate\Support\Facades\Auth;

class PropertyObserver
{
	/**
	 * Listen to the Property creating event.
	 * 
	 * @param \App\Property $property
	 * @return void
	 */
	public function creating(Property $property)
	{
		$property->user_id = Auth::user()->id;
	}
}
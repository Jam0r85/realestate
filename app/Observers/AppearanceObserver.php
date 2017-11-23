<?php

namespace App\Observers;

use App\Appearance;
use Illuminate\Support\Facades\Auth;

class AppearanceObserver
{
	/**
	 * Listen to the Appearance creating event.
	 * 
	 * @param  \App\Appearance  $appearance
	 * @return  void
	 */
	public function creating(Appearance $appearance)
	{
		$appearance->user_id = Auth::user()->id;
		$appearance->slug = str_random(10);
	}

	/**
	 * Listen to the Appearance created event.
	 * 
	 * @param  \App\Appearance  $appearance
	 * @return  void
	 */
	public function created(Appearance $appearance)
	{
		$appearance->slug = str_slug($appearance->section->name . '/' . $appearance->property->town . '/' . $appearance->property->present()->slug);
		$appearance->save();
	}
}
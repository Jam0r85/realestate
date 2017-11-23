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
		$appearance->slug = str_random(20);
	}

	/**
	 * Listen to the Appearance created event.
	 * 
	 * @param  \App\Appearance  $appearance
	 * @return  void
	 */
	public function created(Appearance $appearance)
	{
		$section = $appearance->section->slug;
		$town = str_slug($appearance->property->town);
		$address = $appearance->property->present()->slug;

		$appearance->slug = $section . '/' . $town . '/' . $address;
		$appearance->save();
	}
}
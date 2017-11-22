<?php

namespace App\Observers;

use App\TenancyRent;
use Illuminate\Support\Facades\Auth;

class TenancyRentObserver
{
	/**
	 * Listen to the Tenancy Rent creating event.
	 * 
	 * @param  \App\Tenancy  $rent
	 * @return  void
	 */
	public function creating(TenancyRent $rent)
	{
		$rent->user_id = Auth::user()->id;
	}
}
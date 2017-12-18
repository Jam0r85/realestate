<?php

namespace App\Observers;

use App\Tenancy;
use Illuminate\Support\Facades\Auth;

class TenancyObserver
{
	/**
	 * Listen to the Tenancy creating event.
	 * 
	 * @param  \App\Tenancy  $tenancy
	 * @return void
	 */
	public function creating(Tenancy $tenancy)
	{
		$agreement->user_id = Auth::user()->id;
	}
}
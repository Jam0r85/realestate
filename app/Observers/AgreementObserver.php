<?php

namespace App\Observers;

use App\Agreement;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AgreementObserver
{
	/**
	 * Listen to the Agreement creating event.
	 * 
	 * @param  \App\Agreement  $agreement
	 * @return void
	 */
	public function creating(Agreement $agreement)
	{
		$agreement->user_id = Auth::user()->id;
		$agreement->ends_at = calculate_end_date($agreement->starts_at, $agreement->length);
	}
}
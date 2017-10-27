<?php

namespace App\Observers;

use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class UserObserver
{
	/**
	 * Listen to the User creating event.
	 * 
	 * @param \App\User $user
	 * @return void
	 */
	public function creating(User $user)
	{
		$user->user_id = Auth::user()->id;
	}
}
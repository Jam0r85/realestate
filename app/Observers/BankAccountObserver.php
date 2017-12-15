<?php

namespace App\Observers;

use App\BankAccount;
use Illuminate\Support\Facades\Auth;

class BankAccountObserver
{
	/**
	 * Listen to the Bank Account creating event.
	 * 
	 * @param  \App\BankAccount  $appearance
	 * @return void
	 */
	public function creating(BankAccount $account)
	{
		$appearance->user_id = Auth::user()->id;
	}
}
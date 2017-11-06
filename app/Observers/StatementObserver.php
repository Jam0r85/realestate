<?php

namespace App\Observers;

use App\Statement;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class StatementObserver
{
	/**
	 * Listen to the Statement creating event.
	 * 
	 * @param App\Statement $statement
	 * @return void
	 */
	public function creating(Statement $statement)
	{
		$statement->user_id = Auth::user()->id;
		$statement->key = str_random(30);
		$statement->send_by = $statement->tenancy->property->settings['statement_send_method'];
		$statement->period_end = $statement->period_end ?? $statement->period_start->addMonth()->subDay();
		$statement->amount = $statement->amount ?? $statement->tenancy->rent_amount;
	}

	/**
	 * Listen to the Statement created event.
	 * 
	 * @param App\Statement $statement
	 * @return void
	 */
	public function created(Statement $statement)
	{
		if (!count($statement->users)) {
			$statement->users()->sync($statement->tenancy->property->owners);
		}
	}
}
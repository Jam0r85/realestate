<?php

namespace App\Observers;

use App\Jobs\UpdateTenancyRentBalances;
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
		$statement->amount = $statement->amount ?? $statement->tenancy->present()->rentAmountPlain;
	}

	/**
	 * Listen to the Statement saved event.
	 * 
	 * @param App\Statement $statement
	 * @return void
	 */
	public function saved(Statement $statement)
	{
		if (!count($statement->users)) {
			$statement->users()->sync($statement->property()->owners);
		}

		UpdateTenancyRentBalances::dispatch($statement->tenancy_id);
	}

	/**
	 * Listen to the Statement deleted event.
	 * 
	 * @param App\Statement $statement
	 * @return void
	 */
	public function deleted(Statement $statement)
	{
		UpdateTenancyRentBalances::dispatch($statement->tenancy_id);
	}
}
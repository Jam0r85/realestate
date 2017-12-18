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
		$statement->send_by = $statement->tenancy->property->getSetting('statement_send_method') ?? 'email';
		$statement->period_end = $statement->period_end ?? $statement->period_start->addMonth()->subDay();
		$statement->amount = $statement->amount ?? $statement->tenancy->present()->rentAmountPlain;
	}

	/**
	 * Listen to the Statement deleting event.
	 * 
	 * @param App\Statement $statement
	 * @return void
	 */
	public function deleting(Statement $statement)
	{
		if ($statement->forceDeleting) {
            $statement->payments()->whereNotNull('sent_at')->delete();
            $statement->payments()->whereNull('sent_at')->delete();
            $statement->invoices()->forceDelete();
		}
	}
}
<?php

namespace App\Observers;

use App\Expense;
use Illuminate\Support\Facades\Auth;

class ExpenseObserver
{
	/**
	 * Listen to the Expense creating event.
	 * 
	 * @param \App\Expense $expense
	 * @return void
	 */
	public function creating(Expense $expense)
	{
		$expense->user_id = Auth::user()->id;
	}

	/**
	 * Listen to the Expense deleted event.
	 * 
	 * @param \App\Expense $expense
	 * @return void
	 */
	public function deleted(Expense $expense)
	{
		$expense->documents()->delete();
	}
}
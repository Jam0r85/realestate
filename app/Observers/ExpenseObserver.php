<?php

namespace App\Observers;

use App\Expense;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
		foreach ($expense->documents as $document) {
			Storage::delete($document->path);
			$document->forceDelete();
		}
	}
}
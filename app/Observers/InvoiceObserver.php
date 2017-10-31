<?php

namespace App\Observers;

use App\Invoice;
use Illuminate\Support\Facades\Auth;

class InvoiceObserver
{
	/**
	 * Listen to the Invoice creating event.
	 * 
	 * @param \App\Invoice $invoice
	 * @return void
	 */
	public function creating(Invoice $invoice)
	{
		$invoice->slug = str_slug($invoice->name);
	}
}
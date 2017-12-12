<?php

namespace App\Observers;

use App\Events\Invoices\InvoiceUpdateBalancesEvent;
use App\InvoiceItem;

class InvoiceItemObserver
{
	/**
	 * Listen to the Invoice Item saved event.
	 * 
	 * @param  \App\InvoiceItem $item
	 * @return  void
	 */
	public function saved(InvoiceItem $item)
	{
		event(new InvoiceUpdateBalancesEvent($item->invoice));
	}
}
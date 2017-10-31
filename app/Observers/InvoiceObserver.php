<?php

namespace App\Observers;

use App\Invoice;
use App\InvoiceGroup;
use Carbon\Carbon;
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
		$invoice->user_id = $invoice->user_id ?? Auth::user()->id;
		$invoice->key = str_random(30);
		$invoice->property_id = $invoice->property_id ?? 0;
		$invoice->terms = $invoice->terms ?? get_setting('invoice_default_terms');
		$invoice->invoice_group_id = $invoice->invoice_group_id ?? get_setting('invoice_default_group');
		$invoice->number = $invoice->number ?? InvoiceGroup::findOrFail($invoice->invoice_group_id)->next_number;
	}

	/**
	 * Listen to the Invoice created event.
	 * 
	 * @param \App\Invoice $invoice
	 * @return void
	 */
	public function created(Invoice $invoice)
	{
		$invoice->update([
			'due_at' => Carbon::parse($invoice->created_at)->addDay(get_setting('invoice_due_after'), 30)
		]);

		$group = InvoiceGroup::findOrFail($invoice->invoice_group_id);
		if ($invoice->number == $group->next_number) {
			$group->increment('next_number');
		}
	}
}
<?php

namespace App\Services;

use App\Invoice;
use App\InvoiceGroup;
use App\InvoiceItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class InvoiceService
{
	/**
	 * Create an invoice.
	 * 
	 * @param array $data
	 * @return \App\Invoice
	 */
	public function createInvoice(array $data)
	{
		$invoice = new Invoice();
		$invoice->key = str_random(30);
		$invoice->user_id = Auth::user()->id;
		$invoice->property_id = $data['property_id'];
		$invoice->due_at = Carbon::now()->addDay(get_setting('invoice_due_after'), 30);

		// Set the default terms if they are missing.
		if (!isset($data['terms'])) {
			$invoice->terms = get_setting('invoice_default_terms', null);
		} else {
			$invoice->terms = $data['terms'];
		}

		// Set the invoice group.
		if (!isset($data['invoice_group_id'])) {
			$invoice->invoice_group_id = get_setting('invoice_default_group');
		} else {
			$invoice->invoice_group_id = $data['invoice_group_id'];
		}

		// Set the invoice number.
		if (!isset($data['number'])) {
			$invoice->number = InvoiceGroup::findOrFail($invoice->invoice_group_id)->next_number;
		} else {
			$invoice->number = $data['number'];
		}

		// Set the created_at date.
		if (isset($data['created_at'])) {
			$invoice->created_at = Carbon::createFromFormat('Y-m-d', $data['created_at']);
		}

		if (isset($data['paid_at'])) {
			$invoice->paid_at = Carbon::createFromFormat('Y-m-d', $data['paid_at']);
		}

		// Create the invoice.
		$invoice->save();

		// Attach the invoice users.
		if (isset($data['users'])) {
			$invoice->users()->attach($data['users']);
		}

		// Increment the invoice group number.
		$invoice_group = InvoiceGroup::findOrFail($invoice->invoice_group_id);

		if ($invoice->number == $invoice_group->next_number) {
			$invoice_group->increment('next_number');
		}

		return $invoice;
	}

	/**
	 * Create an invoice item.
	 * 
	 * @param array $data
	 * @param integer $id
	 * @return \App\Invoice
	 */
	public function createInvoiceItem(array $data, $id)
	{
		$invoice = Invoice::findOrFail($id);

		$item = new InvoiceItem();
		$item->name = $data['name'];
		$item->description = $data['description'];
		$item->amount = $data['amount'];
		$item->quantity = $data['quantity'];
		$item->tax_rate_id = $data['tax_rate_id'];

		$invoice->items()->save($item);

		return $invoice;
	}

	/**
	 * Destroy an invoice.
	 * Invoice items have a foreign link and are automatically deleted.
	 * 
	 * @param array $options
	 * @param integer $invoice_id
	 * @return \App\Invoice
	 */
	public function destroyInvoice($options = [], $invoice_id)
	{
		$invoice = Invoice::withTrashed()->findOrFail($invoice_id);

		// Delete the invoice payments.
		if (isset($options['payments'])) {
			$invoice->payments->delete();
		}

		$invoice->forceDelete();

		return $invoice;
	}
}
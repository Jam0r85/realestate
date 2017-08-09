<?php

namespace App\Services;

use App\Invoice;
use App\InvoiceGroup;
use App\InvoiceItem;
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
		$data['key'] = str_random(30);
		$data['user_id'] = Auth::user()->id;

		// Set the invoice group.
		if (!isset($data['invoice_group_id'])) {
			$data['invoice_group_id'] = get_setting('invoice_default_group');
		}

		// Set the invoice number.
		if (!isset($data['number'])) {
			$data['number'] = InvoiceGroup::findOrFail($data['invoice_group_id'])->next_number;
		}

		// Create the invoice.
		$invoice = Invoice::create($data);

		// Attach the invoice users.
		if (isset($data['users'])) {
			$invoice->users()->attach($data['users']);
		}

		// Increment the invoice group number.
		InvoiceGroup::findOrFail($data['invoice_group_id'])->increment('next_number');

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
}
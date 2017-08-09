<?php

namespace App\Services;

use App\Invoice;
use App\InvoiceGroup;
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
		$data['terms'] = get_setting('invoice_default_terms', null);

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
}
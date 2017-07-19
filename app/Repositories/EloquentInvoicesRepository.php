<?php

namespace App\Repositories;

use App\Invoice;
use App\InvoiceGroup;
use App\InvoiceItem;
use Carbon\Carbon;

class EloquentInvoicesRepository extends EloquentBaseRepository
{
	/**
	 * Get the class name.
	 * 
	 * @return string
	 */
	public function getClassPath()
	{
		return 'App\Invoice';
	}

	/**
	 * Get a list of unpaid invoices.
	 * 
	 * @return
	 */
	public function getUnpaidPaged()
	{
		return $this->getInstance()->whereNull('paid_at')->latest('paid_at')->paginate();
	}

	/**
	 * Get a list of overdue invoices.
	 * 
	 * @return
	 */
	public function getOverduePaged()
	{
		return $this->getInstance()->whereNull('paid_at')->where('due_at', '<', Carbon::now())->latest('due_at')->paginate();
	}

	/**
	 * Create a new invoice.
	 * 
	 * @param  array  $data
	 * @return 
	 */
	public function createInvoice(array $data)
	{
		// Get the invoice group
		$group = InvoiceGroup::findOrFail($data['invoice_group_id']);

		// Set the access key
		$data['key'] = str_random(15);

		// Set the next number
		if (!isset($data['number'])) {
			$data['number'] = $group->next_number;

			// Increment the next number for the group
			$group->increment('next_number');
		}

		// Create the invoice
		$invoice = $this->create($data);		

		// Return the invoice
		return $invoice;
	}

	/**
	 * Create a new invoice item for an invoice.
	 * 
	 * @param  array  $data
	 * @param  invoice $id
	 * @return mixed
	 */
	public function createInvoiceItem(array $data, $id)
	{
		// Find the invoice.
		$invoice = $this->find($id);

		// Insert the invoice ID to the data array.
		$data['invoice_id'] = $invoice->id;

		// Create the item.
		InvoiceItem::create($data);

		// Flash a success message
		$this->successMessage('The invoice item was created.');

		// Return the invoice
		return $invoice;
	}
}
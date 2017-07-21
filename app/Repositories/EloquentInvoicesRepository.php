<?php

namespace App\Repositories;

use App\Invoice;
use App\InvoiceGroup;
use App\InvoiceItem;
use App\Property;
use Carbon\Carbon;

class EloquentInvoicesRepository extends EloquentBaseRepository
{
	/**
	 * @var  App\Repositories\EloquentPaymentsRepository
	 */
	public $payments;

    /**
     * Create a new repository instance.
     * 
     * @param   EloquentPaymentsRepository $payments
     * @return  void
     */
	public function __construct(EloquentPaymentsRepository $payments)
	{
		$this->payments = $payments;
	}

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
		$data['terms'] = get_setting('invoice_default_terms');

		// Set the next number
		if (!isset($data['number'])) {
			$data['number'] = $group->next_number;
		}

		// Create the invoice
		$invoice = $this->create($data);

		// Increment the group number
		$group->increment('next_number');

		// Add property owners if no users are present.
		if (!isset($data['user_id'])) {
			$owners = Property::findOrFail($data['property_id'])->owners;
			$invoice->users()->attach($owners);
		} else {
			$invoice->users()->attach($data['user_id']);
		}

		return $invoice;
	}

	/**
	 * Update an invoice.
	 * 
	 * @param  array  $data
	 * @param  invoice $id
	 * @return mixed
	 */
	public function updateInvoice(array $data, $id)
	{
		return $this->update($data, $id);
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

		return $invoice;
	}

	/**
	 * Create a new payment for the invoice.
	 * 
	 * @param  array  $data
	 * @param  invoice $id
	 * @return mixed
	 */
	public function createPayment(array $data, $id)
	{
		// Find the invoice.
		$invoice = $this->find($id);

		// Create the payment
		$payment = $this->payments->createPayment($data, $invoice);

		// Grab a fresh copy of the invoice
		$invoice->fresh();

        // Mark the invoice as paid when the balance is empty.
        if (empty($invoice->total_balance)) {
            $this->update([
            	'paid_at' => Carbon::now()
            ], $invoice);
        }

		// Flash a success message.
		$this->successMessage('The payment was created');

		return $invoice;
	}

	/**
	 * Reset the next number for the invoice group if we need to.
	 * 
	 * @param  Invoice $id
	 * @return mixed
	 */
	public function resetGroupNextNumber($id)
	{
		// Get the invoice
		$invoice = $this->find($id);

		// Get the invoice group.
		$group = InvoiceGroup::findOrFail($invoice->invoice_group_id);

		if ($invoice->number + 1 == $group->next_number) {
			$group->decrement('next_number');
		}

		return $invoice;
	}
}
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
	 * Get a list of paid invoices.
	 * 
	 * @return
	 */
	public function getPaidPaged()
	{
		return $this->getInstance()->whereNotNull('paid_at')->latest('number')->paginate();
	}	

	/**
	 * Get a list of unpaid invoices.
	 * 
	 * @return
	 */
	public function getUnpaidPaged()
	{
		return $this->getInstance()->whereNull('paid_at')->oldest()->paginate();
	}

	/**
	 * Get a list of unpaid invoices.
	 * 
	 * @return
	 */
	public function getUnpaidList()
	{
		return $this->getInstance()->whereNull('paid_at')->get();
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
		// Set the default group should none be supplied.
		if (!isset($data['invoice_group_id'])) {
			$data['invoice_group_id'] = get_setting('invoice_default_group');
		}

		// Find the group.
		$group = InvoiceGroup::findOrFail($data['invoice_group_id']);

		// Build the data array.
		$data['key'] = str_random(15);
		$data['terms'] = get_setting('invoice_default_terms');

		// Set the next number
		if (!isset($data['number'])) {
			$data['number'] = $group->next_number;
		}

		// Create the invoice
		$invoice = $this->create($data);

		// Increment the group number ONLY if the next number matches the one stored in the data.
		if ($data['number'] == $group->next_number) {
			$group->increment('next_number');
		}

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
		$invoice = $this->update($data, $id);

		$invoice->users()->sync($data['user_id']);

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

	/**
	 * Archive the invoice.
	 * 
	 * @param  App\Invoice $id
	 * @return App\Invoice
	 */
	public function archiveInvoice($id)
	{
		$invoice = $this->archive($id);
		$this->resetGroupNextNumber($invoice);
		return $invoice;
	}
}
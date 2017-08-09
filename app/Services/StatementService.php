<?php

namespace App\Services;

use App\Services\InvoiceService;
use App\Statement;
use App\Tenancy;
use Carbon\Carbon;

class StatementService
{
	/**
	 * Create a new rental statement.
	 * 
	 * @param array $data
	 * @param integer $id
	 * @return \App\Statement
	 */
	public function createStatement(array $data, $id)
	{
		// Find the tenancy.
		$tenancy = Tenancy::findOrFail($id);

		// Set the start date.
		if ($data['period_start']) {
        	$data['period_start'] = Carbon::createFromFormat('Y-m-d', $data['period_start']);
        } else {
        	$tenancy->next_statement_start_date;
       	}

       	// Set the end date.
        if (!isset($data['period_end'])) {
            $data['period_end'] = clone $data['period_start'];
            $data['period_end']->addMonth()->subDay();
        } else {
            $data['period_end'] = Carbon::createFromFormat('Y-m-d', $data['period_end']);
        }

        $statement = new Statement();
        $statement->key = str_random(30);
        $statement->amount = isset($data['amount']) ? $data['amount'] : $tenancy->rent_amount;
        $statement->period_start = $data['period_start'];
        $statement->period_end = $data['period_end'];

        if (isset($data['created_at'])) {
        	$statement->created_at = Carbon::createFromFormat('Y-m-d', $data['created_at']);
        }

        // Store the statement
        $statement = $tenancy->statements()->save($statement);

        // Attach the property owners to the statement.
        $statement->users()->attach($tenancy->property->owners);

        // Create the service charge invoice should we need to.
        $this->createServiceChargeItem($statement->id, $tenancy->id);

		return $statement;
	}

	/**
	 * Check and create the service charge invoice item.
	 * 
	 * @param integer $statement_id
	 * @param integer $tenancy_id
	 * @return bool
	 */
	public function createAutomaticServiceChargeInvoice($statement_id, $tenancy_id)
	{
		// Find the tenancy
		$tenancy = Tenancy::findOrFail($tenancy_id);

		// Check whether there is actually a service charge amount
		if ($tenancy->service_charge_amount <= 0) {
			return false;
		}

		// Make sure that the rent balance is greater or equal to the rent amount
		if ($tenancy->rent_balance < $tenancy->rent_amount) {
			return false;
		}

		$this->createServiceChargeItem($statement_id, $tenancy_id);

		return true;
	}

	/**
	 * Create an invoice through a statement.
	 * 
	 * @param array $data
	 * @param integer $statement_id
	 * @return \App\Invoice
	 */
	public function createInvoice($statement_id)
	{
		// Find the statement that we are creating this invoice for.
		$statement = Statement::findOrFail($statement_id);

		// Build the data array.
		$data['property_id'] = $statement->property->id;
		$data['users'] = $statement->property->owners;

		// Create and store the new invoice.
		$service = new InvoiceService();
		$invoice = $service->createInvoice($data);

		// Attach the invoice to the statement.
		$statement->invoices()->attach($invoice);

		// Return the invoice
		return $invoice;
	}

	/**
	 * Create an invoice item for this statement.
	 * 
	 * @param array $data
	 * @param integer $statement_id
	 * @return void
	 */
	public function createInvoiceItem(array $data, $statement_id)
	{
		// Find the statement
		$statement = Statement::findOrFail($statement_id);

		// Set the invoice.
		$invoice = $statement->invoice;

        // Should we not have a valid invoice, we create one.
        if (!$invoice) {
        	$invoice = $this->createInvoice($statement_id);
        }

        // Create and store the invoice item.
        $service = new InvoiceService();
        $service->createInvoiceItem($data, $invoice->id);

        return;
	}

	/**
	 * Create the service charge invoice item.
	 * 
	 * @param integer $statement_id
	 * @param integer $tenancy_id
	 * @return void
	 */
	public function createServiceChargeItem($statement_id, $tenancy_id)
	{
		// Find the tenancy.
		$tenancy = Tenancy::findOrFail($tenancy_id);

		// Build the data array.
		$data = [
            'name' => $tenancy->service->name,
            'description' => $tenancy->service->description,
            'quantity' => 1,
            'amount' => $tenancy->service_charge_amount,
            'tax_rate_id' => $tenancy->service->tax_rate_id
        ];

        // Create the invoice item.
        $this->createInvoiceItem($data, $statement_id);

        return;
	}

	public function createExpenseItem()
	{

	}

	public function togglePaid()
	{

	}

	public function toggleSend()
	{

	}

	public function sendToOwners()
	{

	}
}
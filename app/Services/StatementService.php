<?php

namespace App\Services;

use App\Jobs\SendStatement;
use App\Services\InvoiceService;
use App\Statement;
use App\StatementPayment;
use App\Tenancy;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

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
        $statement->user_id = Auth::user()->id;
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
        $this->createAutomaticServiceChargeInvoice($statement->id, $tenancy->id);

		return $statement;
	}

	/**
	 * Create an old statement.
	 * 
	 * @param array $data
	 * @param integer $id
	 * @return \App\Statement
	 */
	public function createOldStatement(array $data, $id)
	{
		// Find the tenancy.
		$tenancy = Tenancy::findOrFail($id);

		// Build the statement.
		$statement = new Statement();
		$statement->key = str_random(30);
		$statement->user_id = Auth::user()->id;
		$statement->created_at = Carbon::createFromFormat('Y-m-d', $data['created_at']);
		$statement->period_start = Carbon::createFromFormat('Y-m-d', $data['period_start']);
		$statement->period_end = Carbon::createFromFormat('Y-m-d', $data['period_end']);
		$statement->amount = $data['amount'];

		$statement->paid_at = $statement->created_at;
		$statement->sent_at = $statement->created_at;

		// Save the statement.
		$statement = $tenancy->statements()->save($statement);

		// Attach the property owners to the statement.
		$statement->users()->attach($tenancy->property->owners);

		// Record the rent amount received.
		if (isset($data['rent_received'])) {

			// Build an array for the payment.
			$payment_data = [
				'payment_method_id' => $data['payment_method_id'],
				'amount' => $data['rent_received'],
				'created_at' => $data['created_at']
			];

			// Create the rental payment.
			$service = new PaymentService();
			$service->createTenancyRentPayment($payment_data, $tenancy->id);
		}

		// Check whether we have any invoice items to add.
		if ($data['invoice_number']) {

            $total_items = count(array_where($data['item_name'], function ($value, $key) {
                return !is_null($value);
            }));

            // Add the invoice items should there be any.
            if (count($data['item_name'])) {
                for ($i = 0; $i < $total_items; $i++) {

                    $item['name'] = $data['item_name'][$i];
                    $item['description'] = $data['item_description'][$i];
                    $item['quantity'] = $data['item_quantity'][$i];
                    $item['amount'] = $data['item_amount'][$i];
                    $item['tax_rate_id'] = $data['item_tax_rate_id'][$i];

                    $item['number'] = $data['invoice_number']; // Invoice number.
                    $item['created_at'] = $data['created_at']; // Invoice created at date.
                    $item['paid_at'] = $data['created_at']; // Invoice paid at date.

                    $this->createInvoiceItem($item, $statement->id);
                }
            }
        }

        // Create the statement payments.
        $this->createStatementPayments($statement->id, $data['created_at']);

		return $statement;
	}

	/**
	 * Update the statement.
	 * 
	 * @param array $data
	 * @param integer $id
	 * @return \App\Statement
	 */
	public function updateStatement(array $data, $id)
	{
		$statement = Statement::findOrFail($id);

        // Set the period_start.
        if (isset($data['period_start'])) {
            $data['period_start'] = Carbon::createFromFormat('Y-m-d', $data['period_start']);
        }

        // Set the period_end.
        if (isset($data['period_end'])) {
            $data['period_end'] = Carbon::createFromFormat('Y-m-d', $data['period_end']);
        }

        // Update the created_at date.
        if (isset($data['created_at'])) {
            $statement->created_at = Carbon::createFromFormat('Y-m-d', $data['created_at']);
        }

        $statement->fill($data);
        $statement->save();

        // Update the statement settings for the property aswell.
        $service = new PropertyService();
        $service->updateStatementSettings(array_only($data, ['sending_method','bank_account_id']), $statement->property->id);

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
		if (!$tenancy->hasServiceCharge()) {
			return;
		}

		$this->createServiceChargeItem($statement_id, $tenancy);
	}

	/**
	 * Create an invoice through a statement.
	 * 
	 * @param array $data
	 * @param integer $statement_id
	 * @return \App\Invoice
	 */
	public function createInvoice($statement_id, $data = [])
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
        	$invoice = $this->createInvoice($statement_id, array_only($data, ['created_at','number']));
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
	public function createServiceChargeItem($statement_id, Tenancy $tenancy)
	{
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
	}

	/**
	 * Create and store a new expense item.
	 * 
	 * @param array $data
	 * @param integer $statement_id
	 * @return void
	 */
	public function createExpenseItem(array $data, $statement_id)
	{
		// Find the statement
		$statement = Statement::findOrFail($statement_id);

		// Add the property_id to the data.
		$data['property_id'] = $statement->property->id;

		// Create the expense.
		$service = new ExpenseService();
		$expense = $service->createExpense($data);

		// Attach the expense to the statement.
		$statement->expenses()->attach($expense, ['amount' => $data['cost']]);
	}

	/**
	 * Create all the payments out for the given statement.
	 * 
	 * @param integer $id
	 * @return void
	 */
	public function createStatementPayments($id, $sent = null)
	{
		$statement = Statement::findOrFail($id);

		$this->deleteStatementPayments($statement);

		$this->createInvoicePayment($statement, $sent);
		$this->createExpensePayment($statement, $sent);
		$this->createLandlordPayment($statement, $sent);
	}

	/**
	 * Delete all payments out for the given statement.
	 * 
	 * @param \App\Statement $statement
	 * @return void
	 */
	public function deleteStatementPayments(Statement $statement)
	{
		$statement->payments()->delete();
	}

	/**
	 * Create the statement invoice payment.
	 * 
	 * @param \App\Statement $statement
	 * @return void
	 */
	public function createInvoicePayment(Statement $statement, $sent = null)
	{
        if ($statement->hasInvoice()) {
        	$payment = new StatementPayment();
        	$payment->user_id = Auth::user()->id;
        	$payment->statement_id = $statement->id;
        	$payment->amount = $statement->invoice_total_amount;
        	$payment->sent_at = $sent;
        	$payment->bank_account_id = get_setting('company_bank_account_id', null);

        	// We attach the payment to the invoice statement payments
        	// (as we want the invoice to become the parent)
            $payment = $statement->invoice->statement_payments()->save($payment);

            // Attach the owners of the property to this payment as they have paid it.
            $payment->users()->attach($statement->tenancy->property->owners);
        }
	}

	/**
	 * Create the expense payments for the statement.
	 * 
	 * @param \App\Statement $statement
	 * @return void
	 */
	public function createExpensePayment(Statement $statement, $sent = null)
	{
		foreach ($statement->expenses as $expense) {
			$payment = new StatementPayment();
			$payment->user_id = Auth::user()->id;
			$payment->statement_id = $statement->id;
			$payment->amount = $expense->pivot->amount;
			$payment->sent_at = $sent;

			$expense->payments()->save($payment);

			// Attach the contractors to the payment.
			$payment->users()->attach($expense->contractors);
		}
	}

	/**
	 * Create the statement landlord payment.
	 * 
	 * @param \App\Statement $statement
	 * @return void
	 */
	public function createLandlordPayment(Statement $statement, $sent = null)
	{
		$payment = new StatementPayment();
		$payment->user_id = Auth::user()->id;
		$payment->statement_id = $statement->id;
		$payment->amount = $statement->landlord_balance_amount;
		$payment->sent_at = $sent;
		$payment->bank_account_id = $statement->property->bank_account_id;
		$payment->save();
	}

	/**
	 * Set the given statement payments as have being sent.
	 * 
	 * @param array $payments
	 * @return void
	 */
	public function setStatementPaymentsSent(array $payments)
	{
		foreach ($payments as $id) {
			$payment = StatementPayment::find($id);

			if (is_null($payment->sent_at)) {
				$payment->sent_at = Carbon::now();
				$payment->save();
			}
		}
	}

	/**
	 * Toggle the given statements as having been paid or unpaid.
	 * 
	 * @param array $ids
	 * @return string
	 */
	public function toggleStatementsPaid(array $ids)
	{
		foreach ($ids as $id) {

			// Find the statement
			$statement = Statement::findOrFail($id);

			if (is_null($statement->paid_at)) {
				$statement->paid_at = Carbon::now();
				$message = 'Paid';
			} else {
				$statement->paid_at = null;
				$message = 'Unpaid';
			}

			$statement->save();
		}

		// Return the correct message.
		if (count($ids) == 1) {
			return $message;
		} else {
			return 'Updated';
		}
	}

	/**
	 * Toggle the given statement as having been sent or unsent.
	 * 
	 * @param integer $ids
	 * @return string
	 */
	public function toggleStatementSent($id)
	{
		$statement = Statement::findOrFail($id);

		if (is_null($statement->sent_at)) {
			$statement->sent_at = Carbon::now();
			$message = 'Sent';
		} else {
			$statement->sent_at = null;
			$message = 'Unsent';
		}

		$statement->save();

		return $message;
	}

	/**
	 * Send the given statements to their owners.
	 * 
	 * @param mixed $ids
	 * @return void
	 */
	public function sendStatementsToOwners($ids)
	{
		if (!is_array($ids)) { $ids = explode(',', $ids); }

    	foreach($ids as $id) {

    		// Find the statement.
    		$statement = Statement::find($id);

    		// Dispatch the job.
    		dispatch(new SendStatement($statement));

            // Update the statement as have being sent.
            $statement->sent_at = Carbon::now();
            $statement->save();
        }
	}
}
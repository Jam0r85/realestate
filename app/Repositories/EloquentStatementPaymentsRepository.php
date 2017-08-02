<?php

namespace App\Repositories;

use App\StatementPayment;
use Carbon\Carbon;

class EloquentStatementPaymentsRepository extends EloquentBaseRepository
{
	/**
	 * Get the class name.
	 * 
	 * @return string
	 */
	public function getClassPath()
	{
		return 'App\StatementPayment';
	}

	/**
	 * Get all of the sent statement payments and return them paged.
	 * 
	 * @return \App\Repositories\EloquentStatementPaymentsRepository
	 */
	public function getSentPaged()
	{
		return $this->getInstance()->whereNotNull('sent_at')->latest()->paginate();
	}

	/**
	 * Get all of the unsent statement payments and return them paged.
	 * 
	 * @return \App\Repositories\EloquentStatementPaymentsRepository
	 */
	public function getUnsentGrouped()
	{
		$payments = $this->getInstance()->whereNull('sent_at')->get();
        $groups = $payments->groupBy('group')->sortBy('bank_account.name');

        return $groups;
	}

	/**
	 * Create the statement invoice payment.
	 * 
	 * @param  \App\Repositories\EloquentStatementRepository $statement
	 * @return void.
	 */
	public function createInvoicePayment($statement)
	{
        if ($statement->hasInvoice()) {        	
        	$data = [
        		'statement_id' => $statement->id,
        		'amount' => $statement->invoice->total,
        		'bank_account_id' => get_setting('company_bank_account_id')
        	];

            $statement->invoice->statement_payments()->save($this->create($data));
        }
	}

	/**
	 * Create the statement expense payments.
	 * 
	 * @param  \App\Repositories\EloquentStatementRepository $statement
	 * @return void.
	 */
	public function createExpensePayment($statement)
	{
		foreach ($statement->expenses as $expense) {
			$data = [
				'statement_id' => $statement->id,
				'amount' => $expense->pivot->amount,
				'parent_type' => 'expenses',
				'parent_id' => $expense->id
			];

			$payment = $this->create($data);

			$payment->users()->attach($expense->contractors);
		}
	}

	/**
	 * Create the statement landlord payment.
	 * 
	 * @param  \App\Repositories\EloquentStatementRepository $statement
	 * @return void.
	 */
	public function createLandlordPayment($statement)
	{
        $data =[
            'statement_id' => $statement->id,
            'amount' => $statement->landlord_balance_amount,
            'bank_account_id' => $statement->property->bank_account_id
        ];

        $this->create($data);
	}

	/**
	 * Create the statement payments for the given rental statement.
	 * 
	 * @param  \App\Statement $statement
	 * @return \App\Statement
	 */
	public function createPayments($statement)
	{
		$this->deletePayments($statement);

		$this->createInvoicePayment($statement);
		$this->createExpensePayment($statement);
		$this->createLandlordPayment($statement);

		return $statement;
	}

	/**
	 * Delete payments for a given statement.
	 * 
	 * @param  \App\Statement $statement
	 * @return void.
	 */
	public function deletePayments($statement)
	{
		$statement->payments()->delete();
	}

	/**
	 * Update the given payments and mark them as sent.
	 * 
	 * @param  array  $payments
	 * @return void
	 */
	public function sendPayments(array $payment_ids)
	{
		foreach ($payment_ids as $id) {
			$this->sendPayment($id);
		}

		return back();
	}

	/**
	 * Send a single payment.
	 * 
	 * @param  \App\StatementPayment $id
	 * @return \App\StatementPayment
	 */
	public function sendPayment($id)
	{
		$payment = $this->find($id);
		$payment->setSent();
		return $payment;
	}
}
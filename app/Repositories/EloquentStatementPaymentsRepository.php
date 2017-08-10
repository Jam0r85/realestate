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
		return $this->getInstance()
			->whereNotNull('sent_at')
			->latest('sent_at')
			->paginate();
	}

	/**
	 * Get all of the unsent statement payments and return them paged.
	 * 
	 * @return \App\Repositories\EloquentStatementPaymentsRepository
	 */
	public function getUnsentGrouped()
	{
		$payments = $this->getInstance()->whereNull('sent_at')->get();
        $groups = $payments->groupBy('group')->sortBy('bank_account.account_name');

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

	}

	/**
	 * Create the statement expense payments.
	 * 
	 * @param  \App\Repositories\EloquentStatementRepository $statement
	 * @return void.
	 */
	public function createExpensePayment($statement)
	{

	}

	/**
	 * Create the statement landlord payment.
	 * 
	 * @param  \App\Repositories\EloquentStatementRepository $statement
	 * @return void.
	 */
	public function createLandlordPayment($statement)
	{

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
	public function markPaymentsSent(array $payment_ids)
	{
		StatementPayment::whereIn('id', $payment_ids)
			->whereNull('sent_at')
			->update(['sent_at' => Carbon::now()]);

		$this->successMessage('The statement payments were marked as sent');

		return back();
	}
}
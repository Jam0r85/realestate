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
        $groups = $payments->groupBy('parent_type');

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
            $statement->invoice->statement_payments()->save(
                StatementPayment::create([
                    'statement_id' => $statement->id,
                    'amount' => $statement->invoice->total,
                    'bank_account_id' => get_setting('company_bank_account_id')
                ])
            );
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
			$payment = StatementPayment::create([
				'statement_id' => $statement->id,
				'amount' => $expense->pivot->amount,
				'parent_type' => 'expenses',
				'parent_id' => $expense->id
			]);

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
        StatementPayment::create([
            'statement_id' => $statement->id,
            'amount' => $statement->landlord_balance_amount,
            'bank_account_id' => $statement->property->bank_account_id
        ]);
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
	 * Mark the provided payments as have being sent.
	 * 
	 * @param  array  $payments
	 * @return void
	 */
	public function sendPayments(array $payment_ids)
	{
		foreach ($payment_ids as $id) {

			$data = [
				'sent_at' => Carbon::now()
			];

			$payment = $this->update($data, $id);

			// Should the statement have no more unsent payments, it needs to be marked as paid.
			if (!$payment->statement->hasUnsentPayments()) {
				$payment->statement()->update($data);
			}
		}

		return back();
	}
}
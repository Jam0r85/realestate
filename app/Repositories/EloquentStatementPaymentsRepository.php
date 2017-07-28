<?php

namespace App\Repositories;

use App\StatementPayment;

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
	public function getUnsentPaged()
	{
		return $this->getInstance()->whereNull('sent_at')->latest()->paginate();
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
	 * Create the individual payments for a rental statement.
	 * 
	 * @param  \App\Repositories\EloquentStatementRepository $statement
	 * @return \App\Repositories\EloquentStatementRepository
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
	 * Delete the current statement payments.
	 * 
	 * @param  \App\Repositories\EloquentStatementRepository $statement
	 * @return void.
	 */
	public function deletePayments($statement)
	{
		$statement->payments()->delete();
	}
}
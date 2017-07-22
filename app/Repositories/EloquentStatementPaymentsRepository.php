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
		return $this->getInstance()->whereNotNull('sent_at')->where('parent_type', '!=', 'invoices')->paginate();
	}

	/**
	 * Get all of the unsent statement payments and return them paged.
	 * 
	 * @return \App\Repositories\EloquentStatementPaymentsRepository
	 */
	public function getUnsentPaged()
	{
		return $this->getInstance()->whereNull('sent_at')->paginate();
	}
}
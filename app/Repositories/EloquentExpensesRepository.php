<?php

namespace App\Repositories;

use App\Expense;

class EloquentExpensesRepository extends EloquentBaseRepository
{
	/**
	 * Get the class name.
	 * 
	 * @return string
	 */
	public function getClassPath()
	{
		return 'App\Expense';
	}

	/**
	 * Create a new expense.
	 * 
	 * @param  array  $data
	 * @return mixed
	 */
	public function createExpense(array $data)
	{
		return $this->create($data);
	}
}
<?php

namespace App\Repositories;

use App\BankAccount;

class EloquentBankAccountsRepository extends EloquentBaseRepository
{
	/**
	 * Get the class name.
	 * 
	 * @return string
	 */
	public function getClassPath()
	{
		return 'App\BankAccount';
	}
}
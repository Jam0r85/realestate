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

	/**
	 * Create a new bank account.
	 * 
	 * @param  array  $data
	 * @return mixed
	 */
	public function createBankAccount(array $data)
	{
		$account = $this->create($data);

		if ($data['users']) {
			$account->users()->attach($data['users']);
		}

		return $account;
	}
}
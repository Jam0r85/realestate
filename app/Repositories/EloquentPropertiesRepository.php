<?php

namespace App\Repositories;

use App\Property;

class EloquentPropertiesRepository extends EloquentBaseRepository
{
	/**
	 * Get the class name.
	 * 
	 * @return string
	 */
	public function getClassPath()
	{
		return 'App\Property';
	}

	/**
	 * Create a new property.
	 * 
	 * @param  array  $data
	 * @return
	 */
	public function createProperty(array $data)
	{
		$property = $this->create($data);

		return $property;
	}

	/**
	 * Update the bank account for the property.
	 * 
	 * @param  integer $account_id
	 * @param  App\Property $id
	 * @return mixed
	 */
	public function updateBankAccount($account_id, $id)
	{
		$property = $this->find($id);

		$property->update(['bank_account_id' => $account_id]);

		$this->successMessage('The bank account was updated');

		return $property;

	}
}
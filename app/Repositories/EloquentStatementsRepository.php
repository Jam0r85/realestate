<?php

namespace App\Repositories;

use App\Tenancy;
use App\Statement;
use Carbon\Carbon;

class EloquentStatementsRepository extends EloquentBaseRepository
{
	/**
	 * Get the class name.
	 * 
	 * @return string
	 */
	public function getClassPath()
	{
		return 'App\Statement';
	}

	/**
	 * Create a new statement for a tenancy.
	 * 
	 * @param  array  $data
	 * @param  [type] $tenancy [description]
	 * @return [type]          [description]
	 */
	public function createStatement(array $data, $tenancy)
	{
		// Find the tenancy.
		$tenancy = Tenancy::findOrFail($tenancy);

		// Build the data array.
		$data['tenancy_id'] = $tenancy->id;
		$data['key'] = str_random(30);

		// Set the statement amount.
		if (!isset($data['amount'])) {
			$data['amount'] = $tenancy->rent_amount;
		}

		// Set the statement start period.
		if (!isset($data['period_start'])) {
			$data['period_start'] = $tenancy->next_statement_start_date;
		}

		// Set the statement end period.
		if (!isset($data['period_end'])) {
			$data['period_end'] = Carbon::createFromFormat('Y-m-d', $data['period_start'])->addMonth()->subDay();
		}

		$statement = $this->create($data);

		$statement->users()->attach($tenancy->property->owners);

		return $statement;
	}
}
<?php

namespace App\Settings;

use App\Statement;

class StatementData
{
	protected $statement;

	/**
	 * Allowed data keys and their default values
	 * 
	 * @var array
	 */
	protected $keysWithDefaultValues = [
		'queued_to_be_sent_date' => null
	];

	public function __construct(Statement $statement)
	{
		$this->statement = $statement;
	}

	/**
	 * Allowed key names to be stored.
	 * 
	 * @return array
	 */
	public function allowed()
	{
		return array_keys($this->keysWithDefaultValues);
	}

	/**
	 * Merge the settings in storage.
	 * 
	 * @param array $attributes
	 * @return 
	 */
	public function merge(array $attributes)
	{
		$current_data = $this->statement->data;

		if (!is_array($current_data)) {
			$current_data = [];
		}

		$data = array_merge(
			$current_data,
			array_only($attributes, $this->allowed())
		);

		return $this->statement->update(compact('data'));
	}
}
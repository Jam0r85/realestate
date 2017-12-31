<?php

namespace App\Traits;

trait DataTrait
{
	/**
	 * The table column we are using.
	 * 
	 * @var string
	 */
	public $dataColumn = 'data';

	/**
	 * Get the value of a key held in the data.
	 * 
	 * @param  string  $key  the key we want the value for
	 * @return  mixed  $key  the value of the data
	 */
	public function getData($key)
	{
		$column = $this->dataColumn;
		$existing_data = $this->$column;

		if (is_array($existing_data) && !array_key_exists($key, $existing_data)) {
			return null;
		}

		return $existing_data[$key];
	}

	/**
	 * Set a key and it's value in the data.
	 * 
	 * @param  string  $key  the key for the data
	 * @param  string  $value  the value for the key
	 */
	public function setData(array $data)
	{
		if (!$this->dataKeys) {
			
		}

		$column = $this->dataColumn;
		$existing_data = $this->$column;

		// Store the key and value in the data.
		foreach ($data as $key => $value) {

			// Check that the key is allowed.
			if (in_array($key, $this->dataKeys)) {
				$existing_data[$key] = $value;
			}
		}

		// Update the current data.
		$this->$column = $existing_data;

		return $this;
	}

	/**
	 * Store the data.
	 * 
	 * @param  array  $data  the array of keys => values we are storing.
	 * @param  boolean  $save  save the data or just return it?
	 * @return 
	 */
	public function storeData(array $data)
	{
		$this->setData($data);
		$this->saveWithMessage('data saved');
		return $this;
	}
}
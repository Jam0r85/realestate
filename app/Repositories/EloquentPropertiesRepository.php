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
}
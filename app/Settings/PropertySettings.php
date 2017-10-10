<?php

namespace App\Settings;

use App\Property;

class PropertySettings
{
	protected $property;

	/**
	 * Allowed setting keys and their default values
	 * 
	 * @var array
	 */
	protected $keysWithDefaultValues = [
		'statement_send_method' => 'post'
	];

	public function __construct(Property $property)
	{
		$this->property = $property;
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
	public function merge(array $attributes, $force = false)
	{
		if ($force == true) {
			$settings = $attributes;
		} else {
			$settings = array_merge(
				$this->property->settings,
				array_only($attributes, $this->allowed())
			);
		}

		return $this->property->update(compact('settings'));
	}

	/**
	 * Store the default settings.
	 */
	public function storeDefault()
	{
		return $this->property->update([
			'settings' => $this->keysWithDefaultValues
		]);
	}
}
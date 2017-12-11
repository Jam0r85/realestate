<?php

namespace App\Traits;

trait SettingsTrait
{
	/**
	 * The table column we are using.
	 * 
	 * @var string
	 */
	public $settingColumn = 'settings';

	/**
	 * Get the setting column.
	 * 
	 * @return  string
	 */
	public function getSettingColumn()
	{
		if (!$this->settingColumn) {
			//
		}

		return $this->settingColumn;
	}

	/**
	 * The allowed keys to be stored inside the setting column.
	 * 
	 * @return  array;
	 */
	public function getAllowedKeys()
	{
		if (!$this->settingKeys) {
			return null;
		}

		return $this->settingKeys;
	}

	/**
	 * Get the value of a key held in the table.
	 * 
	 * @param  string  $key
	 * @return  mixed  $key
	 */
	public function getSetting($key)
	{
		$column = $this->getSettingColumn();
		$existing_settings = $this->$column;

		if (is_array($existing_settings) && !array_key_exists($key, $existing_settings)) {
			return null;
		}

		return $existing_settings[$key];
	}

	/**
	 * Set a key and it's value in the table.
	 * 
	 * @param  array  $setting
	 */
	public function setSetting(array $setting)
	{
		$column = $this->getSettingColumn();
		$existing_settings = $this->$column;

		// Store the key and value in the table.
		foreach ($setting as $key => $value) {
			if (in_array($key, $this->getAllowedKeys())) {
				$existing_settings[$key] = $value;
			}
		}

		// Update the current data.
		$this->$column = $existing_settings;

		return $this;
	}

	/**
	 * Store the setting.
	 * 
	 * @param  array  $data
	 * @return 
	 */
	public function storeSetting(array $data)
	{
		$this->setSetting($data);
		$this->save();

		return $this;
	}
}
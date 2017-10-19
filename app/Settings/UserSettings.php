<?php

namespace App\Settings;

use App\User;

class UserSettings
{
	protected $user;

	/**
	 * Allowed setting keys and their default values
	 * 
	 * @var array
	 */
	protected $keysWithDefaultValues = [
		'site_admin' => null,
		'calendar_event_color' => 'post'
	];

	public function __construct(User $user)
	{
		$this->user = $user;
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
		$current_settings = $this->user->settings;

		if (!is_array($current_settings)) {
			$current_settings = [];
		}

		if ($force == true) {
			$settings = $attributes;
		} else {
			$settings = array_merge(
				$current_settings,
				array_only($attributes, $this->allowed())
			);
		}

		return $this->user->update(compact('settings'));
	}

	/**
	 * Store the default settings.
	 *
	 * @param array $overwrite
	 */
	public function storeDefault($overwrite = [])
	{
		$settings = array_merge($overwrite, $this->keysWithDefaultValues);

		return $this->user->update([
			'settings' => $settings
		]);
	}
}
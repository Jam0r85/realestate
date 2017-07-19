<?php

namespace App\Repositories;

use App\Setting;
use Illuminate\Support\Facades\Cache;

class EloquentSettingsRepository extends EloquentBaseRepository
{
	/**
	 * Get the class name.
	 * 
	 * @return string
	 */
	public function getClassPath()
	{
		return 'App\Setting';
	}

	/**
	 * Save the settings into the setting table.
	 * 
	 * @param  array  $data
	 * @return void
	 */
	public function save(array $data)
	{
		foreach ($data as $key => $value) {
			if (in_array($key, $this->getInstance(false)->keys())) {
				if (empty($value)) { $value = null; }
				Setting::where('key', $key)->update(['value' => $value]);
			}
		}

		Cache::forget('site.settings');

		$this->customFlashMessage('The settings were updated.');
	}
}
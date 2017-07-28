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
		foreach ($data as $item) {

			$exists = Setting::where('key', $item['key'])->first();

			if ($exists) {
				Setting::where('key', $item['key'])->update(['value' => $item['value']]);
			} else {
				Setting::create(['key' => $item['key'], 'value' => $item['value']]);
			}
		}

		Cache::forget('site.settings');

		$this->successMessage('The settings were updated.');
	}
}
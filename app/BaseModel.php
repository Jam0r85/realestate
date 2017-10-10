<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
	/**
	 * Set the page limit for pagination.
	 * 
	 * @var integer
	 */
	protected $perPage = 30;

	/**
	 * Model can have many settings.
	 */
	public function oldSettings()
	{
		return $this->morphMany('App\Setting', 'parent');
	}

	/**
	 * Check whether the model has a setting.
	 * 
	 * @param  string $key
	 * @return bool
	 */
	public function hasSetting($key)
	{
		return $this->oldSettings()->where('key', $key)->whereNotNull('value')->first();
	}

	/**
	 * Store a setting for a model.
	 * 
	 * @param  [type] $key   [description]
	 * @param  [type] $value [description]
	 * @return [type]        [description]
	 */
	public function storeSetting($key, $value = null)
	{
		$exists = $this->oldSettings()->where('key', $key)->first();

		if ($exists) {
			$this->oldSettings()->where('key', $key)->update(['value' => $value]);
		} else {
			$this->oldSettings()->create(['key' => $key, 'value' => $value]);
		}
	}
}
<?php

namespace App\Presenters;

use Laracasts\Presenter\Presenter;

class UserPresenter extends Presenter
{
	/**
	 * @return string
	 */
	public function fullName()
	{
		return $this->company_name ?? $this->first_name . ' ' . $this->last_name;
	}

	/**
	 * @return string
	 */
	public function location($length = 'short', $data = false)
	{
		$length = $length . 'Address';

		foreach ($this->tenancies as $tenancy) {
			if ($tenancy->isActive()) {
				$model = $tenancy->property;
				$value = $tenancy->property->present()->$length;
			}
		}

		if ($this->home) {
			$model = $this->home;
			$value = $this->home->present()->$length;
		}

		if ($data == true && isset($value) && isset($model)) {
			return [
				'name' => $value,
				'data' => $model
			];
		}

		return isset($value) ? $value : null;
	}

	/**
	 * @return string
	 */
	public function locationLink($length = 'short')
	{
		$address = $this->location($length, true);
		return '<a href="' . route('properties.show', $address['data']['id']) . '">' . $address['name'] . '</a>';
	}

	/**
	 * @return string
	 */
	public function selectName()
	{
		$value = $this->fullName;

		if ($this->email) {
			$value .= ' (' . $this->email . ')';
		}

		return $value;
	}
}
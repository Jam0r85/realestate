<?php

namespace App\Services;

use App\GasSafeReminder;
use Illuminate\Support\Facades\Auth;

class GasSafeService
{
	/**
	 * Create a new gas safe reminder.
	 * 
	 * @param array $data
	 * @return \App\GasSafeReminder
	 */
	public function createGasSafeReminder(array $data)
	{
		$reminder = new GasSafeReminder();
		$reminder->user_id = Auth::user()->id;
		$reminder->property_id = $data['property_id'];
		$reminder->expires_on = $data['expires_on'];
		$reminder->save();

		if (isset($data['contractors'])) {
			$reminder->contractors()->attach($data['contractors']);
		}

		return $reminder;
	}

}
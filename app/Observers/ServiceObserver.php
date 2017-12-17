<?php

namespace App\Observers;

use App\Service;

class ServiceObserver
{
	/**
	 * Listen to the Service creating event.
	 * 
	 * @param  \App\Service  $service
	 * @return void
	 */
	public function creating(Service $service)
	{
		$service->slug = $service->name;
	}
}
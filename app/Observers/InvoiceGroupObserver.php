<?php

namespace App\Observers;

use App\InvoiceGroup;
use Illuminate\Support\Facades\Auth;

class InvoiceGroupObserver
{
	/**
	 * Listen to the InvoiceGroup creating event.
	 * 
	 * @param \App\InvoiceGroup $group
	 * @return void
	 */
	public function creating(InvoiceGroup $group)
	{
		$group->slug = str_slug($group->name);
	}
}
<?php

namespace App\Repositories;

use App\InvoiceGroup;

class EloquentInvoiceGroupsRepository extends EloquentBaseRepository
{
	/**
	 * Get the class name.
	 * 
	 * @return string
	 */
	public function getClassPath()
	{
		return 'App\InvoiceGroup';
	}
}
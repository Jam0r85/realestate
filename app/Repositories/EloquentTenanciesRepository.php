<?php

namespace App\Repositories;

use App\Tenancy;

class EloquentTenanciesRepository extends EloquentBaseRepository
{
	/**
	 * Get the class name.
	 * 
	 * @return string
	 */
	public function getClassPath()
	{
		return 'App\Tenancy';
	}
}
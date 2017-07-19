<?php

namespace App\Repositories;

use App\Branch;

class EloquentBranchesRepository extends EloquentBaseRepository
{
	/**
	 * Get the class name.
	 * 
	 * @return string
	 */
	public function getClassPath()
	{
		return 'App\Branch';
	}
}
<?php

namespace App\Repositories;

use App\Role;

class EloquentRolesRepository extends EloquentBaseRepository
{
	/**
	 * Get the class name.
	 * 
	 * @return string
	 */
	public function getClassPath()
	{
		return 'App\Role';
	}

	/**
	 * Create a new role.
	 * 
	 * @param  array  $data
	 * @return mixed
	 */
	public function createRole(array $data)
	{
		$role = $this->create($data);

		if (isset($data['permission_id'])) {
			$role->permissions()->attach($data['permission_id']);
		}

		return $role;
	}
}
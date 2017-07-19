<?php

namespace App\Repositories;

use App\UserGroup;

class EloquentUserGroupsRepository extends EloquentBaseRepository
{
	/**
	 * Get the class name.
	 * 
	 * @return string
	 */
	public function getClassPath()
	{
		return 'App\UserGroup';
	}

	/**
	 * Create a new user group.
	 * 
	 * @param  array  $data
	 * @return user
	 */
	public function createUserGroup(array $data)
	{
		$data['slug'] = $data['name'];
		$user_group = $this->create($data);

		return $user_group;
	}

	/**
	 * Update a user group.
	 * 
	 * @param  array  $data
	 * @return user
	 */
	public function updateUserGroup(array $data, $model)
	{
		$data['slug'] = $data['name'];
		$user_group = $this->update($data, $model);

		return $user_group;
	}
}
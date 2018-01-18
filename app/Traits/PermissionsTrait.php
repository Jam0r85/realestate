<?php

namespace App\Traits;

use App\Permission;

trait PermissionsTrait
{
	public function permissions()
	{
		return $this
			->belongsToMany(Permission::class);
	}

	/**
	 * Check whether a permission exists with the given slug.
	 * 
	 * @param  string  $slug
	 * @return boolean
	 */
	public function hasPermission(string $slug)
	{
		return $this->permissions->where('slug', $slug->exists());
	}
}
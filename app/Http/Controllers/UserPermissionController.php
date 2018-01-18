<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserPermissionController extends BaseController
{
	/**
	 * The eloquent model for this controller.
	 * 
	 * @var string
	 */
	protected $model = 'App\Permission';

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
	public function update(Request $request, $id)
	{
		$user = User::withTrashed()->findOrFail($id);

		$data = $request->except('_token','_method');

		foreach ($data as $slug => $value) {
			if (is_null($value)) {
				unset($data[$slug]);
			}
		}

		$permissions = $this->repository
			->whereIn('slug', array_keys($data))
			->pluck('id');

		$user->permissions()->sync($permissions);

		flash_message('The users permissions were updated');

		return back();
	}
}

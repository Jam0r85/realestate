<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserPasswordUpdateRequest;
use App\User;
use Illuminate\Http\Request;

class UserPasswordController extends BaseController
{
    /**
     * The eloquent model for this controller.
     * 
     * @var string
     */
    protected $model = 'App\User';

	/**
	 * Change the user's password in storage.
	 * 
	 * @param  \App\Http\Requests\UserPasswordUpdateRequest  $request
	 * @param  integer  $id
	 * @return \Illuminate\Http\Response
	 */
    public function changePassword(UserPasswordUpdateRequest $request, $id)
    {
    	$user = $this->repository->withTrashed()->findOrFail($id);

    	$this->storePassword($user, $request->password);

    	return back();
    }

    /**
     * Store the updated password in storage.
     * 
     * @param  \App\User  $user
     * @param  string  $password
     * @return void
     */
    public function storePassword(User $user, $password)
    {
    	$user->password = bcrypt($password);
    	$user->saveWithMessage('password was updated');
    }
}

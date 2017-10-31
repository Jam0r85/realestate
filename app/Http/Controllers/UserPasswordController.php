<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserPasswordUpdateRequest;
use App\User;
use Illuminate\Http\Request;

class UserPasswordController extends BaseController
{
	/**
	 * Change the user's password in storage.
	 * 
	 * @param \App\Http\Requests\UserPasswordUpdateRequest $request
	 * @param integer $id
	 * @return \Illuminate\Http\Response
	 */
    public function changePassword(UserPasswordUpdateRequest $request, $id)
    {
    	$user = User::findOrFail($id);

    	$this->storePassword($user, $request->password);

    	$this->response($request);
    	return back();
    }

    /**
     * Store the updated password in storage.
     * 
     * @param string $user
     * @param string $password
     * @return void
     */
    public function storePassword($user, $password)
    {
    	$user->password = bcrypt($password);
    	$user->save();
    }

    /**
     * The response when the password is changed.
     * 
     * @return string
     */
    public function response()
    {
        $this->successMessage('The password was updated');
    }
}
